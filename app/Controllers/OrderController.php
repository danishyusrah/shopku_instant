<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\ProductModel;

class OrderController extends BaseController
{
    protected $orderModel;
    protected $productModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->productModel = new ProductModel();
    }

    /**
     * Memproses checkout produk dengan validasi stok dan integrasi WhatsApp.
     */
    public function checkout()
    {
        // Validasi input minimal
        if (!$this->validate(['product_id' => 'required|is_natural_no_zero'])) {
            return redirect()->back()->with('error', 'Permintaan tidak valid.');
        }

        $productId = $this->request->getPost('product_id');
        $product = $this->productModel->find($productId);

        // Pastikan produk ada dan stok tersedia
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan atau sudah dihapus.');
        }

        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok untuk paket ini sedang kosong.');
        }

        try {
            // Data transaksi
            $orderRef = $this->orderModel->generateReference();
            $orderData = [
                'order_ref'         => $orderRef,
                'customer_name'     => 'Guest User', // Bisa dikembangkan dengan input form di masa depan
                'customer_whatsapp' => env('ADMIN_WHATSAPP'),
                'product_id'        => $product->id,
                'total_price'       => $product->price,
                'status'            => 'pending'
            ];

            // Simpan ke Database
            if (!$this->orderModel->insert($orderData)) {
                return redirect()->back()->with('error', 'Gagal memproses pesanan. Silakan coba lagi.');
            }

            // Kurangi stok (fitur profesional untuk mencegah overselling)
            $this->productModel->update($product->id, [
                'stock' => $product->stock - 1
            ]);

            // Persiapan Pesan WhatsApp Dinamis (No Hardcode)
            $appName = env('APP_NAME', 'AzureVault');
            $waNumber = env('ADMIN_WHATSAPP');

            $message = "Halo *{$appName}*,\n\n";
            $message .= "Saya ingin melakukan pemesanan akun Azure Student:\n\n";
            $message .= "─── *DETAIL PESANAN* ───\n";
            $message .= "📦 *Paket:* {$product->name}\n";
            $message .= "🎫 *No. Ref:* #{$orderRef}\n";
            $message .= "💰 *Total:* Rp" . number_format($product->price, 0, ',', '.') . "\n";
            $message .= "──────────────────\n\n";
            $message .= "Mohon informasi nomor rekening dan panduan selanjutnya. Terima kasih.";

            $url = "https://wa.me/{$waNumber}?text=" . urlencode($message);

            // Redirect ke WhatsApp
            return redirect()->to($url);
        } catch (\Exception $e) {
            // Log error untuk debugging admin
            log_message('error', '[Checkout Error] ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Silakan hubungi admin.');
        }
    }
}
