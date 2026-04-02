<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspeksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'hari', 'tanggal', 'cuaca', 'w1', 'w2',
        'lokasi_id', 'petugas1_id', 'petugas2_id', 'petugas3_id', 'petugas4_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function lokasi()
    {
        return $this->belongsTo(LokasiInspeksi::class, 'lokasi_id');
    }

    public function petugas1()
    {
        return $this->belongsTo(User::class, 'petugas1_id');
    }

    public function petugas2()
    {
        return $this->belongsTo(User::class, 'petugas2_id');
    }

    public function petugas3()
    {
        return $this->belongsTo(User::class, 'petugas3_id');
    }

    public function petugas4()
    {
        return $this->belongsTo(User::class, 'petugas4_id');
    }

    public function details()
    {
        return $this->hasMany(InspeksiDetail::class, 'inspeksi_id');
    }
}
