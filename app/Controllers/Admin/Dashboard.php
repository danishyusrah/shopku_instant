<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $orderModel;
    protected $productModel;
    protected $userModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Mendapatkan data untuk grafik (7 hari terakhir)
        $db = \Config\Database::connect();
        $salesChartData = $db->table('orders')
            ->select("DATE_FORMAT(created_at, '%d %b') as date, SUM(total_price) as total")
            ->where('status', 'completed')
            ->where('created_at >=', date('Y-m-d', strtotime('-7 days')))
            ->groupBy('date')
            ->orderBy('created_at', 'ASC')
            ->get()->getResult();

        $chart_labels = array_column($salesChartData, 'date');
        $chart_values = array_column($salesChartData, 'total');

        // Metrik Otomatisasi Baru
        $data = [
            'app_name'          => env('APP_NAME', 'AzureVault'),
            'total_users'       => $this->userModel->where('role', 'customer')->countAllResults(),
            'total_balance'     => $this->userModel->selectSum('balance')->first()->balance ?? 0,
            'total_orders'      => $this->orderModel->countAll(),
            'total_revenue'     => $this->orderModel->selectSum('total_price')->where('status', 'completed')->first()->total_price ?? 0,
            'ready_stock'       => $db->table('accounts_inventory')->where('is_sold', 0)->countAllResults(),
            'low_stock'         => $this->productModel->where('stock <', 5)->findAll(),
            'pending_topups'    => $db->table('topups')->where('status', 'pending')->countAllResults(),
            'recent_orders'     => $this->orderModel->select('orders.*, users.username, products.name as product_name')
                ->join('products', 'products.id = orders.product_id')
                ->join('users', 'users.id = orders.user_id')
                ->orderBy('orders.created_at', 'DESC')
                ->limit(5)
                ->get()->getResult(),
            'chart_labels'      => $chart_labels,
            'chart_values'      => $chart_values,
            'title'             => 'Admin Overview'
        ];

        return view('admin/dashboard', $data);
    }
}
