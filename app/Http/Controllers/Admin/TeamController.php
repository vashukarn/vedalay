<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function __construct(Team $team)
    {
        $this->middleware(['permission:team-list|team-create|team-edit|team-delete'], ['only' => ['index', 'store']]);
        $this->middleware(['permission:team-create'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:team-edit'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:team-delete'], ['only' => ['destroy']]);
        $this->team = $team;
    }
    protected function getTeam($request)
    {
        $query = $this->team->orderBy('id', 'DESC');
        if ($request->keyword) {
            $keyword = $request->keyword;
            $query = $query->where('title', $keyword);
        }
        return $query->paginate(20);
    }
    public function index(Request $request)
    {
        $data = $this->getTeam($request);
        $data = [
            'data' => $data,
        ];
        return view('admin/team/list')->with($data);
    }

    public function create()
    {
        $team_info = null;
        $title = 'Add Team';
        $data = [
            'title' => $title,
            'team_info' => $team_info,
        ];
        return view('admin/team/form')->with($data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
            'designation' => 'required|string|min:3|max:190',
            'email' => 'required|email|min:3',
            'publish_status' => 'required|in:1,0',
        ]);
        DB::beginTransaction();
        try {
            Team::create([
                'name' => htmlentities($request->name),
                'email' => htmlentities($request->email),
                'designation' => htmlentities($request->designation),
                'title' => htmlentities($request->title),
                'description' => htmlentities($request->description),
                'image' => htmlentities($request->image),
                'website_link' => htmlentities($request->website_link),
                'github_link' => htmlentities($request->github_link),
                'facebook_link' => htmlentities($request->facebook_link),
                'instagram_link' => htmlentities($request->instagram_link),
                'linkedin_link' => htmlentities($request->linkedin_link),
                'publish_status' => htmlentities($request->publish_status),
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            $request->session()->flash('success', 'Team added successfully.');
            return redirect()->route('team.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $team_info = $this->team->find($id);
        if (!$team_info) {
            abort(404);
        }
        $title = 'Edit Team';
        $data = [
            'title' => $title,
            'team_info' => $team_info,
        ];
        return view('admin/team/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $team_info = $this->team->find($id);
        if (!$team_info) {
            abort(404);
        }
        $this->validate($request, [
            'name' => 'required|string|min:3|max:190',
            'designation' => 'required|string|min:3|max:190',
            'email' => 'required|email|min:3',
            'publish_status' => 'required|in:1,0',
        ]);
        DB::beginTransaction();
        $data = [
            'name' => htmlentities($request->name),
            'email' => htmlentities($request->email),
            'designation' => htmlentities($request->designation),
            'title' => htmlentities($request->title),
            'description' => htmlentities($request->description),
            'website_link' => htmlentities($request->website_link),
            'github_link' => htmlentities($request->github_link),
            'facebook_link' => htmlentities($request->facebook_link),
            'instagram_link' => htmlentities($request->instagram_link),
            'linkedin_link' => htmlentities($request->linkedin_link),
            'publish_status' => htmlentities($request->publish_status),
            'updated_by' => Auth::user()->id,
        ];
        if($request->image){
            $data['image'] = $request->image;
        }
        try {
            $team_info->fill($data)->save();
            DB::commit();
            $request->session()->flash('success', 'Team updated successfully.');
            return redirect()->route('team.index');
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
            return redirect()->back();
        }

    }

    public function destroy(Request $request, $id)
    {
        $team_info = $this->team->find($id);
        if (!$team_info) {
            abort(404);
        }
        DB::beginTransaction();
        try {
            $team_info->delete();
            $request->session()->flash('success', 'Team removed successfully.');
            DB::commit();
        } catch (\Exception $error) {
            DB::rollBack();
            $request->session()->flash('error', $error->getMessage());
        }
        return redirect()->back();
    }
}
