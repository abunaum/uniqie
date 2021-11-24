<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class AdminProses extends BaseController
{
    public function uninstall()
    {
        helper('filesystem');
        $view = '../installer/install';
        $newview = '../app/Views/install';
        try {
            directory_mirror($view, $newview, true);
        } catch (\Config\Exceptions $e) {
            echo 'Failed to export uploads!';
        }

        $forge = \Config\Database::forge();
        $forge->dropTable('auth_activation_attempts', false, true);
        $forge->dropTable('auth_groups', false, true);
        $forge->dropTable('auth_groups_permissions', false, true);
        $forge->dropTable('auth_groups_users', false, true);
        $forge->dropTable('auth_logins', false, true);
        $forge->dropTable('auth_permissions', false, true);
        $forge->dropTable('auth_reset_attempts', false, true);
        $forge->dropTable('auth_tokens', false, true);
        $forge->dropTable('auth_users_permissions', false, true);
        $forge->dropTable('menu', false, true);
        $forge->dropTable('migrations', false, true);
        $forge->dropTable('order', false, true);
        $forge->dropTable('payment', false, true);
        $forge->dropTable('users', false, true);

        $routesbackup = file_get_contents('../app/Config/Routes.php');
        file_put_contents('../installer/Routes.php', $routesbackup);

        $routes = file_get_contents('../installer/Routesinstaller.php');
        file_put_contents('../app/Config/Routes.php', $routes);

        $control = file_get_contents('../installer/Install.php');
        file_put_contents('../app/Controllers/Install.php', $control);

        session()->destroy();
        return redirect()->to(base_url());
    }
    public function tambah_kategori()
    {
        $validasi = \Config\Services::validation();
        $nama = $this->request->getVar('nama');
        if (!$this->validate(
            [
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama kategori harus di isi.'
                    ]
                ]
            ]
        )) {
            session()->setFlashdata('error', [
                'pesan' => 'Gagal menyimpan Kategori.',
                'value' => $validasi->getErrors()
            ]);
            return redirect()->to(base_url('admin/kategori'))->withInput();
        } else {
            $kategori = $this->kategori;
            $kategori->save([
                'nama' => $nama
            ]);
            session()->setFlashdata('sukses', [
                'pesan' => 'Mantap.',
                'value' => 'Berhasil menyimpan kategori.'
            ]);
            session()->setFlashdata('websocket', 'edit_kategori');
            return redirect()->to(base_url('admin/kategori'));
        }
    }
    public function hapus_kategori($id)
    {
        $kategori = $this->kategori;
        $getkategori = $kategori->where('id', $id)->first();
        $nama = $getkategori['nama'];
        $kategori->where('id', $id)->delete();
        session()->setFlashdata('sukses', [
            'pesan' => 'Mantap.',
            'value' => 'Berhasil menghapus ' . $nama
        ]);
        session()->setFlashdata('websocket', 'edit_kategori');
        return redirect()->to(base_url('admin/kategori'));
    }
    public function edit_kategori($id)
    {
        $kategori = $this->kategori;
        $nama = $this->request->getVar('nama');
        if (!$this->validate(
            [
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama kategori harus di isi.'
                    ]
                ]
            ]
        )) {
            $validasi = \Config\Services::validation();
            session()->setFlashdata('error', [
                'pesan' => 'Gagal mengedit ' . $nama,
                'value' => $validasi->getErrors()
            ]);
            return redirect()->to(base_url('admin/kategori'))->withInput();
        } else {
            $kategori->save([
                'id' => $id,
                'nama' => $nama
            ]);
            session()->setFlashdata('sukses', [
                'pesan' => 'Mantap.',
                'value' => 'Berhasil mengedit ' . $nama
            ]);
            session()->setFlashdata('websocket', 'edit_kategori');
            return redirect()->to(base_url('admin/kategori'));
        }
    }
    public function edit_payment()
    {
        $payment = $this->payment;
        $apikey = $this->request->getVar('apikey');
        $privatekey = $this->request->getVar('privatekey');
        $kode = $this->request->getVar('kode');
        $jenis = $this->request->getVar('jenis');
        if (!$this->validate(
            [
                'apikey' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Apikey harus di isi.'
                    ]
                ],
                'privatekey' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'privatekey harus di isi.'
                    ]
                ],
                'kode' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kode Merchant harus di isi.'
                    ]
                ]
            ]
        )) {
            $validasi = \Config\Services::validation();
            session()->setFlashdata('error', [
                'pesan' => 'Gagal mengedit payment gateway',
                'value' => $validasi->getErrors()
            ]);
            return redirect()->to(base_url('admin/payment'))->withInput();
        } else {
            $paymentcek = $this->payment->where('id', 1)->first();
            if ($paymentcek == null) {
                $db      = \Config\Database::connect();
                $builder = $db->table('payment');
                $data = [
                    'id' => 1,
                    'apikey' => $apikey,
                    'apiprivatekey' => $privatekey,
                    'kodemerchant' => $kode,
                    'callback' => 'payment/callback',
                    'jenis' => $jenis,
                    'created_at' => Time::now(),
                    'updated_at' => Time::now()
                ];

                $builder->insert($data);
            } else {
                $payment->save([
                    'id' => 1,
                    'apikey' => $apikey,
                    'apiprivatekey' => $privatekey,
                    'kodemerchant' => $kode,
                    'callback' => 'payment/callback',
                    'jenis' => $jenis
                ]);
            }
            session()->setFlashdata('sukses', [
                'pesan' => 'Mantap.',
                'value' => 'Berhasil mengedit payment gateway'
            ]);
            return redirect()->to(base_url('admin/payment'));
        }
    }

    public function tambah_produk()
    {
        $validasi = \Config\Services::validation();
        $nama = $this->request->getVar('nama');
        $kategori = $this->request->getVar('kategori');
        $harga = $this->request->getVar('harga');
        $gambar = $this->request->getfile('gambar');
        // dd($gambar);
        $ambilkoma = '/,/i';
        $harga = preg_replace($ambilkoma, '', $harga);
        if (!$this->validate(
            [
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama kategori harus di isi.'
                    ]
                ],
                'kategori' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Kategori harus dipilih harus ada.'
                    ]
                ],
                'harga' => [
                    'rules' => 'required|min_length[6]',
                    'errors' => [
                        'required' => 'Harga Produk harus ada.',
                        'min_length' => 'Harga minimal Rp. 10,000'
                    ]
                ],
                'gambar' => [
                    'rules' => 'uploaded[gambar]|max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/png,image/jpg,image/jpeg]',
                    'errors' => [
                        'uploaded' => 'Gambar harus ada.',
                        'max_size' => 'Ukuran gambar maksimal 2MB',
                        'is_image' => 'File yang dipilih harus gambar',
                        'mime_in' => 'Gambar yang dipilih harus jpg/jpeg/png'
                    ]
                ]
            ]
        )) {
            session()->setFlashdata('error', [
                'pesan' => 'Gagal menyimpan produk.',
                'value' => $validasi->getErrors()
            ]);
            return redirect()->to(base_url('admin/produk'))->withInput();
        } else {
            $gambar->move('images/produk');
            $namagambar = $gambar->getName();
            $produk = $this->produk;
            $produk->save([
                'nama' => $nama,
                'kategori_id' => $kategori,
                'harga' => $harga,
                'gambar' => $namagambar
            ]);
            session()->setFlashdata('sukses', [
                'pesan' => 'Mantap.',
                'value' => 'Berhasil menyimpan produk.'
            ]);
            return redirect()->to(base_url('admin/produk'));
        }
    }
}
