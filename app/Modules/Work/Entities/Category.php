<?php

namespace Modules\Work\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'icon_path',
    ];

    /**
     * eloquent Relation
     *
     * @return Modules\Work\Entities\Card
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
