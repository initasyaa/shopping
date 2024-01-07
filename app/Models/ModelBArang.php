<?php

namespace App\Models;
use CodeIgniter\Model;

class ModelBarang extends Model
{
    protected $table = 'tbl_barang';
    public function getBarang()
    {
        return $this->findAll();
    }
}