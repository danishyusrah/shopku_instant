<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\UserModel;

class Purchase extends BaseController
{
    public function order()
    {
        $userId = session()->get('id');
        $productId = $this->request->getPost('product_id');

        $db = \Config\Database::connect();
        $user = (new UserModel())->find($userId);
        $product = (new ProductModel())->find($productId);

        if (!$product || $user->balance < $product->price) {
            return redirect()->back()->with('error', 'Saldo tidak cukup atau produk tidak tersedia.');
        }

        // Cek Ketersediaan Akun di Inventori Otomatis
        $account = $db->table('accounts_inventory')
            ->where('product_id', $productId)
            ->where('is_sold', 0)
            ->orderBy('created_at', 'ASC')
            ->get()->getRow();

        if (!$account) {
            return redirect()->back()->with('error', 'Stok otomatis habis. Hubungi admin untuk restock.');
        }

        $db->transStart();

        // 1. Kurangi Saldo User
        $newBalance = $user->balance - $product->price;
        $db->table('users')->where('id', $userId)->update(['balance' => $newBalance]);
        session()->set('balance', $newBalance);

        // 2. Buat Record Order
        $orderModel = new OrderModel();
        $orderRef = $orderModel->generateReference();
        $db->table('orders')->insert([
            'order_ref'             => $orderRef,
            'user_id'               => $userId,
            'product_id'            => $productId,
            'total_price'           => $product->price,
            'credentials_delivered' => $account->credentials,
            'status'                => 'completed'
        ]);

        // 3. Tandai Akun Terjual
        $db->table('accounts_inventory')->where('id', $account->id)->update([
            'is_sold' => 1,
            'sold_to' => $userId
        ]);

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem.');
        }

        return redirect()->to('user/dashboard')->with('success', 'Akun berhasil dibeli dan otomatis terkirim!');
    }
}
