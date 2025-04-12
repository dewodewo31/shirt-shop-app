<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'rating',
        'approved',
        'user_id',
        'product_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsTo(Product::class);
    }

    public function getcreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
