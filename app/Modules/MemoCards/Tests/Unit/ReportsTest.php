<?php

namespace Modules\MemoCards\Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\MemoCards\Entities\Report;
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

    /**
     * Test getting auto generated report
     */
    public function testAutoGeneratingReport()
    {
        $response = $this->get(route('work.start'));
        $currentReportIdSession = session('current_report_id');

        $report = Report::getCurrentReport();

        $this->assertInstanceOf(Report::class, $report);
        $this->assertEquals($report->id, $currentReportIdSession);
    }

    /**
     * Mutators Test
     */
    public function testMutatorTest()
    {
        $report = Report::getCurrentReport();
        $this->assertIsArray($report->data);
        $report->data = [
            'test' => 'test'
        ];

        $report->save();

        $report = Report::getCurrentReport();
        $this->assertEquals($report->data['test'], 'test');
    }

    /**
     * Test for data "json" field in table
     */
    public function testJsonDataField()
    {
        $factoryCard = factory(Card::class, 100)->create();

        $report = Report::getCurrentReport();
        $reportId = $report->id;
        $this->assertIsArray($report->data['start']);
        $response = $this->get(route('work.end'));

        $report = Report::find($reportId);

        $this->assertIsArray($report->data['end']);
        $this->assertNotEmpty($report->data['end']);
        $this->assertIsArray($report->data['result']);
        $this->assertNotEmpty($report->data['result']);
        $this->assertEquals($report->data['result']['rare'], ($report->data['end']['rare'] - $report->data['start']['rare']));
    }
}
