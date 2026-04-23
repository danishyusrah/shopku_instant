<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class Dashboard extends BaseController
{
    protected $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    /**
     * Menampilkan dashboard utama pengguna beserta daftar akun yang telah dibeli.
     */
    public function index()
    {
        $userId = session()->get('id');

        $data = [
            'app_name'    => env('APP_NAME', 'AzureVault'),
            'title'       => 'Dashboard Saya',
            // Mengambil akun yang dibeli oleh user ini
            'my_accounts' => $this->orderModel->select('orders.*, products.name as product_name')
                ->join('products', 'products.id = orders.product_id')
                ->where('user_id', $userId)
                ->orderBy('orders.created_at', 'DESC')
                ->get()->getResult(),
        ];

        return view('user/dashboard', $data);
    }
}
