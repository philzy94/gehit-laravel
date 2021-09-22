<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'Full_name',
        'Phone_number',
        'Profile_photo',
        'user_id'
    ];
    protected $hidden = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function organizationDetail()
    {
        return $this->hasMany(OrganizationDetail::class);
    }
}
