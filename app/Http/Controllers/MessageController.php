<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Events\SendMessage;

class MessageController extends Controller
{
    public function index($id){       
        $this->setRead($id);   

        $messages = Message::where( function($q) use ($id){
            $q->where('from_id', auth()->id());
            $q->where('to_id', $id);
        })->orWhere(function($q) use ($id){
            $q->where('from_id', $id);
            $q->where('to_id', auth()->id());
        })->get();

        return response()->json($messages);
    }

    public function send(Request $request){
        $message = Message::create([
            'from_id' => auth()->id(),
            'to_id' => $request->to,
            'message' => $request->message
        ]);

        broadcast(new SendMessage($message));

        return response()->json($message);
    }

    public function read($id){
        $this->setRead($id);   
    }

    private function setRead($id){
        Message::where('from_id', $id)->where('to_id', auth()->id())->update(['read' => true]);
    }
}
