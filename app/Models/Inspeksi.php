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

    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['period'])) {
            switch ($filters['period']) {
                case 'today':
                    $query->whereDate('tanggal', \Carbon\Carbon::today());
                    break;
                case 'this_week':
                    $query->whereBetween('tanggal', [\Carbon\Carbon::now()->startOfWeek(), \Carbon\Carbon::now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('tanggal', \Carbon\Carbon::now()->month)->whereYear('tanggal', \Carbon\Carbon::now()->year);
                    break;
                case 'this_year':
                    $query->whereYear('tanggal', \Carbon\Carbon::now()->year);
                    break;
            }
        }

        if (!empty($filters['date_from'])) {
            $query->where('tanggal', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('tanggal', '<=', $filters['date_to']);
        }

        if (!empty($filters['lokasi_id'])) {
            $query->where('lokasi_id', $filters['lokasi_id']);
        }

        if (!empty($filters['kategori_id'])) {
            $query->whereHas('details.masterData', function($q) use ($filters) {
                $q->where('kategori_id', $filters['kategori_id']);
            });
        }

        if (!empty($filters['data_id'])) {
            $query->whereHas('details', function($q) use ($filters) {
                $q->where('data_id', $filters['data_id']);
            });
        }

        return $query;
    }

    public function details()
    {
        return $this->hasMany(InspeksiDetail::class, 'inspeksi_id');
    }
}
