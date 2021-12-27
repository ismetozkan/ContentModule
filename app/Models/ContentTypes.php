<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentTypes extends Model
{
    use HasFactory;

    protected $table='content_types';

    protected $fillable = [
        'type',
        'template'
    ];

    public function typeToLog()
    {
        return $this->belongsTo(ContentLog::class,'log','type');
    }

}
