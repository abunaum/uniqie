<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class User extends BaseController
{
    public function index()
    {
        return 'Cari apa bos?';
    }
    public function transaksi_list()
    {
        if (session()->get('logged_in') != true) {
            return redirect()->to(base_url());
        }
        $transaksi = new \App\Models\Transaksi();
        $transaksi->join('produk', 'produk.id = transaksi.produk', 'LEFT');
        $transaksi->select('transaksi.*');
        $transaksi->select('produk.nama as nama_produk');
        $transaksi->select('produk.harga as harga');
        $transaksi->where('transaksi.user', user()->id);
        $transaksi = $transaksi->orderBy('created_at', 'asc')->findAll();
        if (!$transaksi) {
            return redirect()->to(base_url());
        }
        $data = [
            'transaksi' => $transaksi
        ];
        return view('user/transaksi_list', $data);
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
        if (!$this->request->getVar('ovo')) {
            $nomor = 'cs-085155118423';
        } else {
            $nomor = $this->request->getVar('ovo');
        }

        $vld = [
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

        ];
        $ovo = [
            'ovo' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nomor OVO harus di isi.',
                    'numeric' => 'Nomor OVO tidak valid.',
                ]
            ]
        ];
        if (!$this->validate($vld)) {
            session()->setFlashdata('error', [
                'pesan' => 'Gagal order.',
                'id' => $id,
                'value' => $validasi->getErrors()
            ]);
            return redirect()->to(base_url('logo'))->withInput();
        }
        if ($channel == 'OVO') {
            if (!$this->validate($ovo)) {
                session()->setFlashdata('error', [
                    'pesan' => 'Gagal order.',
                    'id' => $id,
                    'value' => $validasi->getErrors()
                ]);
                return redirect()->to(base_url('logo'))->withInput();
            }
        }
        $produk = $this->produk->where('id', $id)->first();
        $channel = $this->channel->where('kode', $channel)->first();
        $data = [
            'produk' => $produk,
            'nama' => $nama,
            'email' => $email,
            'channel' => $channel,
            'nomor' => $nomor
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
        if (!$this->request->getVar('ovo')) {
            $nomor = 'cs-085155118423';
        } else {
            $nomor = $this->request->getVar('ovo');
        }
        $vld = [
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

        ];
        $ovo = [
            'ovo' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nomor OVO harus di isi.',
                    'numeric' => 'Nomor OVO tidak valid.',
                ]
            ]
        ];
        if (!$this->validate($vld)) {
            session()->setFlashdata('error', [
                'pesan' => 'Gagal order.',
                'id' => $produk,
                'value' => $validasi->getErrors()
            ]);
            return redirect()->to(base_url('logo'))->withInput();
        }
        if ($channel == 'OVO') {
            if (!$this->validate($ovo)) {
                session()->setFlashdata('error', [
                    'pesan' => 'Gagal order.',
                    'id' => $produk,
                    'value' => $validasi->getErrors()
                ]);
                return redirect()->to(base_url('logo'))->withInput();
            }
        }
        helper('payment');
        $create = createtransaction($produk, $channel, $email, $nomor);
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
                'info' => $nomor,
                'status' => $payment['data']['status'],
                'selesai' => 'no'
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
        $transaksi->join('produk', 'produk.id = transaksi.produk', 'LEFT');
        $transaksi->join('channel', 'channel.kode = transaksi.channel', 'LEFT');
        $transaksi->select('transaksi.*');
        $transaksi->select('produk.nama as nama_produk');
        $transaksi->select('produk.harga as harga');
        $transaksi->select('channel.nama as nama_channel');
        $transaksi->where('merchant_ref', $ref);
        $transaksi = $transaksi->first();
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
        $referensi = $transaksi['reference'];
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
        $waktu = Time::createFromTimestamp($cek['data']['expired_time'], 'Asia/Jakarta', 'id_ID');
        $type_channel = cekchannel($cek['data']['payment_method']);

        // dd($cek);
        // dd($transaksi);
        $data = [
            'transaksi' => $transaksi,
            'gambar' => $gambar,
            'payment' => $cek['data'],
            'batas_waktu' => $waktu,
            'type_channel' => $type_channel
        ];
        return view('user/transaksi_detail', $data);
    }
}
