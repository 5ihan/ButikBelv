<?php
// app/Http/Controllers/WhatsAppController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;

class WhatsAppController extends Controller
{
public function sendWhatsAppMessage(Request $request)
{
// Your Twilio account credentials
$accountSid = 'ACf5832f6d2e9077f25f8f135949354b64';
$authToken = '56e50e4966bb2f2e91ebd743ec38b386';
$twilioNumber = '+16184765707';

// Create a new Twilio client
$client = new Client($accountSid, $authToken);

// Get the recipient's number from the request
$recipientNumber = $request->input('recipient_number');
        $name = $request->input('name');
        $phone = $request->input('phone');
        $order = $request->input('order');
        $messageBody = $request->input('message');

        $message = $client->messages
            ->create(
                "whatsapp:+6285717682902", // to
                array(
                    "from" => "whatsapp:+14155238886",
                    "body" => "Nama: $name\nPhone: $phone\nKode Order $order \nPesan: $messageBody",
                    )
            );
        // Return a script that will display a pop-up message
        return '<script>alert("WhatsApp message sent successfully!"); window.location.href = "/contact";</script>';
    }
}
