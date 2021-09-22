<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    public function state()
    {
        return $this->belongsTo(state::class);
    }

    public function organizationDetail()
    {
        return $this->hasMany(OrganizationDetail::class);
    }
}
