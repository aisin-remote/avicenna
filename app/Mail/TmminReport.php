<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Avicenna\MailTmmin;

class TmminReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $tmmin;
    public function __construct($tmmin)
    {
        $this->tmmin = $tmmin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->from('aisinbisa@aiia.co.id')
                    ->view('tracebility.email.index')
                    ->attach('/storage/template/print_part_tmiin.csv');
    }
}
