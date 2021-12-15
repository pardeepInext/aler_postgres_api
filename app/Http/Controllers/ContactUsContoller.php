<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Subscriber;
use App\Mail\subscribe;
use App\Mail\ContactUs;
use App\Models\Message;
use App\Mail\ReplyMailer;
use Illuminate\Support\Facades\Mail;

class ContactUsContoller extends Controller
{
    function subscribe(Request $request)
    {

        $validator = Validator::make($request->input(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails())
            return response(['success' => false, 'errors' => $validator->errors()]);

        $subscribe = Subscriber::where([['email', $request->email], ['is_subscribed', 1]])->first();

        if ($subscribe)
            return response(['success' => false, 'errors' => ['email' => "email is already subscribed"]]);

        $email = Subscriber::create($request->only('email'));
        $sent = Mail::to($request->email)->send(new subscribe());

        if ($email && $sent)
            return response(["success" => true, 'newslatter is subscribed!']);
    }


    function contactMessage(Request $request)
    {

        $validator = Validator::make($request->input(), [
            'email' => 'required|email',
            'name' => 'required',
            'message' => 'required'
        ]);

        if ($validator->fails())
            return response(['success' => false, 'errors' => $validator->errors()]);

        $message = Message::create($request->only('email', 'name', 'message'));
        $sent = Mail::to($request->email)->send(new ContactUs($request->only('email', 'name', 'message')));

        if ($message)
            return response(["success" => true, 'message' => 'message sent successfully!']);
    }

    function messageList()
    {
        return Message::paginate(10);
    }

    function sendMessage($id, Request $request)
    {
        $message = Message::find($id);


        $sent = Mail::to($message->email)->send(new ReplyMailer(['name' => $message->name, 'message' => $request->message]));
        $update = $message->update(['is_resolved' => true]);

        return $update ? ['success' => true] : ['success' => false];
    }
}
