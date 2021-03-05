<?php
namespace App\Http\View\Composers;

use App\Models\NoticeBoard;
use App\Models\Notification;
use Illuminate\View\View;
class NotificationComposer
{
    public function compose(View $view)
    {
        $notification = [];
        $noticeboard =  NoticeBoard::select('id', 'title')->where('publish_status', '1')->latest()->get();

        foreach ($noticeboard as $key => $value) {
            $notification[] = $value->title;
        }
        $view->with([
            'notification' => $notification,
            'notificaitoncount' => count($notification),
        ]);
    }
}