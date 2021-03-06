<?php

namespace App\Mail;

use App\Models\Exam;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExamMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        $data = [
            'title' => $this->details['title'],
            'level' => $this->details['level_id'],
            'exam_routine' => $this->details['exam_routine'],
        ];
        // dd($data);
        return $this->from('noreply@vedyalay.com')->subject('Exam Routine Published')->view('mail.exampublish')->with($data);
    }
}
