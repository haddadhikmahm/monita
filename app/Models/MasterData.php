<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterData extends Model
{
    use HasFactory;

    protected $table = 'datas';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'nama', 'kategori_id', 'lokasi_id'];

    public function kategori()
    {
        return $this->belongsTo(KategoriInspeksi::class, 'kategori_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(LokasiInspeksi::class, 'lokasi_id');
    }

    public function inspeksiDetails()
    {
        return $this->hasMany(InspeksiDetail::class, 'data_id');
    }
}
