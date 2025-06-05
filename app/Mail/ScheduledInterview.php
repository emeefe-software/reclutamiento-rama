<?php

namespace App\Mail;

use App\Career;
use App\Interview;
use App\Program;
use App\University;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScheduledInterview extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $career;
    public $program;
    public $university;
    public $interview;
    public $linkToInterviewView;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $candidate, Career $career, Program $program, Interview $interview, String $linkToInterviewView)
    {
        $this->candidate = $candidate;
        $this->career = $career;
        $this->program = $program;
        $this->university = $program->university;
        $this->interview = $interview;
        $this->linkToInterviewView = $linkToInterviewView;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datetimeCarbon = Carbon::parse($this->interview->hour()->first()->datetime);
        return $this->from('checador@emeefe.mx')
                    ->subject('Nueva entrevista '.$datetimeCarbon->toFormattedDateString().' con '. $this->candidate->fullname())
                    ->view('emails.scheduled_interview');
    }
}
