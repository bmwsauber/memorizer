<?php

namespace Modules\MemoCards\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\MemoCards\Entities\Report;
use Tests\TestCase;
use Modules\MemoCards\Entities\Card;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WorkTest extends TestCase
{
    /**
     * Keep you database clean
     */
    use DatabaseTransactions;

    /**
     * Modules\MemoCards\Entities\Card
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
            'forcedLevel' => 1,
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
            $this->assertEquals(($factoryCard->wrong + 1), $this->card->wrong);
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
}
