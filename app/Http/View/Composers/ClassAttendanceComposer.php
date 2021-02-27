<?php
namespace App\Http\View\Composers;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ClassAttendanceComposer
{
    public function compose(View $view)
    {
        $teacher_subject = null;
        if(Auth::user()->type == 'teacher'){
            $teacher = Teacher::where('user_id', Auth::user()->id)->first();
            $subject = Subject::whereIn('id',$teacher->subject)->get();
            foreach ($subject as $key => $value) {
                $teacher_subject[$value->id] = $value->title.' - '.$value->get_level->standard.' '.$value->get_level->section;
            }
        }
        $view->with([
            'subjects' => $teacher_subject,
        ]);
    }
}
