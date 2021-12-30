<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentLog extends Model
{
    use HasFactory;

    protected $table='contents_log';

    protected $fillable=[
        'user_id',
        'route_name',
        'content',
        'content_id',
        'log'
    ];


}
