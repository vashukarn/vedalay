<?php

namespace App\Http\View\Composers;

use App\Models\Exam;
use App\Models\NoticeBoard;
use App\Models\Notification;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationComposer
{
    public function compose(View $view)
    {
        $notification = [];
        $type = Auth::user()->type;
        $noticeboard =  NoticeBoard::select('id', 'title')->where('publish_status', '1')->latest()->get();
        foreach ($noticeboard as $value) {
            $notification[route('noticeboard.show', @$value->id)] = $value->title;
        }

        if ($type == 'student') {
            $temp = Student::where('user_id', Auth::user()->id)->first();
            if (isset($temp)) {
                $examtemp = Exam::where('publish_status', '1')->where('level_id', $temp->level_id)->get();
                foreach ($examtemp as $value) {
                    $notification[route('exam.show', @$value->id)] = $value->title.' Published';
                }
            }
        }
        $view->with([
            'notification' => $notification,
            'notificaitoncount' => count($notification),
        ]);
    }
}
