<?php

namespace Modules\Work\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Work\Entities\Card;
use Modules\Report\Entities\Report;

class LearnController extends Controller
{
    /**
     * Show cards with total "0".
     *
     * @param Report $report
     * @return \Illuminate\View\View
     */
    public function show(Report $report)
    {
        $cards = Card::where(['total' => 0])->get();

        return view('work::learn', ['cards' => $cards]);
    }
}
