<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Crypt;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'email_hash',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 10+ auto-hashes passwords
    ];

    // Encrypt data before saving to DB
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Crypt::encryptString($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = Crypt::encryptString($value); // Store encrypted email
        $this->attributes['email_hash'] = hash('sha256', $value); // Store hashed email for lookup
    }

    // Decrypt data when retrieving from DB
    public function getNameAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    public function getEmailAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}
