<?php

namespace App\Jobs;

use App\Mail\FeeAdditionMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendFeeAdditionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    public function __construct($id)
    {
        $this->id = $id;
    }

    public function handle()
    {
        $student = User::find($this->id);
        Mail::to($student->email)->send(new FeeAdditionMail($this->id));
    }
}
