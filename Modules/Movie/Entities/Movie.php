<?php

namespace Modules\Movie\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function categories(){
        return $this->belongsToMany('categories','category_movie');
    }
    
    protected static function newFactory()
    {
        return \Modules\Movie\Database\factories\MovieFactory::new();
    }
}
