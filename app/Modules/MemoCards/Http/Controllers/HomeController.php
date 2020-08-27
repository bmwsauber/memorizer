<?php

namespace Modules\MemoCards\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\MemoCards\Entities\Card;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cards = Card::all();
        $sortedCards = ['new' => [], 'magic' => [], 'rare' => [], 'unique' => []];

        foreach ($cards as $card) {
            if ($card->total === 0) {
                $sortedCards['new'][] = $card;
            }

            if ($card->level == 1) {
                $sortedCards['normal'][] = $card;
            } elseif ($card->level > 1 && $card->level <= 4) {
                $sortedCards['magic'][] = $card;
            } elseif ($card->level > 4 && $card->level <= 10) {
                $sortedCards['rare'][] = $card;
            } elseif ($card->level > 10) {
                $sortedCards['unique'][] = $card;
            }
        }

        return view('memocards::home', [
            'sortedCards' => $sortedCards,
            'cards' => $cards,
            'rightSum' => $cards->sum('right'),
            'wrongSum' => $cards->sum('wrong'),
        ]);
    }
}
