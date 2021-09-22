<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationDetail extends Model
{
    use HasFactory;

    protected $hidden = [
        'profile_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function comment()
    {
        return $this->hasOnes(Comment::class);
    }

    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }
}
