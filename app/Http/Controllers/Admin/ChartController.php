<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function expenseIncomeChart()
    {
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];
        $spendmonth = [];
        foreach ($months as $key => $value) {
            if ($key == date('m') + 1) {
                break;
            } else {
                $spendmonth[] = $value;
            }
        }
        $feepayment = DB::select('select year(created_at) as year, month(created_at) as month, sum(total_amount) as total_amount from fee_payments group by year(created_at), month(created_at)');
        $onlinefeepayment = DB::select('select year(created_at) as year, month(created_at) as month, sum(amount) as total_amount from payments group by year(created_at), month(created_at)');
        $expenses = DB::select('select year(created_at) as year, month(created_at) as month, sum(amount) as total_amount from expenses group by year(created_at), month(created_at)');
        // dd($onlinefeepayment);
        $temp = [];
        $tempo = [];
        $tempoo = [];
        $income = [];
        $expense = [];
        $incometotal = 0;
        $expensetotal = 0;
        $onlinetotal = 0;
        foreach ($feepayment as $key => $value) {
            if ($value->year == date('Y')) {
                $temp[$value->month] = $value->total_amount;
                $incometotal += $value->total_amount;
            }
        }
        foreach ($expenses as $key => $value) {
            if ($value->year == date('Y')) {
                $tempo[$value->month] = $value->total_amount;
                $expensetotal += $value->total_amount;
            }
        }
        foreach ($onlinefeepayment as $key => $value) {
            if ($value->year == date('Y')) {
                $tempoo[$value->month] = $value->total_amount;
                $onlinetotal += $value->total_amount;
            }
        }
        $incometotal = $incometotal + $onlinetotal;
        end($temp);
        $key = key($temp);
        for ($index = 1; $index <= $key; $index++) {
            if (isset($temp[$index])) {
                if (isset($tempoo[$index])) {
                    $income[] = $temp[$index] + $tempoo[$index];
                } else {
                    $income[] = $temp[$index];
                }
            } else {
                $income[] = 0;
            }
            if (isset($tempo[$index])) {
                $expense[] = $tempo[$index];
            } else {
                $expense[] = 0;
            }
        }
        $lastmonthincome = 0;
        $currentmonthincome = 0;
        foreach ($income as $keya => $value) {
            if ($keya == $key - 2) {
                $lastmonthincome = $value;
            }
            if ($keya == $key - 1) {
                $currentmonthincome = $value;
            }
        }
        $lastmonthexpense = 0;
        $currentmonthexpense = 0;
        foreach ($expense as $keya => $value) {
            if ($keya == $key - 2) {
                $lastmonthexpense = $value;
            }
            if ($keya == $key - 1) {
                $currentmonthexpense = $value;
            }
        }
        $data = [
            'month' => $spendmonth,
            'income' => $income,
            'expense' => $expense,
            'expensetotal' => $expensetotal,
            'incometotal' => $incometotal,
            'lastmonthincome' => $lastmonthincome,
            'currentmonthincome' => $currentmonthincome,
            'lastmonthexpense' => $lastmonthexpense,
            'currentmonthexpense' => $currentmonthexpense,
        ];
        return response()->json($data);
    }
    public function studentAttendanceChart()
    {
        $attendances = DB::select('select year(created_at) as year, month(created_at) as month, sum(amount) as total_amount from attendances group by year(created_at), month(created_at)');
        dd($attendances);
        $data = [];
        return response()->json($data);
    }
}
