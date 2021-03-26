<?php

namespace Modules\Work\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Report\Entities\Report;
use Tests\TestCase;
use Modules\Work\Entities\Card;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkTest extends TestCase
{
    /**
     * Keep you database clean
     */
    use DatabaseTransactions;

    /**
     * Modules\Work\Entities\Card
     */
    protected $card;

    /**
     * Initialize
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    /**
     * Response page test
     */
    public function testIndexResponsePage()
    {
        factory(Report::class)->create();
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    /**
     * Response page test
     */
    public function testWorkResponsePage()
    {
        /**
         * Making a Report
         */
        $factoryReport = factory(Report::class)->create();

        $response = $this->get(route('work.listening', $factoryReport->id));
        $response->assertStatus(200);
    }

    /**
     * When user give an answer (correct or not) script should
     * calculate when this card will be show again
     */
    public function testCalculateAndSaveNewLevel()
    {
        /**
         * The variants of sending data.
         */
        $isCorrectVariants = [
            true,
            false,
            1,
            0,
            5,
            'a',
        ];

        /**
         * Check'em all :)
         */
        foreach ($isCorrectVariants as $isCorrect) {
            $this->_calculateAndSaveNewLevel($isCorrect);
        };
    }

    /**
     * When user give an answer (correct or not) script should
     * calculate when this card will be show again
     */
    protected function _calculateAndSaveNewLevel($isCorrect)
    {
        /**
         * Making a Card
         */
        $factoryCard = factory(Card::class)->create();

        /**
         * Sending request with params
         */
        $response = $this->post(route('work.set_level', $factoryCard->id), [
            'isCorrect' => $isCorrect,
        ]);

        /**
         * Checking page response status
         */
        $response->assertStatus(200);

        /**
         * Refreshing Card data
         */
        $this->card = Card::find($factoryCard->id);

        /**
         * Checking result
         */
        if ($isCorrect) {
            $this->assertEquals(($factoryCard->right + 1), $this->card->right);
            $this->assertEquals(($factoryCard->total + 1), $this->card->total);
            $this->assertEquals($factoryCard->wrong, $this->card->wrong);
        } else {
            $this->assertEquals(($factoryCard->right), $this->card->right);
            $this->assertEquals(($factoryCard->total + 1), $this->card->total);
            if ($factoryCard->right > $factoryCard->wrong) {
                $this->assertEquals(($factoryCard->wrong + 2), $this->card->wrong); //penalty 2 points
            } else {
                $this->assertEquals(($factoryCard->wrong + 1), $this->card->wrong); //penalty 1 point
            }
        }

        /**
         * Checking calculations
         *
         * if wrong answers was more, we need to show this card on the next work session.
         * just set level = 1
         */
        if ($this->card->wrong >= $this->card->right || !$isCorrect) {
            $this->assertEquals($this->card->level, 1);

            /**
             * It was very easy, let's go one more time :)
             */
            $this->_calculateAndSaveNewLevel(true);
        } else {
            $this->assertEquals($this->card->level, $this->card->right - $this->card->wrong);
        }
    }

    /**
     * Return all old cards to stack
     * Set random level to cards from 1 to $uniqueLevel
     * And redirect home
     */
    public function testShuffleOldCards()
    {
        $uniqueLevel = (int)env('UNIQUE_LEVEL', 9);

        $factoryCard = factory(Card::class)->create();

        // ensure card level "Unique"
        $factoryCard->update(['level' => $uniqueLevel]);

        //check count before shuffle
        $cardsCount = Card::where('level', '>=', $uniqueLevel)->count();

        //do shuffle
        $response = $this->get(route('work.shuffle'));

        //must be 0
        $cardsCount = Card::where('level', '>=', $uniqueLevel)->count();

        $this->assertEquals($cardsCount, 0);
        $response->assertSessionHas('success');
        $response->assertRedirect(route('home'));
    }
}
