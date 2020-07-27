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
     * @return Response
     */
    public function index()
    {
        $cards = Card::all();
        $sortedCards = [];
        foreach ($cards as $card) {
            if($card->level == 1){
                $sortedCards['regular'][] = $card;
            }elseif ($card->level > 1 && $card->level <= 3){
                $sortedCards['magic'][] = $card;
            }elseif ($card->level > 3 && $card->level <= 5){
                $sortedCards['rare '][] = $card;
            }elseif ($card->level > 5 && $card->level <= 10) {
                $sortedCards['unique'][] = $card;
            }elseif ($card->level > 10){
                $sortedCards['legendary'][] = $card;
            }
        }

        return view('memocards::home', [
            'sortedCards' => $sortedCards,
            'cards' => $cards,
            'asd' => 'asd',
        ]);
    }
}
