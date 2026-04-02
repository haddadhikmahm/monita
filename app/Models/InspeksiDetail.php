<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspeksiDetail extends Model
{
    use HasFactory;

    protected $table = 'inspeksi_datas';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'inspeksi_id', 'data_id', 'jumlah',
        'kondisi_struktur', 'kondisi_permukaan', 'foto',
        'upaya', 'tindak_lanjut', 'keterangan'
    ];

    public function inspeksi()
    {
        return $this->belongsTo(Inspeksi::class, 'inspeksi_id');
    }

    public function masterData()
    {
        return $this->belongsTo(MasterData::class, 'data_id');
    }
}
