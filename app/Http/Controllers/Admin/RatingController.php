<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Compliment;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct(Rating $rating)
    {
        $this->middleware(['permission:rating-list|rating-create|rating-edit|rating-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:rating-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:rating-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:rating-delete'], ['only' => ['destroy']]);
        $this->rating = $rating;
    }
    protected function getRating($request)
    {
        $query = $this->rating->orderBy('id','DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $user = User::where('name', $keyword)->pluck('id');
            $query = $query->whereIn('customer_id', $user)->orWhereIn('rider_id', $user)->orWhereIn('rating_by', $user);
        }
        if ($request->mobile) {
            $mobile = $request->mobile;
            $user = User::where('mobile', $mobile)->pluck('id');
            $query = $query->whereIn('customer_id', $user)->orWhereIn('rider_id', $user)->orWhereIn('rating_by', $user);
        }
        if ($request->rating) {
            $rating = $request->rating;
            $query = $query->where('rating', $rating);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getRating($request);
        $compliment = Compliment::pluck('title', 'id');
        $data = [
            'data' => $data,
            'compliment' => $compliment,
        ];
        return view('admin/rating/list')->with($data);
    }
    public function unpublish($id)
    {
        $data = $this->rating
            ->where('id', $id)->update(['status'=>'0']);
        return redirect()->back();
    }
    public function publish($id)
    {
        $data = $this->rating
            ->where('id', $id)->update(['status'=>'1']);
        return redirect()->back();
    }
}
