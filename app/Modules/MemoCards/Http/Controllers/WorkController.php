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
        return \redirect(route('work.show', Report::getId()));
    }

    /**
     * Decrease "level" value to all cards
     * Flush session and redirect to homepage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function end()
    {
        $uniqueLevel = env('UNIQUE_LEVEL', 9);

        Card::where([
            ['level', '>', 1],
            ['level', '<', $uniqueLevel],
        ])->orWhere('favourite', 1)
            ->decrement('level');

        Report::close();

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
            ->limit(60)
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
     * @throws \Exception
     */
    public function setCardLevel(Card $card, Request $request)
    {
        try {
            /**
             * Keep controller "thin" ;)
             * business logic is should be placed in a model.
             */
            $card->calculateAndSaveNewLevel((bool)$request->get('isCorrect'), $request->get('forcedLevel'), $request->get('isFavourite'));
            Report::updateReport((bool)$request->get('isCorrect'));
        } catch (e $exception) {
            return $exception->getMessage();
        }

        return true;
    }
}
