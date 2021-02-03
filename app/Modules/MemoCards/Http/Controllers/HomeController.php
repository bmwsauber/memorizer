<?php

namespace Modules\MemoCards\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\MemoCards\Entities\Card;
use Modules\MemoCards\Entities\Report;

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
        $sortedCards = Report::calculateCardsStatistic();
        $lastReport = Report::getLast();

        return view('memocards::home', [
            'sortedCards' => $sortedCards,
            'cards' => $cards,
            'rightSum' => $cards->sum('right'),
            'wrongSum' => $cards->sum('wrong'),
            'lastReport' => $lastReport,
            'lastReportData' => $lastReport->data,
        ]);
    }
}
