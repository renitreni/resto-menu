<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'parent_category_id',
        'name',
        'discount',
    ];

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'parent_category_id', 'id');
    }

    public function descendantCategory()
    {
        return $this->belongsTo(Category::class, 'parent_category_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
