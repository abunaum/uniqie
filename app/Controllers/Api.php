<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Api extends BaseController
{
    public function index()
    {
        //
    }

    public function api()
    {
        $apikey = $this->request->getVar('apikey');
        $jenis = $this->request->getVar('jenis');
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://tripay.co.id/$jenis/merchant/payment-channel?code=BRIVA",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $apikey"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $this->response->setJSON($response);
    }

    public function syncchannel()
    {
        $api = $this->payment->where('id', 1)->first();
        $apikey = $api['apikey'];
        $jenis = $api['jenis'];
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://tripay.co.id/$jenis/merchant/payment-channel",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $apikey"
            ),
        ));

        $hasil = curl_exec($curl);

        $test = json_decode($hasil, true);

        curl_close($curl);
        $arr = array();

        foreach ($test['data'] as $r) {
            $arr[] = [$r['code'], $r['name']];
        }

        $this->db->transStart();
        $channel = $this->channel->findAll();
        if ($channel != null) {
            $channel = $this->db->table('channel');
            $channel->truncate();
        }
        foreach ($arr as $a) {
            $code = $a[0];
            $nama = $a[1];
            $channel = new $this->channel;
            $channel->save([
                'kode' => $code,
                'nama' => $nama,
                'status' => 'aktif'
            ]);
        }
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            $kirim = array(
                'success' => false,
                'pesan' => 'Sinkronasi channel gagal'
            );
        } else {
            $kirim = array(
                'success' => true,
                'pesan' => 'Sinkronasi channel berhasil'
            );
        }

        return $this->response->setJSON($kirim);
        // return print_r($arr);
    }
}
