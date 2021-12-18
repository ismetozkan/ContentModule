<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentsType extends Model
{
    use HasFactory;

    protected $table = 'contents_type';

    protected $fillable = [
        'type',
        'template'
    ];
}
