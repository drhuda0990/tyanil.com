<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use App\Financial;


class FinancialCount extends Value
{

    public function name()
    {
        return 'المالية';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        if ($request->resourceId) {
            return $this->sum($request, Financial::with('course_trainee')->whereHas('course_trainee', function ($q) {
                $q->where('activate', 1);
            })->where('course_id', '=', $request->resourceId), 'amount')
                ->format('0,0')
                ->prefix('')
                ->suffix('ريال سعودي');
        } else {
                return $this->sum($request, Financial::with('course_trainee'), 'amount')
                ->format('0,0')
               
                ->suffix('ريال سعودي');
            // return $this->sum($request, Financial::with('course_trainee')->whereHas('course_trainee', function ($q) {
            //     $q->where('activate', 1);
            // }), 'amount')
            //     ->format('0,0')
               
            //     ->suffix('ريال سعودي');
        }
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            'TODAY' => 'اليوم',
             2=>'يومين',
            5=>'5 ايام',
        10 => '10 ايام',
        15 => '15 يوم',
            30 => '30 يوم',
            60 => '60 يوم',
            365 => '365 يوم',
            'MTD' => 'Month To Date',
            'QTD' => 'Quarter To Date',
            'YTD' => 'Year To Date',
        ];
    }

    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'financial-count';
    }
}
