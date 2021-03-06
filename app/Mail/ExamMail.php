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

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function build()
    {
        $exam = Exam::where('student_id', $this->id)->orderBy('id', 'desc')->select('title',
         'tuition_fee', 'exam_fee', 'transport_fee',
         'stationery_fee', 'sports_fee', 'club_fee', 'hostel_fee', 'laundry_fee',
         'education_tax', 'eca_fee', 'late_fine', 'extra_fee', 'total_amount')->first();
        $data = [
            // 'name' => $student->name,
        ];
        return $this->from('noreply@vedyalay.com')->subject('Exam Routine Published')->view('mail.feeadd')->with($data);
    }
}
