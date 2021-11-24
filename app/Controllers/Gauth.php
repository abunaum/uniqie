<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Gauth extends BaseController
{
    public function __construct()
    {
        helper('user');
        $this->google = new \Google_Client();;
        $this->google->setClientId(Gdata()->ClientId);
        $this->google->setClientSecret(Gdata()->ClientSecret);
        $this->google->setRedirectUri(base_url('authuser'));
        $this->google->addScope('email');
        $this->google->addScope('profile');
    }
    public function index()
    {
        if (previous_url()) {
            $url = previous_url();

            $path = parse_url($url)['path'];
            $seturl = str_replace("index.php/", "", $path);
            session()->set('redirect_url', base_url($seturl));
        } else {
            session()->set('redirect_url', base_url());
        }
        $logingoogle = $this->google->createAuthUrl();
        return redirect()->to($logingoogle);
    }

    public function authuser()
    {
        $token = $this->google->fetchAccessTokenWithAuthCode($this->request->getVar('code'));
        if (!isset($token['error'])) {
            $this->google->setAccessToken($token['access_token']);
            session()->set("AccessToken", $token['access_token']);

            $googleService = new \Google\Service\Oauth2($this->google);
            $data = $googleService->userinfo->get();
            $email = $data->email;
            $gambar = $data->picture;
            $cekuser = $this->user->where('email', $email)->first();
            if ($cekuser) {
                $userupdate = [
                    'id' => $cekuser['id'],
                    'oauth_id' => $data->id,
                    'name' => $data->name,
                    'profile' => $gambar,
                ];
                $this->user->save($userupdate);
            } else {
                $useradd = [
                    'oauth_id' => $data->id,
                    'name' => $data->name,
                    'email' => $data->email,
                    'status' => 1,
                    'role' => 2,
                    'profile' => $gambar,
                ];
                $this->user->save($useradd);
            }
            $ceklagi = $this->user->where('email', $email)->first();
            $newdata = [
                'id'  => $ceklagi['id'],
                'logged_in' => true,
            ];
            session()->set($newdata);
        } else {
            session()->setFlashdata('gagal', [
                'pesan' => 'Gagal login.',
                'value' => 'Autentikasi google gagal'
            ]);
            return redirect()->to(base_url('login'));
        }
        $redirect = session('redirect_url');
        session()->remove('redirect_url');
        return redirect()->to($redirect);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url());
    }
}
