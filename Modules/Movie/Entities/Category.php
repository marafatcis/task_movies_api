<?php

namespace Modules\Movie\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function categories(){
        return $this->belongsToMany('movies','category_movie');
    }
    
    protected static function newFactory()
    {
        return \Modules\Movie\Database\factories\CategoryFactory::new();
    }
}
