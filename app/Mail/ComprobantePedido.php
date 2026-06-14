<?php

namespace App\Mail;

use App\Models\{Order, Factura};
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\{Content, Envelope};
use Illuminate\Queue\SerializesModels;

class ComprobantePedido extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order   $order,
        public Factura $factura,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Comprobante de tu pedido #'.str_pad($this->order->id, 5, '0', STR_PAD_LEFT).' — Fuerza Urbana',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.comprobante',
        );
    }
}
