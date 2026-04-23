<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class AccountController extends BaseController
{
    protected $db;
    protected $productModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->productModel = new ProductModel();
    }

    /**
     * Menampilkan daftar inventori akun yang siap dijual
     */
    public function index()
    {
        $data = [
            'app_name' => env('APP_NAME', 'AzureVault'),
            'products' => $this->productModel->findAll(),
            'accounts' => $this->db->table('accounts_inventory')
                ->select('accounts_inventory.*, products.name as product_name')
                ->join('products', 'products.id = accounts_inventory.product_id')
                ->orderBy('accounts_inventory.created_at', 'DESC')
                ->get()->getResult(),
            'title'    => 'Inventori Akun Otomatis'
        ];

        return view('admin/accounts/index', $data);
    }

    /**
     * Menyimpan akun dalam jumlah banyak (Bulk Import)
     */
    public function bulk_store()
    {
        $productId = $this->request->getPost('product_id');
        $rawList = $this->request->getPost('account_list');

        // Memisahkan list berdasarkan baris baru
        $accounts = explode("\n", str_replace("\r", "", $rawList));
        $count = 0;

        foreach ($accounts as $cred) {
            $cred = trim($cred);
            if (!empty($cred)) {
                $this->db->table('accounts_inventory')->insert([
                    'product_id'  => $productId,
                    'credentials' => $cred,
                    'is_sold'     => 0
                ]);
                $count++;
            }
        }

        // Update stok di tabel produk utama
        $product = $this->productModel->find($productId);
        $this->productModel->update($productId, ['stock' => $product->stock + $count]);

        return redirect()->back()->with('success', "Berhasil menambahkan {$count} akun ke inventori.");
    }

    /**
     * Menghapus satu data inventori
     */
    public function delete($id)
    {
        $account = $this->db->table('accounts_inventory')->where('id', $id)->get()->getRow();
        if ($account) {
            // Jika belum terjual, kurangi stok produk
            if (!$account->is_sold) {
                $product = $this->productModel->find($account->product_id);
                $this->productModel->update($account->product_id, ['stock' => $product->stock - 1]);
            }
            $this->db->table('accounts_inventory')->where('id', $id)->delete();
        }

        return redirect()->back()->with('success', 'Data inventori dihapus.');
    }
}
