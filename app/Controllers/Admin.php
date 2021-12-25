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

    public function channel()
    {
        $payment = $this->payment->where('id', 1)->first();
        $channel = $this->channel->findAll();
        $data = [
            'judul' => 'Channel Pembayaran',
            'payment' => $payment,
            'channel' => $channel,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/channel', $data);
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

    public function transaksi()
    {
        $cp = $this->request->getVar('page_transaksi') ? $this->request->getVar('page_transaksi') : 1;
        $jmldata = 10;
        $transaksi = new \App\Models\Transaksi();
        $trx = $transaksi->findAll();
        $tottrx = count($trx);

        if (!$trx) {
            $data = [
                'judul' => 'Transaksi'
            ];
            $tampil = 'tampilan_kosong';
        } elseif ($jmldata * ($cp - 1) >= $tottrx) {
            return redirect()->to(base_url('admin/transaksi'));
        } else {
            $data = [
                'judul' => 'Transaksi',
                'transaksi' => $transaksi->paginate($jmldata, 'transaksi'),
                'pager' => $transaksi->pager,
                'jmldata' => $jmldata,
                'cp' => $cp,
                'validation' => \Config\Services::validation()
            ];
            $tampil = 'admin/transaksi';
        }
        return view($tampil, $data);
    }
}
