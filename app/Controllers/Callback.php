<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Callback extends BaseController
{
    public function index()
    {

        // Ambil data JSON
        $json = file_get_contents('php://input');

        // Ambil callback signature
        $callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE'])
            ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE']
            : '';

        // Isi dengan private merchant key anda
        $payment = $this->payment->where('id', 1)->first();
        $privateKey = $payment['apiprivatekey'];

        // Generate signature untuk dicocokkan dengan X-Callback-Signature
        $signature = hash_hmac('sha256', $json, $privateKey);

        // Validasi signature
        if ($callbackSignature !== $signature) {
            die('Invalid signature'); // signature tidak valid, hentikan proses
        }

        $data = json_decode($json);

        // Hentikan proses jika callback event-nya bukan payent_status
        if ('payment_status' !== $_SERVER['HTTP_X_CALLBACK_EVENT']) {
            die('Invalid callback event, no action was taken');
        }

        $merchantRef = $data->merchant_ref;
        $totalAmount = (int) $data->total_amount;

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
        $transaksi->where('transaksi.merchant_ref', $merchantRef);
        $transaksi->where('transaksi.status', 'UNPAID');
        $transaksi = $transaksi->asObject()->first();

        switch ($data->status) {
                // Pembayaran sukses, lanjutkan proses di sistem anda dengan
                // mengupdate status transaksi di database menjadi sukses, contoh:
            case 'PAID':
                if (($getInvoice = $transaksi)) {
                    while ($invoice = $getInvoice) {
                        // lakukan validasi nominal pembayaran
                        if ((int) $invoice->harga !== $totalAmount) {
                            die('Invalid amount. Expected: ' . $invoice->harga . ' | Received: ' . $totalAmount);
                        }

                        // Validasi lolos, lanjutkan ke update status transaksi di database anda
                        $newtransaksi = new \App\Models\Transaksi();
                        $newtransaksi->save([
                            'id' => $invoice->id,
                            'status' => 'PAID'
                        ]);

                        // Berikan response ke klien
                        echo json_encode(['success' => true]);
                        exit;
                    }
                }
                break;

            case 'EXPIRED':
                // Pembayaran kedaluwarsa, lanjutkan proses di sistem anda dengan
                // mengupdate status transaksi di database menjadi kedaluwarsa, contoh:
                if (($getInvoice = $transaksi)) {
                    while ($invoice = $getInvoice) {
                        // lakukan validasi nominal pembayaran
                        if ((int) $invoice->harga !== $totalAmount) {
                            die('Invalid amount. Expected: ' . $invoice->harga . ' | Received: ' . $totalAmount);
                        }

                        // Validasi lolos, lanjutkan ke update status transaksi di database anda
                        $newtransaksi = new \App\Models\Transaksi();
                        $newtransaksi->save([
                            'id' => $invoice->id,
                            'status' => 'EXPIRED'
                        ]);
                        // Berikan response ke klien
                        echo json_encode(['success' => true]);
                        exit;
                    }
                }
                break;

            case 'FAILED':
                // Pembayaran kedaluwarsa, lanjutkan proses di sistem anda dengan
                // mengupdate status transaksi di database menjadi kedaluwarsa, contoh:
                if (($getInvoice = $transaksi)) {
                    while ($invoice = $getInvoice) {
                        // lakukan validasi nominal pembayaran
                        if ((int) $invoice->harga !== $totalAmount) {
                            die('Invalid amount. Expected: ' . $invoice->harga . ' | Received: ' . $totalAmount);
                        }

                        // Validasi lolos, lanjutkan ke update status transaksi di database anda

                        $newtransaksi = new \App\Models\Transaksi();
                        $newtransaksi->save([
                            'id' => $invoice->id,
                            'status' => 'FAILED'
                        ]);

                        // Berikan response ke klien
                        echo json_encode(['success' => true]);
                        exit;
                    }
                }
                break;

            default:
                die('Unrecognized payment status');
                break;
        }
    }

    public function tester()
    {
        $id = 2;
        $smtp = new \App\Models\Smtp();
        $smtp = $smtp->where('id', $id)->first();
        $tujuan = 'andialfa11@gmail.com';
        $subject = 'testing 1';
        $pesan = 'testing pesan';

        $email = \Config\Services::email();

        $config['SMTPHost']  = $smtp['host'];
        $config['SMTPUser']  = $smtp['user'];
        $config['SMTPPass']  = $smtp['password'];
        $config['SMTPPort']  = $smtp['port'];
        $config['SMTPCrypto']  = 'ssl';
        $config['protocol'] = 'smtp';
        $config['mailPath'] = '/usr/sbin/sendmail';
        $config['charset']  = 'iso-8859-1';
        $config['wordWrap'] = true;

        $email->initialize($config);

        $email->setFrom($smtp['user'], $_SERVER['HTTP_HOST']);
        $email->setTo($tujuan);

        $email->setSubject($subject);
        $email->setMessage($pesan);

        $kirim = $email->send();
        $debug = $email->printDebugger(['headers']);
        $debug = strip_tags($debug);
        // $debug = str_replace("<pre>", "", $debug);
        // $debug = str_replace("</pre>", "<br>", $debug);
        // $debug = str_replace("\n\n", "<br>", $debug);
        $debug = str_replace("\n", "<br>", $debug);
        // $debug = str_replace("<br />", "<br>", $debug);
        $debug = str_replace("<br><br>", "<br>", $debug);
        // $keterangan = implode("<br>", $debug);
        // $res = explode("<br />", $debug);
        // dd($res);
        echo $debug;
        die;
        if (!$kirim) {
            $debug = $email->printDebugger(['headers']);
            $res = explode("<br />", $debug);
            echo $res[0];
        } else {
            echo 'sukses';
        }
        // $payment = $this->payment->where('id', 1)->first();
        // $privateKey = $payment['apiprivatekey'];

        // // ambil data json callback notifikasi
        // $data = '{
        //     "reference": "T15471462923DRXKY",
        //     "merchant_ref": "f60426e52c0861af551a",
        //     "payment_method": "Alfamart",
        //     "payment_method_code": "ALFAMART",
        //     "total_amount": 20000,
        //     "fee_merchant": 200,
        //     "fee_customer": 0,
        //     "amount_received": 19800,
        //     "is_closed_payment": 1,
        //     "status": "PAID",
        //     "paid_at": 1608133017,
        //     "note": null
        // }';
        // $json = $data;
        // $signature = hash_hmac('sha256', $json, $privateKey);
        // echo $signature;
    }
}
