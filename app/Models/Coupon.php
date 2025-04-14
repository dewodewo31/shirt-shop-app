<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount',
        'valid_until',
    ];

    // ubah data nama menjadi uppercase
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::upper($value);
    }

    // fungsi cek kupon valid
    public function checkIfValid()
    {
        if ($this->valid_until > Carbon::now()) {
            return true;
        } else {
            return false;
        }
    }
}
