<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CustomerFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Pastikan yang login adalah customer
        if (! session()->get('isLoggedIn') || session()->get('role') !== 'customer') {
            return redirect()->to('auth/login')->with('error', 'Silakan masuk ke akun Anda.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
