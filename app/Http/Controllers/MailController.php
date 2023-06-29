<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactUsRequest;
use App\Mail\ContacUsMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function contactUs(ContactUsRequest $request)
    {
        $data = [
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'message'=>$request->input('message'),
            'subject'=>'Solicitare contact aplicatie mobila'
        ];

        Mail::to(config('email.contact_us.to'))->send(new ContacUsMail($data));
    }
}
