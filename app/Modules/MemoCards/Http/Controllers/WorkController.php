<?php

namespace Modules\MemoCards\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Modules\MemoCards\Entities\Card;
use Modules\MemoCards\Entities\Report;
use Symfony\Component\Routing\Matcher\RedirectableUrlMatcher;

class WorkController extends Controller
{
    /**
     * Create new report
     * Redirect to show
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function start()
    {
        $report = Report::create();

        session(['current_report_id' => $report->id]);

        return \redirect(route('work.show', $report->id));
    }

    /**
     * Decrease "level" value to all cards
     * Flush session and redirect to homepage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function end()
    {
        Card::where([
            ['level', '>', 1],
            ['level', '<', 9],
        ])
            ->decrement('level');

        Session::forget('current_report_id');

        return \redirect(route('home'));
    }

    /**
     * Show cards with level "1".
     *
     * @param Report $report
     * @return \Illuminate\View\View
     */
    public function show(Report $report)
    {
        /**
         * Get collection of cards with "level" 1
         */
        $cards = Card::where('level', '<=', 1)
            ->inRandomOrder()
            ->get();
        return view('memocards::work', [
            'cards' => $cards,
            'report_id' => $report->id,
        ]);
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
             * business logic is should be placed in a model.
             */
            $card->calculateAndSaveNewLevel((bool)$request->get('isCorrect'), $request->get('forcedLevel'), $request->get('isFavourite'));
        } catch (e $exception) {
            return $exception->getMessage();
        }

        return true;
    }
}
