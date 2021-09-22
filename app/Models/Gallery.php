<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    public function organizationDetail()
    {
        return $this->belongsTo(organizationDetail::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
