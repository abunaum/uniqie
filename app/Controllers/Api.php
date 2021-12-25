<?php

namespace App\Controllers;

use App\Controllers\BaseController;

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
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://tripay.co.id/developer?tab=channels',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $data = [];
        $getkode = explode('<td><b>', $response);
        for ($i = 1; $i < count($getkode); $i++) {
            $endkode = explode('</b></td>', $getkode[$i]);
            $kode = $endkode[0];
            $hs1 = explode('<b>', $endkode[1]);
            $hs2 = explode('</b>', $hs1[1]);
            $nama = $hs2[0];
            $dt = array(
                'kode' => $kode,
                'nama' => $nama
            );
            array_push($data, $dt);
        }

        $this->db->transStart();
        $channel = $this->channel->findAll();
        if ($channel != null) {
            $channel = $this->db->table('channel');
            $channel->truncate();
        }
        foreach ($data as $a) {
            $code = $a['kode'];
            $nama = $a['nama'];
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
    }

    public function onoffchannel()
    {
        $id = $this->request->getVar('id');
        $channel = $this->channel->where('id', $id)->first();
        $status = $channel['status'];
        $namachannel = $channel['nama'];
        $this->db->transStart();
        if ($status == 'aktif') {
            $newstatus = 'nonaktif';
        } else {
            $newstatus = 'aktif';
        }

        $savechannel = new $this->channel;
        $savechannel->save([
            'id' => $id,
            'status' => $newstatus
        ]);
        $this->db->transComplete();
        if ($this->db->transStatus() === false) {
            $kirim = array(
                'success' => false,
                'pesan' => "Gagal mengubah $namachannel  menjadi  $newstatus"
            );
        } else {
            $kirim = array(
                'success' => true,
                'pesan' => "Berhasil mengubah $namachannel menjadi $newstatus"
            );
        }

        return $this->response->setJSON($kirim);
    }
}
