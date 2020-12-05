<?php

namespace Modules\MemoCards\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\MemoCards\Entities\Report;
use Tests\TestCase;
use Modules\MemoCards\Entities\Card;
use Modules\MemoCards\Entities\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoriesTest extends TestCase
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
     * The Card has to has a category
     */
    public function testGetCategoryFromCard()
    {
        $factoryCard = factory(Card::class)->create();
        $card = Card::find($factoryCard->id)->first();

        $this->assertIsString($card->category->name);
    }

    /**
     * The Categories have to has cards
     */
    public function testGetCardsFromCategories()
    {
        $catFactory = factory(Category::class, 3)
            ->create()
            ->each(function ($category) {
                $category->cards()->createMany(
                    factory(Card::class, 10)->create()->toArray()
                );
            });

        $this->assertEquals($catFactory->count(), 3);
        $this->assertEquals($catFactory->first()->cards()->count(), 10);
        $this->assertIsString($catFactory->first()->cards()->first()->eng);
    }
}
