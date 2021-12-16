<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class User extends BaseController
{
    public function index()
    {
        return 'Cari apa bos?';
    }

    public function checkout()
    {
        if (session()->get('logged_in') != true) {
            return redirect()->to(base_url());
        }
        $validasi = \Config\Services::validation();
        $id = $this->request->getVar('id');
        $nama = $this->request->getVar('nama');
        $email = $this->request->getVar('email');
        $channel = $this->request->getVar('channel');
        if (!$this->validate(
            [
                'id' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Produk tidak ada.'
                    ]
                ],
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama harus di isi.'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email harus di isi.',
                        'valid_email' => 'Email tidak valid.'
                    ]
                ],
                'channel' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Payment harus di pilih.',
                    ]
                ]

            ]
        )) {
            session()->setFlashdata('error', [
                'pesan' => 'Gagal order.',
                'id' => $id,
                'value' => $validasi->getErrors()
            ]);
            return redirect()->to(base_url('logo'))->withInput();
        }
        $produk = $this->produk->where('id', $id)->first();
        $channel = $this->channel->where('kode', $channel)->first();
        $data = [
            'produk' => $produk,
            'nama' => $nama,
            'email' => $email,
            'channel' => $channel
        ];
        return view('user/checkout', $data);
    }

    public function transaksi()
    {
        if (session()->get('logged_in') != true) {
            return redirect()->to(base_url());
        }
        $validasi = \Config\Services::validation();
        $produk = $this->request->getVar('produk');
        $nama = $this->request->getVar('nama');
        $email = $this->request->getVar('email');
        $channel = $this->request->getVar('channel');
        if (!$this->validate(
            [
                'produk' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Produk tidak ada.'
                    ]
                ],
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama harus di isi.'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email harus di isi.',
                        'valid_email' => 'Email tidak valid.'
                    ]
                ],
                'channel' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Payment harus di pilih.',
                    ]
                ]

            ]
        )) {
            session()->setFlashdata('error', [
                'pesan' => 'Gagal order.',
                'id' => $produk,
                'value' => $validasi->getErrors()
            ]);
            return redirect()->to(base_url('logo'))->withInput();
        }
        helper('payment');
        $create = createtransaction($produk, $channel, $email);
        $payment = json_decode($create, true);
        $referensi = $payment['data']['reference'];
        $merchant_ref = $payment['data']['merchant_ref'];
        if ($payment['success'] == true) {
            $transaksi = new \App\Models\Transaksi();
            $transaksi->save([
                'user' => user()->id,
                'produk' => $produk,
                'nama' => $nama,
                'email' => $email,
                'channel' => $payment['data']['payment_method'],
                'reference' => $referensi,
                'merchant_ref' => $merchant_ref,
                'status' => $payment['data']['status']
            ]);
            return redirect()->to(base_url("user/transaksi/detail/$merchant_ref"));
        } else {
            session()->setFlashdata('gagal', [
                'pesan' => 'Gagal order.',
                'value' => 'Payment error '
            ]);
            return redirect()->to(base_url('logo'));
        }
    }

    public function detailtrans($ref = 'a')
    {
        $transaksi = new \App\Models\Transaksi();
        $transaksi = $transaksi->where('merchant_ref', $ref)->first();
        $referensi = $transaksi['reference'];
        if (!$transaksi) {
            return redirect()->to(base_url());
        }
        if (session()->get('logged_in') != true) {
            return redirect()->to(base_url());
        }
        if ($transaksi['user'] != user()->id) {
            return redirect()->to(base_url());
        }
        helper('payment');
        $cek = cektransaction($referensi);
        $cek = json_decode($cek, true);

        $url = $cek['data']['checkout_url'];
        $test1 = curl_init();
        curl_setopt($test1, CURLOPT_URL, $url);
        curl_setopt($test1, CURLOPT_RETURNTRANSFER, 1);
        $hasil = curl_exec($test1);
        curl_close($test1);

        $gambar = explode('<img data-cfsrc="https://tripay.co.id/images/payment-channel/', $hasil);
        $gambar_fix = explode('" style="display:none;visibility:hidden;">', $gambar[1]);
        $gambar = $gambar_fix[0];

        // dd($cek);
        $data = [
            'transaksi' => $transaksi,
            'gambar' => $gambar,
            'payment' => $cek['data']
        ];
        return view('user/transaksi_detail', $data);
    }
}
