<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    use HasFactory;

    protected $fillable = ['contact_id', 'name', 'number'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}

