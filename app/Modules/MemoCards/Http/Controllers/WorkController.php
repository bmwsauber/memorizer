<?php

namespace Modules\MemoCards\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MemoCards\Entities\Card;
use Modules\MemoCards\Entities\Report;

class WorkController extends Controller
{
    /**
     * Show cards with level "1".
     * Prepare other cards (decrease level)
     *
     * @return Response
     */
    public function index()
    {
        /**
         * Get collection of cards with "level" 1
         */
        $cards = Card::where('level', '<=', 1)
            ->orderBy('total', 'ASC')
            ->inRandomOrder()
            ->get();

        /**
         * Decrease "level" value to all cards
         */
        Card::where(
            [
                ['level', '>', 1],
            ]
        )->decrement('level');

        return view('memocards::work', ['cards' => $cards]);
    }

    /**
     * Save to database an answer result
     * calculate in the model when card will be appeared again
     *
     * @param Card $card
     * @param Request $request
     * @return bool|string
     */
    public function setCardLevel(Card $card, Request $request)
    {
        try {
            /**
             * Keep controller "thin" ;)
             * business logic should be placed in the model.
             */
            $card->calculateAndSaveNewLevel((bool)$request->get('isCorrect'));
        } catch (e $exception) {
            return $exception->getMessage();
        }

        return true;
    }
}
