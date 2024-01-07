<?php

namespace App\Controllers;
use App\Models\ModelBarang;
class Home extends BaseController
{
    
    public function __construct()
    {
       $this->ModelBarang = new ModelBarang();
       helper('number');
       helper('form');
    }
    
    public function index()
    {
        $data = [
            'title' => 'Home',
            'barang' => $this->ModelBarang->getBarang(), 
            'cart'  => \Config\Services::cart(),
            'isi'   => 'v_home'
        ];
        echo view('layout/v_wrapper',$data);
    }

    //--------CRUD --------------------------------

    public function cek()
    {
        $cart = \Config\Services::cart();
        $response = $cart->contents();
        /* $data = json_encode($response); */
        echo '<pre>';
        print_r($response);
        echo '</pre>';
    }

    //tambah keranjang
    public function add()
    {
        $cart = \Config\Services::cart();
        $cart->insert(array(
            'id'      => $this->request->getPost('id'),
            'qty'     => 1,
            'price'   => $this->request->getPost('price'),
            'name'    => $this->request->getPost('name'),
            'options' => array(
                'gambar' => $this->request->getPost('gambar'),)
         ));
         session()->setFlashdata('pesan', 'Barang Berhasil Ditambahkan!');
         return redirect()->to(base_url('home'));
    }

    //reset keranjang
    public function clear()
    {
        $cart = \Config\Services::cart();
        $cart->destroy();
        session()->setFlashdata('pesan', 'Semua Data Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('home/cart'));
    }

    //view detail cart
    public function cart()
    {
        $data = [
            'title' => 'View Cart',
            'cart'  => \Config\Services::cart(),
            'isi'   => 'v_cart'
        ];
        echo view('layout/v_wrapper',$data);
    }

    public function update()
    {
        $cart = \Config\Services::cart();
        $i = 1;
        foreach ($cart->contents() as $key => $value){

            $cart->update(array(
                'rowid'   => $value['rowid'],
                'qty'     => $this->request->getPost('qty'.$i++),
                /* 'price'   => '24.89', */
             ));         
        }
        session()->setFlashdata('pesan', 'Data Keranjang Berhasil Diupdate!');
        return redirect()->to(base_url('home/cart'));
    }

    public function delete($rowid)
    {
        $cart = \Config\Services::cart();
        $cart->remove($rowid);
        session()->setFlashdata('pesan', 'Data Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('home/cart'));
    }
}
