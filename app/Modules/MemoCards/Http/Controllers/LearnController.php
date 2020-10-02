<?php

namespace Modules\MemoCards\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\MemoCards\Entities\Card;
use Modules\MemoCards\Entities\Report;

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

        return view('memocards::learn', ['cards' => $cards]);
    }
}
