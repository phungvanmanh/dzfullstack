<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailDangKyKhoaHoc extends Mailable
{
    use Queueable, SerializesModels;

    protected $dataMail;

    public function __construct($dataMail)
    {
        $this->dataMail = $dataMail;
    }

    public function build()
    {
        return $this->subject('Xác nhận đăng ký thành công!')
                    ->view('mail.dangkykh', [
                        'dataMail'  =>  $this->dataMail
                    ]);
    }
}
