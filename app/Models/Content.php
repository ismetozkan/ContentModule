<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable=[
        'title',
        'slug',
        'content'
    ];

    //public function contentToType()
    //{
      //  return $this->belongsTo(ContentToType::class,'id','content_id');
 //   }
}
