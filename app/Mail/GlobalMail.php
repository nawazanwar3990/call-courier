<?php

namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GlobalMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $type;
    public string $heading;
    public mixed $model;

    public function __construct(
        $type,
        $heading,
        $model
    )
    {
        $this->type = $type;
        $this->heading = $heading;
        $this->model = $model;
    }

    public function build(): GlobalMail
    {
        $params = [
            'type' => $this->type,
            'heading' => $this->heading,
            'model' => $this->model
        ];
        return $this->subject($this->heading)
            ->view('mail.index', compact('params'));
    }
}
