<?php

namespace Modules\MemoCards\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Report extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'total',
        'right',
        'wrong',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'report_data' => 'array',
    ];

    /**
     * Get last report
     */
    public static function getLast()
    {
        return self::latest()->first();
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::created(function ($report) {

            $reportData = [
                'start' => self::calculateCardsStatistic(),
                'end' => self::emptyCardsStatistic(),
                'result' => self::emptyCardsStatistic(),
            ];

            $report->data = $reportData;
            $report->save();
        });
    }

    /**
     * Increment Right or wrong value
     *
     * @param bool $isCorrect
     */
    public static function updateReport(bool $isCorrect)
    {
        $reportId = self::getId();

        if (!$reportId) {
            throw new \Exception('No current_report_id');
        }

        $report = self::find($reportId);

        if ($isCorrect) {
            $report->increment('right');
        } else {
            $report->increment('wrong');
        }

        $report->increment('total');
    }

    /**
     * Get id if exists or creates and returns if not.
     *
     * @return int $reportId
     */
    public static function getId()
    {
        $reportId = Session::get('current_report_id');

        if (!$reportId) {
            $report = Report::create();
            $reportId = $report->id;
            session(['current_report_id' => $reportId]);
        }

        return $reportId;
    }

    /**
     * Get current report instance
     * Create if not exist
     */
    public static function getCurrentReport()
    {
        return self::find(self::getId());
    }

    /**
     * Calculate difference and Close report
     */
    public static function close()
    {
        $report = self::getCurrentReport();
        $reportData = $report->data;

        $start = $reportData['start'];
        $end = self::calculateCardsStatistic();
        $diff = self::emptyCardsStatistic();

        foreach ($diff as $key => $val) {
            $diff[$key] = $end[$key] - $start[$key];
        }

        $reportData['end'] = $end;
        $reportData['result'] = $diff;
        $report->data = $reportData;
        $report->save();

        Session::forget('current_report_id');
    }

    /**
     * Calculate Card's Statistic
     *
     * @return array
     */
    public static function calculateCardsStatistic()
    {
        $uniqueLevel = env('UNIQUE_LEVEL', 9);
        $cards = Card::all();
        $sortedCards = self::emptyCardsStatistic();

        foreach ($cards as $card) {
            if (!$card->total) {
                $sortedCards['new']++;
            }

            if ($card->level <= 1) {
                $sortedCards['normal']++;
            } elseif ($card->level == 2) {
                $sortedCards['magic']++;
            } elseif ($card->level > 2 && $card->level < $uniqueLevel) {
                $sortedCards['rare']++;
            } elseif ($card->level >= $uniqueLevel) {
                $sortedCards['unique']++;
            }
        }
        return $sortedCards;
    }


    /**
     * @return array
     */
    public static function emptyCardsStatistic()
    {
        return [
            'new' => 0,
            'normal' => 0,
            'magic' => 0,
            'rare' => 0,
            'unique' => 0,
        ];
    }

    /**
     * Get report_data
     *
     * @return array
     */
    public function getDataAttribute()
    {
        return $this->report_data;
    }

    /**
     * Set report_data
     *
     * @param $value
     */
    public function setDataAttribute($value)
    {
        $this->report_data = $value;
    }
}
