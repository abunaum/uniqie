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

    $email->send();

    $debug = $email->printDebugger();
    if (preg_match("/Unable to send email using PHP SMTP/i", $debug)) {
        $status = $debug;
    } else {
        $status = 'success';
    }

    return $status;
}
