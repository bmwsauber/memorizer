<?php

namespace Modules\MemoCards\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\MemoCards\Entities\Card;
use Modules\MemoCards\Entities\Report;

class WorkController extends Controller
{
    /**
     * Create new report
     * Redirect to show
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function start($mode)
    {
        switch ($mode) {
            case 'repeat':
                return \redirect(route('work.repeat', Report::getId()));
                break;
            case 'listening':
                return \redirect(route('work.listening', Report::getId()));
                break;
            case 'idioms':
                return \redirect(route('work.idioms', Report::getId()));
                break;
        }
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
        ])->orWhere([
            ['favourite', 1],
            ['level', '>', 1],
        ])->decrement('level');

        Report::close();

        return \redirect(route('home'));
    }

    /**
     * Work mode: reading and listening
     * Get collection of cards with "level" 1
     * @param Report $report
     * @return \Illuminate\View\View
     */
    public function repeat(Report $report)
    {
        $collectionLimit = env('WORK_COLLECTION_LIMIT', 60);
        $cardsCollection = Card::where('level', '<=', 1)
            ->inRandomOrder()
            ->limit($collectionLimit)
            ->get();

        return $this->show($report, $cardsCollection, 'repeat');
    }

    /**
     * Work mode: listening
     * Get collection of cards with "level" 1
     *
     * @param Report $report
     * @return \Illuminate\View\View
     */
    public function listening(Report $report)
    {
        $collectionLimit = env('WORK_COLLECTION_LIMIT', 60);
        $cardsCollection = Card::where('level', '<=', 1)
            ->inRandomOrder()
            ->limit($collectionLimit)
            ->get();

        return $this->show($report, $cardsCollection, 'listening');
    }

    /**
     * Work mode: Only "Idioms" Category
     * Get collection of cards with "level" 1
     *
     * @param Report $report
     * @return \Illuminate\View\View
     */
    public function idioms(Report $report)
    {
        $collectionLimit = env('WORK_COLLECTION_LIMIT', 60);
        $cardsCollection = Card::where('level', '<=', 1)
            ->where('category_id', 8)
            ->inRandomOrder()
            ->limit($collectionLimit)
            ->get();

        return $this->show($report, $cardsCollection, 'repeat');
    }

    /**
     * Show cards collection.
     *
     * @param Report $report
     * @param $cardsCollection
     * @param bool $mode
     * @return \Illuminate\View\View
     */
    public function show(Report $report, $cardsCollection, $mode)
    {
        return view('memocards::work', [
            'cards' => $cardsCollection,
            'report_id' => $report->id,
            'mode' => $mode,
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
