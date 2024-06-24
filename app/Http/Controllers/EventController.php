<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\TestingEvent;
use App\Notifications\RealTimeNotification;

class EventController extends Controller
{
    public function testingEvents()
    {
        event(new TestingEvent("aya"));
        return response()->json("success");
    }



    public function testnoti()
    {
        $user=auth()->user();
        $user->notify(new RealTimeNotification("hello"));
        return response()->json("success");
    }
}
