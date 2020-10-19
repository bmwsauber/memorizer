<?php

namespace Modules\MemoCards\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Modules\MemoCards\Entities\Card;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CardsTestTest extends TestCase
{
    /**
     * Keep you database clean
     */
    use DatabaseTransactions;

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
    public function testLearnResponsePage()
    {
        $response = $this->get(route('cards.learn'));
        $response->assertStatus(200);
    }

}