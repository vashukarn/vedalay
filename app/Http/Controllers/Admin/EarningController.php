<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\RidingPayment;
use Illuminate\Http\Request;

class EarningController extends Controller
{

    public function monthlyTopEarners(Request $request){
        $limit = 20;
        if ($request->limit && $request->limit > 0  && $request) {
            $limit = $request->limit;
        }
        $query = RidingPayment::select(\DB::raw('SUM(total_amount) as total_earning'), 'rider_id');
        $query = $query->with('get_rider')
        ->groupBy('rider_id', 'total_amount')
        ->orderBy('total_earning', 'DESC');
        if ($request->start_date  && $request->end_date) {
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
        }
        if (isset($start_date) && isset($end_date)) {
            $query =  $query->whereBetween('created_at', [$start_date, $end_date]);
        }else {
            $query = $query->whereBetween('created_at', [date('Y-m-01'), date('Y-m-d')]);
        }
        $top_earners = $query->paginate($limit);
        // dd($top_earners);
        $data = [
            'top_earners' => $top_earners,
            'page_title' => 'Top Earners'
        ];
        return view('admin/report/earning/top-earners', $data);

    }

    // public function todayEarning(Request $request)
    // {
    //     $date = date('Y-m-d');
    //     // $earnings = RidingPayment::select(
    //     //     \DB::raw('SUM(total_amount) as total , timestamps(created_at) as date' ))
    //     //     // ->where('created_at', $date)
    //     //     // ->groupBy(function($hour){
    //     //     //     dd($hour);
    //     //     //     // return date('Y-m-d H',strtotime($hour->created_at));
    //     //     // })
    //     //         ->groupBy( 'date', 'total')
    //     //     ->get();
    //     // dd($earnings);
    //     $limit = 20;
    //     if ($request->limit && $request->limit > 0  && $request) {
    //         $limit = $request->limit;
    //     }
    //     // if ($request->start_date  && $request->end_date) {
    //     //     $start_date = date('Y-m-d', strtotime($request->start_date));
    //     //     $end_date = date('Y-m-d', strtotime($request->end_date));
    //     // }
    //     // $query = RidingPayment::select('*')->with([
    //     //     'get_customer' => function ($qr) {
    //     //         return $qr->select('name', 'mobile');
    //     //     },
    //     //     'get_rider' => function ($qr) {
    //     //         return $qr->select('name', 'mobile');
    //     //     }
    //     // ]);
    //     $query = RidingPayment::select('*')->with([
    //         'get_customer' => function ($qr) {
    //             return $qr->select('name', 'mobile');
    //         },
    //         'get_rider' => function ($qr) {
    //             return $qr->select('name', 'mobile');
    //         }
    //     ]);
    //     // $query  = $query
    //     // ->where('created_at',[date('Y-m-d h:i:s'), date('Y-m-d h:i:s')]) ;
    //     $earnings = $query->paginate($limit);
    //     // dd($earnings);
    //     $data  = [
    //         'earnings' => $earnings,
    //         "page_title" => 'Total Earnings'
    //     ];
    //     return view('admin/report/earning/daily-report', $data);
    // }
    // public function allEarning(Request $request)
    // {
    //     // dd('hello');
    //     $date = date('Y-m-d');
    //     $limit = 20;
    //     if ($request->limit && $request->limit > 0 && $request->limit < 101) {
    //         $limit = $request->limit;
    //     }
    //     if ($request->start_date  && $request->end_date) {
    //         $start_date = date('Y-m-d', strtotime($request->start_date));
    //         $end_date = date('Y-m-d', strtotime($request->end_date));
    //     }
    //     $query = RidingPayment::select(
    //         \DB::raw(' DATE(created_at) as date,  SUM(total_amount) as total'),
    //         \DB::raw('SUM(total_amount) as subtotal')
    //     );

    //     // ->where('date', $date)
    //     if (isset($start_date) && isset($end_date)) {
    //         $query =  $query->whereBetween('created_at', [$start_date, $end_date]);
    //     }
        
    //     $earnings = $query->groupBy('date')
    //         ->orderBy('date', 'DESC')
    //         ->paginate($limit);
    //     // dd($earnings);
        
    //     $data  = [
    //         'earnings' => $earnings,
    //         "page_title" => 'Total Earnings'
    //     ];
    //     // dd($data);
    //     return view('admin/report/earning/earning-report', $data);
    // }

    public function todayEarning(Request $request)
    {
        if($request->filter)
        {
            // dd(Carbon::today());
            // dd($request->all());
            $number = $request->number;
            $name = $request->name;
            $date = $request->start_date;


            // dd($date);

        $filterData = RidingPayment::select('riding_payments.*')->join('users as u1','u1.id','riding_payments.customer_id')
            ->join('users as u2','u2.id','riding_payments.rider_id')
            ->when($number, function ($query, $number){
                return $query->where("u1.mobile", "LIKE", "%$number%")
                            ->orWhere("u2.mobile", "LIKE", "%$number%");
            })
            ->when($name, function ($query, $name){
                return $query->where("u1.name", "LIKE", "%$name%")
                            ->orWhere("u2.name", "LIKE", "%$name%");
            })
            ->when($date, function ($query, $date){
                $date1 = date('Y-m-d 00:00:00', strtotime($date));
                $date2 = date('Y-m-d 23:59:59', strtotime($date));
                return $query->whereBetween("riding_payments.created_at",[$date1,$date2]);
            })
            ->paginate($request->limit ?? 20);
            // dd($filterData);
            $data  = [
                'earnings' => $filterData,
                "page_title" => 'Total Earnings'
            ];
            // dd($filterData);
        }else{
            // dd($request->limit);
            $date = date('Y-m-d');

            $createdAt = Carbon::today();
            $earnings = RidingPayment::whereDate('created_at', $createdAt)
                ->paginate($request->limit ?? 20);
            // dd($earnings);

            $data  = [
                'earnings' => $earnings,
                "page_title" => 'Total Earnings'
            ];
        }

        return view('admin/report/earning/daily-report', $data);
    }

    public function allEarning(Request $request)
    {
        if($request->filter)
        {
            // dd(Carbon::today());
            // dd($request->all());
            $number = $request->number;
            $name = $request->name;
            $date = $request->start_date;

            $filterData = RidingPayment::join('users as u1','u1.id','riding_payments.customer_id')
                ->join('users as u2','u2.id','riding_payments.rider_id')
                ->when($number, function ($query, $number){
                    return $query->where("u1.mobile", "LIKE", "%$number%")
                                ->orWhere("u2.mobile", "LIKE", "%$number%");
                })
                ->when($name, function ($query, $name){
                    return $query->where("u1.name", "LIKE", "%$name%")
                                ->orWhere("u2.name", "LIKE", "%$name%");
                })
                ->when($date, function ($query, $date){
                    $date1 = date('Y-m-d 00:00:00', strtotime($date));
                    $date2 = date('Y-m-d 23:59:59', strtotime($date));
                    return $query->whereBetween("riding_payments.created_at",[$date1,$date2]);
                })
                ->select(\DB::raw('riding_payments.rider_id rider, SUM(riding_payments.total_amount) data, riding_payments.created_at as created_at'))
                ->groupBy('rider','created_at')
                ->paginate($request->limit ?? 20);
                
                // dd($filterData);
                // foreach($filterData as $row)
                // {
                //     if($date){
                //         $row->created_at = $date;
                //     }else{
                //         $row->created_at = Carbon::today();
                //     }
                // }
            $data  = [
                'earnings' => $filterData,
                "page_title" => 'Total Earnings'
            ];

        }
        else{
            $createdAt = Carbon::today();
            $earnings = RidingPayment::whereDate('created_at', $createdAt)
                ->select(\DB::raw('rider_id rider, SUM(total_amount) data'))
                ->groupBy('rider')
                ->paginate($request->limit ?? 20);
            // dd($earnings);
            foreach($earnings as $row)
            {
                $row->created_at = $createdAt;
            }
    
            $data  = [
                'earnings' => $earnings,
                "page_title" => 'Total Earnings'
            ];
        }

        return view('admin/report/earning/earning-report', $data);
    }


    public function topEarners (Request $request){
        $limit = 20;
        if ($request->limit && $request->limit > 0 && $request->limit < 101) {
            $limit = $request->limit;
        }
        $query = RidingPayment::select(\DB::raw('SUM(total_amount) as total_earning'), 'rider_id');
        $query = $query->with('get_rider')
        ->groupBy('rider_id', 'total_amount')
        ->orderBy('total_earning', 'DESC');
        if ($request->start_date  && $request->end_date) {
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
        }
        if (isset($start_date) && isset($end_date)) {
            $query =  $query->whereBetween('created_at', [$start_date, $end_date]);
        }else {
            $query = $query->where('created_at', date('Y-m-d'));
        }
        $top_earners = $query->paginate($limit);
        // dd($top_earners);
        $data = [
            'top_earners' => $top_earners,
            'page_title' => 'Daily Top Earners'
        ];
        // dd($data);
        return view('admin/report/earning/daily-top-earners', $data);
    }
    public function dailyIncomeByVehicle (Request $request){
        $limit = 20;
        if ($request->limit && $request->limit > 0 && $request->limit < 101) {
            $limit = $request->limit;
        }
        $query = RidingPayment::select(\DB::raw('SUM(riding_payments.total_amount) as total_earning'), 'riding_payments.rider_id')
        ->leftJoin('riding_requests', 'riding_requests.id', 'riding_payments.riding_request_id');
        $query = $query->with('get_rider')
        ->groupBy('riding_payments.rider_id', 'riding_payments.total_amount')
        ->orderBy('total_earning', 'DESC');
        if ($request->start_date  && $request->end_date) {
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $end_date = date('Y-m-d', strtotime($request->end_date));
        }
        if (isset($start_date) && isset($end_date)) {
            $query =  $query->whereBetween('riding_payments.created_at', [$start_date, $end_date]);
        }else {
            $query = $query->where('riding_payments.created_at', date('Y-m-d'));
        }
        $top_earners = $query->paginate($limit);
        // dd($top_earners);
        $data = [
            'top_earners' => $top_earners,
            'page_title' => 'Daily Top Earners'
        ];
        return view('admin/report/daily-income-by-vehicle',$data);
    }
   
}
