<?php

namespace Modules\Movie\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoryMovie extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table ='category_movie';
    
    protected static function newFactory()
    {
        return \Modules\Movie\Database\factories\CategoryMovieFactory::new();
    }
}
