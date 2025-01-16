<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class TravelOrder extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'user_id',
        'applicant_name',
        'destination',
        'departure_date',
        'return_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}