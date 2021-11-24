<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function index()
    {
        $data = [
            'judul' => 'Beranda'
        ];
        return view('admin/beranda', $data);
    }

    public function payment()
    {
        $payment = $this->payment->where('id', 1)->first();
        if ($payment == null) {
            $payment = [
                'apikey' => '',
                'apiprivatekey' => '',
                'kodemerchant' => '',
                'jenis' => 'api-sandbox'
            ];
        }
        $data = [
            'judul' => 'Payment',
            'payment' => $payment,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/payment', $data);
    }

    public function kategori()
    {
        $data = [
            'judul' => 'Kategori',
            'kategori' => kategori(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/kategori', $data);
    }

    public function produk()
    {
        $data = [
            'judul' => 'Produk',
            'produk' => produk(),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/produk', $data);
    }
}
