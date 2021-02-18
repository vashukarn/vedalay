<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Utilities\LogActivity;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menu;
    public function __construct(Menu $menu)
    {
        $this->get_web();
        $this->middleware(['permission:menu-list|menu-create|menu-edit|menu-delete'], ['only' => ['index','store']]);
        $this->middleware(['permission:menu-create'], ['only' => ['create','store']]);
        $this->middleware(['permission:menu-edit'], ['only' => ['edit','update']]);
        $this->middleware(['permission:menu-delete'], ['only' => ['destroy']]);
        $this->menu=$menu;
    }

    public function index()
    {
        $this->menu=$this->menu->with('child_menu')->orderby('position','asc')->get();
        return view('admin.menu.menu-list')->with('data',$this->menu);
    }

    public function create()
    {
        $data = [
            'title' => 'Edit Menu',
        ];
        return view('admin.menu.menu-form')->with($data);
    }

    public function additional_menu($id)
    {
        $menu=$this->menu->find($id);
        if(!$menu){
            return redirect()->route('menu.index')->with('error','Error ! Menu Not Found');
        }
        // dd('sdfjsdflsdjf');
        $menu->featured_img_thumb_url = getFullImage($menu->featured_img, $menu->featured_img_path);
        $menu->featured_img_url = getFullImage($menu->featured_img, $menu->featured_img_path);
        $menu->parallex_img_thumb_url = getFullImage($menu->parallex_img, $menu->parallex_img_path);
        $menu->parallex_img_url = getFullImage($menu->parallex_img, $menu->parallex_img_path);
        // dd($menu);
        $data = [
            'data' => $menu,
            'title' => 'Edit Additional Data for Menu',
        ];
        return view('admin.menu.additional-menu')->with($data);
    }
    protected function mapMenuTitles($request, $menuInfo = null){
        $data = [
            'title' => [
                'en' => $request->en_title ?? @$menuInfo->title['np'] ?? $request->np_title,
                'np' => $request->np_title ?? @$menuInfo->title['np'] ?? $request->en_title,
            ],
            "slug" => $request->slug,
            "publish_status" => $request->publish_status,
            'external_url' => $request->external_url ?? null,
            "description" => [
                'np' => htmlentities($request->np_description) ??    htmlentities($request->en_description),
                'en' => htmlentities($request->en_description) ??   htmlentities($request->np_description),
            ],
            "short_description" => [
                'en' => htmlentities($request->en_short_description) ??   htmlentities($request->np_short_description),
                'np' => htmlentities($request->np_short_description) ??   htmlentities($request->en_short_description),
            ],
            "meta_title" => htmlentities($request->meta_title) ?? null,
            "meta_description" => htmlentities($request->meta_description) ?? null,
            "meta_keyword" => htmlentities($request->meta_keyword) ?? null,
            "meta_keyphrase" => htmlentities($request->meta_keyphrase) ?? null,
            "meta_keyphrase" => htmlentities($request->meta_keyphrase) ?? null,
            "external_url" => $request->external_url ?? null,
        ];
        // dd($data);


        if(!$menuInfo){
            $data['created_by'] = $request->user()->id;
        }
        // dd($request->all());
        if ($request->featured_img && !empty($request->featured_img)) {
            $image = getImageFromUrl($request->featured_img);
            $data['featured_img'] = $image['image'];
            $data['featured_img_path'] = $image['path'];
        }
        if ($request->parallex_img && !empty($request->parallex_img)) {
            $image = getImageFromUrl($request->parallex_img);
            $data['parallex_img'] = $image['image'];
            $data['parallex_img_path'] = $image['path'];
        }
        return $data;
    }

    public function store(Request $request)
    {
        // dd($request->all());
        \DB::beginTransaction();
        try {
            $data = $this->mapMenuTitles($request) ;
            // dd($data);
           $status =  $this->menu->fill($data)->save();
           
            LogActivity::addToLog('New Menu Added');
            \DB::commit();
            if(!$status){
                $request->session()->flash('error',"Sorry! Error While Creating Menu");
            }
            $request->session()->flash('success', 'Menu Created Successfully');
         }catch (\Exception $e) {
            \DB::rollback();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('menu.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $this->menu=$this->menu->find($id);
        if(!$this->menu){
            return redirect()->route('menu.index')->with('error','Error ! Menu Not Found');
        }
        $data = [
            'data' => $this->menu,
            'title' => 'Edit Menu',
        ];
        // dd($data);
        return view('admin.menu.menu-form')->with($data);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->validate($request,  $this->validate_form());
        $this->menu=$this->menu->find($id);
        if(!$this->menu){
            return redirect()->route('menu.index')->with('error','Error ! Menu Not Found');
        }
        \DB::beginTransaction();
        try {
            $data = $this->mapMenuTitles($request) ;
            $status = $this->menu->fill($data)->save();
            LogActivity::addToLog('Menu Edited');
            \DB::commit();
            if (!$status) {
                $request->session()->flash('error', 'Sorry! Error While Updating Menu');
            }
            $request->session()->flash('success', 'Menu Updated Successfully');
        }catch (\Exception $e) {
            \DB::rollback();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('menu.index');
    }

    public function destroy($id)
    {
        $this->menu=$this->menu->find($id);
        if(!$this->menu){
            return redirect()->route('menu.index')->with('error','Error ! Menu Not Found');
        }
        \DB::beginTransaction();
        try {
            if ($this->menu->parent_id == null) {
                $menus = Menu::where('parent_id', $id)->get();
                if ($menus->count() > 0) {
                    foreach ($menus as $child) {
                        Menu::where('id', $child->id)->update(['parent_id' => null]);
                    }
                }
                $status = $this->menu->delete();
            } else {
                $menus = Menu::where('parent_id', $id)->get();
                foreach ($menus as $child) {
                    Menu::where('id', $child->id)->update(['parent_id' => null]);
                    $this->update_child($child->id);
                }
                $status = $this->menu->delete();
            }
            LogActivity::addToLog('Menu Deleted');
            \DB::commit();
            if (!$status) {
                request()->session()->flash('error', 'Sorry! Error While Deleting Menu');
            }
            request()->session()->flash('success', 'Menu Updated Successfully');
        }catch (\Exception $e) {
            \DB::rollback();
            return back()->withError($e->getMessage())->withInput();
        }
        return redirect()->route('menu.index');
    }

    public function updateMenuOrder(Request $request)
    {
        parse_str($request->sort, $arr);
        $order = 1;
        if(isset($arr['menuItem'])) {
            foreach ($arr['menuItem'] as $key => $value) {  //id //parent_id
                $this->menu->where('id', $key)
                ->update(['position' => $order,'parent_id'=>($value=='null')? NULL: $value]);
                $order++;
            }
        }
        LogActivity::addToLog('Menu order Updated');
        return true;
    }

    private function getSlug($title){
        $slug= \Str::slug($title);
        if($this->menu->where('slug',$slug)->count()>0){
            $slug.=date('Ymdhis');
        }
        return $slug;
    }

    private function update_child($id){
        $menus=Menu::where('parent_id',$id)->get();
        if ($menus->count() > 1) {
            foreach ($menus as $child) {
                Menu::where('id', $child->id)->update(['parent_id' => $child->id]);
                $this->update_child($child->id);
            }
        }
    }
}
