<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'id_category'
    ];
    public function article(){
    	return $this->belongsTo('App\Models\article_category');
    }
}
