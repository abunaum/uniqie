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
                'type' => 'tambah',
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
        $detailkategori = $kategori->where('id', $id)->first();
        $namalama = $detailkategori['nama'];
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
                'type' => 'edit',
                'id' => $id,
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
                'value' => 'Berhasil mengedit <b>' . $namalama . '</b> menjadi <b>' . $nama . '</b>'
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
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harga Produk harus ada.'
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
                'type' => 'tambah',
                'value' => $validasi->getErrors()
            ]);
            return redirect()->to(base_url('admin/produk'))->withInput();
        } else {
            if ($harga < 20000) {
                session()->setFlashdata('error', [
                    'pesan' => 'Gagal menyimpan produk.',
                    'type' => 'tambah',
                    'value' => ['harga' => 'Harga minimal Rp 20.000']
                ]);
                session()->setFlashdata('hargaerror', 'Harga minimal Rp 20.000');
                return redirect()->to(base_url('admin/produk'))->withInput();
            }
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

    public function edit_produk($id)
    {
        $nama = $this->request->getVar('nama');
        $kategori = $this->request->getVar('kategori');
        $harga = $this->request->getVar('harga');
        $gambar = $this->request->getfile('gambar');
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
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Harga Produk harus ada.'
                    ]
                ],
                'gambar' => [
                    'rules' => 'max_size[gambar,2048]|is_image[gambar]|mime_in[gambar,image/png,image/jpg,image/jpeg]',
                    'errors' => [
                        'max_size' => 'Ukuran gambar maksimal 2MB',
                        'is_image' => 'File yang dipilih harus gambar',
                        'mime_in' => 'Gambar yang dipilih harus jpg/jpeg/png'
                    ]
                ]
            ]
        )) {
            $validasi = \Config\Services::validation();
            session()->setFlashdata('error', [
                'pesan' => 'Gagal mengedit ' . $nama,
                'type' => 'edit',
                'id' => $id,
                'value' => $validasi->getErrors()
            ]);
            return redirect()->to(base_url('admin/produk'))->withInput();
        } else {
            if ($harga < 20000) {
                session()->setFlashdata('error', [
                    'pesan' => 'Gagal menyimpan produk.',
                    'type' => 'edit',
                    'id' => $id,
                    'value' => ['harga' => 'Harga minimal Rp 20.000']
                ]);
                session()->setFlashdata('hargaerror', 'Harga minimal Rp 20.000');
                return redirect()->to(base_url('admin/produk'))->withInput();
            }
            $cekproduk = $this->produk->where('id', $id)->first();
            if ($gambar->getError() == 4) {
                $namagambar = $cekproduk['gambar'];
            } else {
                unlink('images/produk/' . $cekproduk['gambar']);
                $gambar->move('images/produk');
                $namagambar = $gambar->getName();
            }
            $produk = $this->produk;
            $produk->save([
                'id' => $id,
                'nama' => $nama,
                'kategori_id' => $kategori,
                'harga' => $harga,
                'gambar' => $namagambar
            ]);
            session()->setFlashdata('sukses', [
                'pesan' => 'Mantap.',
                'value' => 'Berhasil mengedit ' . $nama
            ]);
            return redirect()->to(base_url('admin/produk'));
        }
    }

    public function hapus_produk($id)
    {
        $produk = $this->produk;
        $getproduk = $produk->where('id', $id)->first();
        $nama = $getproduk['nama'];
        $gambar = $getproduk['gambar'];
        unlink('images/produk/' . $gambar);
        $produk->where('id', $id)->delete();
        session()->setFlashdata('sukses', [
            'pesan' => 'Mantap.',
            'value' => 'Berhasil menghapus ' . $nama
        ]);
        return redirect()->to(base_url('admin/produk'));
    }

    public function tambah_smtp()
    {
        helper('email');
        $validasi = \Config\Services::validation();
        $host = $this->request->getVar('host');
        $port = $this->request->getVar('port');
        $user = $this->request->getVar('user');
        $password = $this->request->getVar('password');
        if (!$this->validate(
            [
                'host' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Host harus di isi.'
                    ]
                ],
                'port' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'Port harus di isi.',
                        'numeric' => 'Port harus angka.'
                    ]
                ],
                'user' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'user harus di isi.',
                        'valid_email' => 'User harus berupa email.'
                    ]
                ]
            ]
        )) {
            session()->setFlashdata('error', [
                'pesan' => 'Gagal memverifikasi SMTP.',
                'type' => 'tambah',
                'value' => $validasi->getErrors()
            ]);
            return redirect()->to(base_url('admin/smtp'))->withInput();
        } else {
            $testemail = testemail($host, $user, $password, $port);
            if ($testemail == 'success') {
                $smtp = new \App\Models\Smtp();
                $smtp->save([
                    'host' => $host,
                    'port' => $port,
                    'user' => $user,
                    'password' => $password
                ]);
                session()->setFlashdata('sukses', [
                    'pesan' => 'Mantap.',
                    'value' => 'Berhasil menambah SMTP'
                ]);
                return redirect()->to(base_url('admin/smtp'));
            } else {
                session()->setFlashdata('smtperr', [
                    'pesan' => 'Gagal terhubung ke SMTP.',
                    'type' => 'tambah',
                    'value' => 'Pastikan host, port, user, dan password SMTP sudah benar'
                ]);
                return redirect()->to(base_url('admin/smtp'))->withInput();
            }
        }
    }

    public function edit_smtp($id = 0)
    {
        helper('email');
        $validasi = \Config\Services::validation();
        $host = $this->request->getVar('host');
        $port = $this->request->getVar('port');
        $user = $this->request->getVar('user');
        $password = $this->request->getVar('password');
        if (!$this->validate(
            [
                'host' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Host harus di isi.'
                    ]
                ],
                'port' => [
                    'rules' => 'required|numeric',
                    'errors' => [
                        'required' => 'Port harus di isi.',
                        'numeric' => 'Port harus angka.'
                    ]
                ],
                'user' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'user harus di isi.',
                        'valid_email' => 'User harus berupa email.'
                    ]
                ]
            ]
        )) {
            session()->setFlashdata('error', [
                'pesan' => 'Gagal memverifikasi SMTP.',
                'type' => 'edit',
                'id' => $id,
                'value' => $validasi->getErrors()
            ]);
            return redirect()->to(base_url('admin/smtp'))->withInput();
        } else {
            $testemail = testemail($host, $user, $password, $port);
            if ($testemail == 'success') {
                $smtp = new \App\Models\Smtp();
                $smtp->save([
                    'id' => $id,
                    'host' => $host,
                    'port' => $port,
                    'user' => $user,
                    'password' => $password
                ]);
                session()->setFlashdata('sukses', [
                    'pesan' => 'Mantap.',
                    'value' => 'Berhasil mengubah SMTP'
                ]);
                return redirect()->to(base_url('admin/smtp'));
            } else {
                session()->setFlashdata('smtperr', [
                    'pesan' => 'Gagal terhubung ke SMTP.',
                    'type' => 'edit',
                    'id' => $id,
                    'value' => 'Pastikan host, port, user, dan password SMTP sudah benar'
                ]);
                return redirect()->to(base_url('admin/smtp'))->withInput();
            }
        }
    }

    public function hapus_smtp($id = 0)
    {
        $smtp = new \App\Models\Smtp();
        $getsmtp = $smtp->where('id', $id)->first();
        $smtp->where('id', $id)->delete();
        session()->setFlashdata('sukses', [
            'pesan' => 'Mantap.',
            'value' => 'Berhasil menghapus ' . $getsmtp['user']
        ]);
        return redirect()->to(base_url('admin/smtp'));
    }
}
