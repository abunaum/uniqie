<?php
function kategori()
{
    $kategori = new \App\Models\Kategori();
    $getkategori = $kategori->findAll();
    return $getkategori;
}

function produk()
{
    $produk = new \App\Models\Produk();
    $getproduk = $produk->findAll();
    return $getproduk;
}

function cekkategori($id)
{
    $kategori = new \App\Models\Kategori();
    $getkategori = $kategori->where('id', $id)->first();
    return $getkategori['nama'];
}

function ceknamaproduk($id)
{
    $produk = new \App\Models\Produk();
    $getproduk = $produk->where('id', $id)->first();
    return $getproduk['nama'];
}
