<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use O21\LaravelWallet\Contracts\Payable;
use O21\LaravelWallet\Models\Concerns\HasBalance;

class User extends Authenticatable implements Payable
{
    use HasApiTokens, HasFactory, Notifiable, HasBalance;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function actives()
    {
        return $this->hasMany(Active::class);
    }

    public function activesQuantity()
    {
        return $this->actives()->sum('quantity');
    }

    public function tickers()
    {
        return $this->hasManyThrough(
            Ticker::class,
            Active::class,
            'user_id',
            'id',
            'id',
            'ticker_id',

        )->distinct();
    }
}
