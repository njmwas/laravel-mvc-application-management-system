<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'banner'] ;

    public $validation_rules = [
        "name"=> ["required","string"],
        "slug"=> ["string"],
        "banner"=>["url"]
    ];

    public function products(): HasMany{
        return $this->hasMany(Product::class);
    }
}
