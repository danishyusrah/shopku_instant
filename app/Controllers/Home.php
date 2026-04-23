<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Home extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index(): string
    {
        // Mengambil data produk
        $products = $this->productModel->getProductsWithCategory()->findAll();

        // Memproses features untuk setiap produk agar siap ditampilkan di view
        foreach ($products as $product) {
            $product->features_array = $this->productModel->formatFeatures($product->features);
        }

        // Menyiapkan data meta & UI dari .env
        $data = [
            'app_name'        => env('APP_NAME', 'AzureVault'),
            'app_tagline'     => env('APP_TAGLINE'),
            'hero_title'      => env('APP_HERO_TITLE'),
            'hero_description' => env('APP_DESCRIPTION'),
            'admin_whatsapp'  => env('ADMIN_WHATSAPP'),
            'products'        => $products,
        ];

        return view('home', $data);
    }

    /**
     * Halaman riwayat/semua produk dengan Pagination
     */
    public function history(): string
    {
        $limit = env('PAGINATION_LIMIT', 6);

        $data = [
            'app_name' => env('APP_NAME', 'AzureVault'),
            'products' => $this->productModel->paginate($limit, 'group1'),
            'pager'    => $this->productModel->pager,
            'title'    => 'Riwayat Transaksi & Katalog'
        ];

        return view('history', $data);
    }
}
