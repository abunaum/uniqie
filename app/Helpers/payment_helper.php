<?php
function createtransaction($produk, $channel, $email)
{
    $payment = new \App\Models\Payment();
    $getpayment = $payment->asObject()->first();

    $prd = new \App\Models\Produk();
    $getproduk = $prd->asObject()->where('id', $produk)->first();

    $apiKey       = $getpayment->apikey;
    $privateKey   = $getpayment->apiprivatekey;
    $merchantCode = $getpayment->kodemerchant;
    $merchantRef  = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    $amount       = $getproduk->harga;

    $data = [
        'method'         => $channel,
        'merchant_ref'   => $merchantRef,
        'amount'         => $amount,
        'customer_name'  => user()->name,
        'customer_email' => $email,
        'customer_phone' => 'CS - 085155118423',
        'order_items'    => [
            [
                'sku'         => $getproduk->nama,
                'name'        => $getproduk->nama,
                'price'       => $getproduk->harga,
                'quantity'    => 1,
                'product_url' => base_url('logo'),
                'image_url'   => base_url("images/produk/$getproduk->gambar"),
            ]
        ],
        'return_url'   => base_url('logo'),
        'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
        'signature'    => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
    ];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_FRESH_CONNECT  => true,
        CURLOPT_URL            => "https://tripay.co.id/$getpayment->jenis/transaction/create",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => false,
        CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
        CURLOPT_FAILONERROR    => false,
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query($data)
    ]);

    $response = curl_exec($curl);

    curl_close($curl);
    $createpayment = json_decode($response, true);
    $createpayment = json_encode($createpayment);
    return $createpayment;
}

function cektransaction($ref)
{
    $payment = new \App\Models\Payment();
    $getpayment = $payment->asObject()->first();

    $apiKey       = $getpayment->apikey;

    $payload = ['reference'    => $ref];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_FRESH_CONNECT  => true,
        CURLOPT_URL            => 'https://tripay.co.id/'.$getpayment->jenis.'/transaction/detail?' . http_build_query($payload),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => false,
        CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
        CURLOPT_FAILONERROR    => false,
    ]);

    $response = curl_exec($curl);
    $error = curl_error($curl);

    curl_close($curl);
    $cekpayment = json_decode($response, true);
    $cekpayment = json_encode($cekpayment);
    return $cekpayment;
}
