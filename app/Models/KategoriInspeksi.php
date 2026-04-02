<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriInspeksi extends Model
{
    use HasFactory;
    protected $table = 'kat_data_inspeksis';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'nama'];

    public function masterDatas()
    {
        return $this->hasMany(MasterData::class, 'kategori_id');
    }
}
