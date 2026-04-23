<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    /**
     * Menampilkan daftar produk untuk dikelola
     */
    public function index()
    {
        $data = [
            'app_name' => env('APP_NAME', 'AzureVault'),
            'products' => $this->productModel->getProductsWithCategory()->findAll(),
            'title'    => 'Kelola Stok Azure'
        ];

        return view('admin/products/index', $data);
    }

    /**
     * Menyimpan produk baru ke database
     */
    public function store()
    {
        $validation = $this->validate([
            'name'  => 'required|min_length[3]',
            'price' => 'required|numeric',
            'stock' => 'required|is_natural',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('error', 'Cek kembali inputan Anda.');
        }

        // Memproses fitur dari string (pisahkan dengan koma) menjadi JSON
        $featuresRaw = $this->request->getPost('features');
        $featuresArray = array_map('trim', explode(',', $featuresRaw));

        $data = [
            'category_id'    => $this->request->getPost('category_id') ?: 1,
            'name'           => $this->request->getPost('name'),
            'price'          => $this->request->getPost('price'),
            'stock'          => $this->request->getPost('stock'),
            'features'       => json_encode($featuresArray),
            'is_recommended' => $this->request->getPost('is_recommended') ? 1 : 0,
        ];

        if ($this->productModel->insert($data)) {
            return redirect()->back()->with('success', 'Produk berhasil ditambahkan.');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan produk.');
    }

    /**
     * Memperbarui data produk yang sudah ada
     */
    public function update($id = null)
    {
        $featuresRaw = $this->request->getPost('features');
        $featuresArray = array_map('trim', explode(',', $featuresRaw));

        $data = [
            'category_id'    => $this->request->getPost('category_id'),
            'name'           => $this->request->getPost('name'),
            'price'          => $this->request->getPost('price'),
            'stock'          => $this->request->getPost('stock'),
            'features'       => json_encode($featuresArray),
            'is_recommended' => $this->request->getPost('is_recommended') ? 1 : 0,
        ];

        if ($this->productModel->update($id, $data)) {
            return redirect()->back()->with('success', 'Produk berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui produk.');
    }

    /**
     * Menghapus produk dari sistem
     */
    public function delete($id = null)
    {
        if ($this->productModel->delete($id)) {
            return redirect()->back()->with('success', 'Produk berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Gagal menghapus produk.');
    }

    /**
     * Memperbarui stok secara cepat (Fast Update)
     */
    public function update_quick()
    {
        $id = $this->request->getPost('id');
        $stock = $this->request->getPost('stock');

        if ($this->productModel->update($id, ['stock' => $stock])) {
            return redirect()->back()->with('success', 'Stok berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Gagal memperbarui stok.');
    }
}
