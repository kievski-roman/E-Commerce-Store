<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['user_id', 'name', 'address_line', 'city', 'state', 'postal_code', 'country', 'is_default'];
}
