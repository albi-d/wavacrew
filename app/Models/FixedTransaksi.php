<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'jenis',
        'jumlah',
        'deskripsi',
        'frekuensi',
        'tanggal_mulai',
        'tanggal_berikutnya',
        'terakhir_dilakukan',
    ];

    protected $casts = [
        'tanggal_berikutnya' => 'datetime',
        'tanggal_mulai' => 'datetime'
    ];

    protected $appends = ['sudah_dilakukan_bulan_ini'];

    public function getSudahDilakukanBulanIniAttribute()
    {
        if (!$this->terakhir_dilakukan) {
            return false;
        }

        return Carbon::parse($this->terakhir_dilakukan)->isCurrentMonth() &&
            Carbon::parse($this->terakhir_dilakukan)->isCurrentYear();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
