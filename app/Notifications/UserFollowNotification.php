<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

class UserFollowNotification extends Notification
{
     public $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['mail'];  // if data sent through email
        return ['database']; // if data sent through database

    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->user['id'],
            'first_name' => $this->user['first_name'],
            'last_name' => $this->user['last_name'],
            'email' => $this->user['email'],
            'mobile' => $this->user['mobile'],
        ];
    }
}
