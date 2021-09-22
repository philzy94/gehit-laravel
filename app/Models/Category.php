<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $hidden = [
        'category_id',
        'created_at',
        'updated_at',
    ];

    public function subcategory()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function organizationDetail()
    {
        return $this->hasMany(OrganizationDetail::class);
    }
}
