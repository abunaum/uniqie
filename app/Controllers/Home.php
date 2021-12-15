<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('web/beranda');
    }

    public function layanan()
    {
        return view('web/layanan');
    }

    public function privasi()
    {
        return view('web/privasi');
    }

    public function saran()
    {
        return view('web/saran');
    }
    public function logo()
    {
        $data = [
            'validation' => \Config\Services::validation()
        ];
        return view('web/logo', $data);
    }
}
