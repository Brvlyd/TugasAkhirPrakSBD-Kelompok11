<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengumuman extends Model
{
    use SoftDeletes;

    protected $table = 'pengumuman'; // Tambahkan baris ini

    protected $fillable = [
        'judul',
        'tanggal',
        'penulis',
        'isi_pengumuman',
        'gambar_pengumuman',
        'link_pdf_pengumuman',
    ];
}