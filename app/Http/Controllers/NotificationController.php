<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\DangerEvent;


class NotificationController extends Controller
{
    public function notify(Request $request)
    {
        // Send a danger notification to the clients
        $message = $request->message;
        event(new DangerEvent($message));

        return response()->json(['result' => 'Notification was sent.']);
    }
}
