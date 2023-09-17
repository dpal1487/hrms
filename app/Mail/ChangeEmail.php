<?php
  
namespace App\Mail;
   
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
  
class ChangeEmail extends Mailable
{
  use Queueable, SerializesModels; 
  public $title; 
  public $user; 
  public function __construct($title, $user) 
  {
  // 
  $this->title = $title; 
  $this->user= $user; 
  }
  public function build() 
  { 
      return $this->subject($this->title) ->view('email.change-email');
  }
}