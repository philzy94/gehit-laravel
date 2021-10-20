<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
        'state_id',
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

        'updated_at',
        'created_at',
        
    ];

    public function state()
    {
        return $this->belongsTo(state::class);
    }

    public function organizationDetail()
    {
        return $this->hasMany(OrganizationDetail::class);
    }
}
