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
}
