<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use App\Models\Category;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id',
        'tanggal',
        'category_id',
        'goal_id',
        'is_goal_refund',
        'jenis',
        'jumlah',
        'deskripsi'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

}
