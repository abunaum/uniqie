<?php

function testemail($host, $user, $pass, $port)
{
    $email = \Config\Services::email();

    $config['SMTPHost']  = $host;
    $config['SMTPUser']  = $user;
    $config['SMTPPass']  = $pass;
    $config['SMTPPort']  = $port;
    $config['SMTPCrypto']  = 'ssl';
    $config['protocol'] = 'smtp';
    $config['mailPath'] = '/usr/sbin/sendmail';
    $config['charset']  = 'iso-8859-1';
    $config['wordWrap'] = true;

    $email->initialize($config);

    $email->setFrom($user, $_SERVER['HTTP_HOST']);
    $email->setTo($user);

    $email->setSubject('Email Test SMTP');
    $email->setMessage('Testing smtp.');

    $kirim = $email->send();
    $debug = $email->printDebugger(['headers']);
    $debug = strip_tags($debug);
    $debug = str_replace("\n", "<br>", $debug);
    $debug = str_replace("\r", "<br>", $debug);
    $debug = str_replace("<br><br>", "<br>", $debug);
    if (!$kirim) {
        $status = $debug;
    } else {
        $status = 'success';
    }

    return $status;
}

function sendemail($id, $subject, $pesan, $tujuan, $lampiran)
{
    $smtp = new \App\Models\Smtp();
    $smtp = $smtp->where('id', $id)->first();

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
    if ($lampiran) {
        $email->attach($lampiran);
    }

    $kirim = $email->send();

    $debug = $email->printDebugger(['headers']);
    $debug = strip_tags($debug);
    $debug = str_replace("\n", "<br>", $debug);
    $debug = str_replace("\r", "<br>", $debug);
    $debug = str_replace("<br><br>", "<br>", $debug);

    if (!$kirim) {
        $status = $debug;
    } else {
        $status = 'success';
    }

    return $status;
}
