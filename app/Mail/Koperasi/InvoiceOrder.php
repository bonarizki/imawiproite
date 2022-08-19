<?php

namespace App\Mail\Koperasi;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceOrder extends Mailable
{
    use Queueable, SerializesModels;

    private $user,$detailOrder,$order_header_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$detailOrder,$order_header_id)
    {
        $this->user = $user;
        $this->detailOrder = $detailOrder;
        $this->order_header_id = $order_header_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $detailOrder = $this->detailOrder;
        $order_header_id = $this->order_header_id;
        return $this->view('koperasi/mail/order',compact('detailOrder','user','order_header_id'));
    }
}
