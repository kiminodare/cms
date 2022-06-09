<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class article_category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    public function article(){
    	return $this->hasMany('App\Models\article','id_category');
    }
}
