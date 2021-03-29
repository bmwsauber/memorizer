<?php

namespace Modules\Work\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Card extends Model
{
    /**
     * @var $this->rus = question
     * @var $this->eng = answer
     * @var $this->total = this card was shown and answer was given total $this->total times
     * @var $this->right = user was answered on this card correctly $this->right times
     * @var $this->wrong = user was answered on this card incorrectly $this->wrong times
     * @var $this->level = this card will be ready to show after $this->level lessons. $this->level = 1 - card is ready.
     * @var $this->favourite = this flag point at will be shown this card after env('UNIQUE_LEVEL') right answers or not.
     */

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

    /**
     * @var string[]
     */
    protected $with = [
        'category'
    ];

    /**
     * Update card "Worth" according to answer result
     *
     * @param Request $request
     * @return $this
     */
    public function updateCardWorthProperties(Request $request)
    {
        $isAnswerCorrect = $request->get('isCorrect');
        $isFavouriteCard = $request->get('isFavourite');

        // the difference between the right and the wrong answers
        $knowledgeBalance = $this->right - $this->wrong;

        // this var helps to reduce the card level more
        // if card is "old". It improves the main logic.
        $punishment = ($knowledgeBalance > 0) ? 2 : 1;

        if ($isAnswerCorrect) {
            $this->total++;
            $this->right++;
            $this->level = ($knowledgeBalance > 0) ? ++$knowledgeBalance : 1;
            $this->favourite = $isFavouriteCard;
        } else {
            $this->total++;
            $this->level = 1;
            $this->wrong += $punishment;
            $this->favourite = 1;
        }

        return $this;
    }

    /**
     * eloquent Relation
     *
     * @return Modules\Work\Entities\Category
     */
    public
    function category()
    {
        return $this->belongsTo(Category::class);
    }
}
