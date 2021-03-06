<?php

namespace App\Jobs;

use App\Mail\ExamMail;
use App\Models\Level;
use App\Models\Session;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendExamPublishJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    public function __construct($details)
    {
        $this->details = $details;
    }

    public function handle()
    {
        $student = User::find($this->details['id']);
        $level = Level::find($this->details['level_id']);
        $this->details['level_id'] = $level->standard.' - '.$level->section;
        Mail::to($student->email)->send(new ExamMail($this->details));
    }
}
