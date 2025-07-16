<?php

// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;

    protected $casts = [
        'dob' => 'date',
    ];

    protected $fillable = ['first_name', 'last_name', 'dob', 'gender', 'mobile'];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}

