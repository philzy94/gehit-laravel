<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    public function location()
    {
        return $this->hasMany(Location::class);
    }

    public function organizationDetail()
    {
        return $this->hasMany(OrganizationDetail::class);
    }
}
