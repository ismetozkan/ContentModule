<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentToType extends Model
{
    use HasFactory;

    protected $table = 'contents_to_types';

    protected $fillable = [
        'content_id',
        'type_id'
    ];

   public function type()
   {
       return $this->hasOne(ContentTypes::class, 'id','type_id');
   }
}
