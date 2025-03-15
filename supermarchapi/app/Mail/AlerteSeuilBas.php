<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AlerteSeuilBas extends Mailable
{
    use Queueable, SerializesModels;

    public $produit;

    public function __construct(Produit $produit)
    {
        $this->produit = $produit;
    }

    public function build()
    {
        return $this->subject('Alerte : Stock Critique')
                    ->view('emails.alerte_seuil_bas'); // Create this view for the email content
    }
}
