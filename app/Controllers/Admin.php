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
        $cp = $this->request->getVar('page_channel') ? $this->request->getVar('page_channel') : 1;

        if (!preg_match('/^\d+$/', $cp)) {
            return redirect()->to(base_url('admin/channel'));
        }
        $payment = $this->payment->where('id', 1)->first();
        $channel = $this->channel;
        $jmldata = 10;
        $startno = ($jmldata * $cp) - $jmldata;
        $chn = $channel->findAll();
        $totchn = count($chn);

        if ($startno >= $totchn) {
            return redirect()->to(base_url('admin/channel'));
        }
        $data = [
            'judul' => 'Channel Pembayaran',
            'payment' => $payment,
            'channel' => $channel->paginate($jmldata, 'channel'),
            'pager' => $channel->pager,
            'startno' => $startno,
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

    public function transaksi_open()
    {
        $cp = $this->request->getVar('page_transaksi') ? $this->request->getVar('page_transaksi') : 1;
        if (!preg_match('/^\d+$/', $cp)) {
            return redirect()->to(base_url('admin/transaksi'));
        }
        $jmldata = 10;
        $startno = ($jmldata * $cp) - $jmldata;
        $transaksi = new \App\Models\Transaksi();
        $transaksi->where('status', 'PAID');
        $transaksi->where('selesai', 'no');
        $trx = $transaksi->findAll();
        $tottrx = count($trx);

        if (!$trx) {
            $data = [
                'judul' => 'Transaksi Berlangsung'
            ];
            $tampil = 'tampilan_kosong';
        } elseif ($jmldata * ($cp - 1) >= $tottrx) {
            return redirect()->to(base_url('admin/transaksi'));
        } else {
            $data = [
                'judul' => 'Transaksi Berlangsung',
                'transaksi' => $transaksi->paginate($jmldata, 'transaksi'),
                'pager' => $transaksi->pager,
                'startno' => $startno,
                'validation' => \Config\Services::validation()
            ];
            $tampil = 'admin/transaksi';
        }
        return view($tampil, $data);
    }

    public function transaksi()
    {
        $cp = $this->request->getVar('page_transaksi') ? $this->request->getVar('page_transaksi') : 1;
        if (!preg_match('/^\d+$/', $cp)) {
            return redirect()->to(base_url('admin/transaksi'));
        }
        $jmldata = 10;
        $startno = ($jmldata * $cp) - $jmldata;
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
                'startno' => $startno,
                'validation' => \Config\Services::validation()
            ];
            $tampil = 'admin/transaksi';
        }
        return view($tampil, $data);
    }

    public function transaksi_detail($ref = 'a')
    {
        $transaksi = new \App\Models\Transaksi();
        $transaksi->join('produk', 'produk.id = transaksi.produk', 'LEFT');
        $transaksi->join('channel', 'channel.kode = transaksi.channel', 'LEFT');
        $transaksi->join('users', 'users.id = transaksi.user', 'LEFT');
        $transaksi->select('produk.nama as nama_produk');
        $transaksi->select('produk.gambar as gambar');
        $transaksi->select('produk.harga as harga');
        $transaksi->select('users.name as user_name');
        $transaksi->select('transaksi.id');
        $transaksi->select('transaksi.email');
        $transaksi->select('transaksi.nama');
        $transaksi->select('transaksi.reference');
        $transaksi->select('transaksi.merchant_ref');
        $transaksi->select('transaksi.channel');
        $transaksi->select('transaksi.status');
        $transaksi->select('transaksi.selesai');
        $transaksi->where('merchant_ref', $ref);
        $transaksi = $transaksi->first();
        if (!$transaksi) {
            return redirect()->to(base_url('admin/transaksi'));
        }
        $data = [
            'judul' => 'Transaksi - ' . $transaksi['merchant_ref'],
            'transaksi' => $transaksi
        ];
        return view('admin/transaksi_detail', $data);
    }

    public function smtp()
    {
        $smtp = new \App\Models\Smtp();
        $smtp = $smtp->findAll();
        $data = [
            'judul' => 'SMTP',
            'smtp' => $smtp,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/smtp', $data);
    }
}
