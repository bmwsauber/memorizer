<?php

namespace Modules\MemoCards\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Modules\MemoCards\Entities\Card;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportsTest extends TestCase
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
    public function _testReportResponsePage()
    {
        //$response = $this->get(route('report.index'));
        //$response->assertStatus(200);
    }

    /**
     * First of all we need to create new report
     * get report id and redirect to work page with the right url
     */
    public function testCreatingReportAndRedirect()
    {
        $response = $this->get(route('work.start'));
        $response->assertStatus(302);
        $response->assertRedirect(route('work.show', session('current_report_id')));
    }
}
