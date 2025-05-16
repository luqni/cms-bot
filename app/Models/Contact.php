<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    public function phoneNumbers()
    {
        return $this->hasMany(PhoneNumber::class);
    }
}

