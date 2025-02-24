<?php
// app/Mail/EmployeeRegistrationEmail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeRegistrationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $password;
    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password, $email)
    {
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('your_email@example.com')
                        ->subject('Employee Registration')
                        ->html('
                            <h1>Employee Registration</h1>
                            <p>Your account has been created successfully.</p>
                            <p>Your login credentials are:</p>
                            <p>Email: ' . $this->email . '</p>
                            <p>Password: ' . $this->password . '</p>
                            <p>Please login to the system using these credentials.</p>
                        ');
    }

}
?>
