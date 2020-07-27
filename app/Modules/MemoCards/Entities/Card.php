<?php

namespace Modules\MemoCards\Entities;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'level',
        'right',
        'wrong',
        'total',
    ];
}
