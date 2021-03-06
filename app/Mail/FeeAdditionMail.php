<?php

namespace App\Mail;

use App\Models\Fee;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FeeAdditionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function build()
    {
        $fee = Fee::where('student_id', $this->id)->orderBy('id', 'desc')->select('title',
         'tuition_fee', 'exam_fee', 'transport_fee',
         'stationery_fee', 'sports_fee', 'club_fee', 'hostel_fee', 'laundry_fee',
         'education_tax', 'eca_fee', 'late_fine', 'extra_fee', 'total_amount')->first();
        $student = User::find($this->id);
        $subjects = Subject::pluck('title', 'id');
        $data = [
            'name' => $student->name,
            'fee_info' => $fee,
            'subjects' => $subjects,
        ];
        return $this->from('noreply@vedyalay.com')->subject('Fee Addition Notification')->view('mail.feeadd')->with($data);
    }
}
