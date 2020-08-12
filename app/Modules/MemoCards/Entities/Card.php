<?php

namespace Modules\MemoCards\Entities;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'level',
        'right',
        'wrong',
        'total',
        'irreg_verb',
    ];

    /**
     * Save to database an answer result
     * calculate when card will be appeared again
     *
     * @param bool $isCorrect
     * @return $this
     */
    public function calculateAndSaveNewLevel(bool $isCorrect)
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
            ]);

        } else {

            /**
             * if last answer was wrong
             * the card will be appeared next time.
             * just set level = 1
             */
            $level = 1;

            $this->increment('total', 1, [
                'level' => $level,
                'right' => ($this->wrong + 1),
            ]);
        }

        return $this;
    }
}
