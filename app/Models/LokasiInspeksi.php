<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiInspeksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'nama'];

    public function masterDatas()
    {
        return $this->hasMany(MasterData::class, 'lokasi_id');
    }

    public function inspeksis()
    {
        return $this->hasMany(Inspeksi::class, 'lokasi_id');
    }
}
