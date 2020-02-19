<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $fillable = ['kode_barang', 'nama_barang', 'tempat_beli'];
}
