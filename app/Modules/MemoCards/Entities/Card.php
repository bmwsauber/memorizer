<?php

namespace Modules\MemoCards\Entities;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'rus',
        'eng',
        'level',
        'right',
        'wrong',
        'total',
        'irreg_verb',
    ];

    protected $with = [
        'category'
    ];

    /**
     * Save to database an answer result
     * calculate when card will be appeared again
     *
     * @param bool $isCorrect
     * @param int $forcedLevel
     * @param null $isFavourite
     * @return $this
     */
    public function calculateAndSaveNewLevel(bool $isCorrect, int $forcedLevel = 1, $isFavourite = 0)
    {
        if ($isCorrect) {

            /**
             * The logic is
             * new level = right answers + 1 - wrong answers
             * +1 because new answer was the right
             */
            $level = ($this->right + 1) - $this->wrong;

            if ($level < 1) {
                $level = 1;
            }

            $this->increment('total', 1, [
                'level' => $level,
                'right' => ($this->right + 1),
                'favourite' => $isFavourite,
            ]);

        } else {

            /**
             * if last answer was wrong
             * the card will be appeared next time.
             * just set level = 1
             */
            $level = 1;

            /**
             * If correct answer count more then incorrect one, your level will be reduce.
             */
            $punishment = (($this->right - $this->wrong) > 0) ? 2 : 1 ;

            $this->increment('total', 1, [
                'level' => $level,
                'wrong' => ($this->wrong + $punishment),
                'favourite' => 1,
            ]);
        }

        return $this;
    }

    /**
     * eloquent Relation
     *
     * @return Modules\MemoCards\Entities\Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
