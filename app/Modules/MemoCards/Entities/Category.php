<?php

namespace Modules\MemoCards\Entities;

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
     * @return Modules\MemoCards\Entities\Card
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }
}
