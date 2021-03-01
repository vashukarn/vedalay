<?php

namespace App\Http\Controllers;

use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsLetterController extends Controller
{
    public function __construct(NewsLetter $newsletter)
    {
        $this->middleware(['permission:newsletter-list|newsletter-view|newsletter-edit'], ['only' => ['index']]);
        $this->newsletter = $newsletter;
    }

    protected function getQuery($request)
    {
        $query = $this->newsletter->orderBy('id','DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title',$keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getQuery($request);
        return view('admin/newsletter/list',compact('data'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|min:3|max:190',
        ]);
        DB::beginTransaction();
        try {
            NewsLetter::create([
                'email' => htmlentities($request->email),
            ]);
            DB::commit();
            $request->session()->flash('success', 'Subscribed successfully.');
            return redirect()->back();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }
    
    public function destroy(Request $request, $id)
    {
        $newsletter_info = $this->newsletter->find($id);
        if (!$newsletter_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $newsletter_info->delete();
            $request->session()->flash('success', 'Newsletter Subscription removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}
