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
$accountSid = '';
$authToken = '';
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
