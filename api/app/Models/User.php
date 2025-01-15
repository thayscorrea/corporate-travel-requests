<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function travelOrders()
    {
        return $this->hasMany(TravelOrder::class);
    }

    public function createToken($name)
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = bin2hex(random_bytes(40))),
            'abilities' => ['*'],
        ]);

        return new \Laravel\Sanctum\NewAccessToken($token, $plainTextToken);
    }
}
