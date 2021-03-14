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
        $notification = Notification::where('user_id', Auth::user()->id)->pluck('title', 'link');
        $noticeboard =  NoticeBoard::select('id', 'title')->where('publish_status', '1')->latest()->get();
        foreach ($noticeboard as $value) {
            $notification[route('noticeboard.show', @$value->id)] = $value->title;
        }
        $view->with([
            'notification' => $notification,
            'notificaitoncount' => count($notification),
        ]);
    }
}
