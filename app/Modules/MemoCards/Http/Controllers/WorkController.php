<?php

namespace Modules\MemoCards\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MemoCards\Entities\Card;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
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
            ->get(['id', 'eng', 'rus', 'irreg_verb']);

        /**
         * Decrease "level" value to other cards
         * if "level" more than 10, we won't show this card newer
         */
        Card::where(
            [
                ['level', '<=', 10],
                ['level', '>', 1],
            ]
        )->decrement('level');

        return view('memocards::work', ['cards' => $cards]);
    }

    public function setCardLevel(Card $card, Request $request)
    {
        return $card->increment('total', 1, ['level' => $request->get('level')]);
    }
}
