<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackMail;


class FeedbackController extends Controller
{

    public function __construct()
    {
        //
    }

    public function send() {
        $comment = 'Это сообщение отправлено из формы обратной связи';
        $toEmail = "troinfo@yandex.ru";
        Mail::to($toEmail)->send(new FeedbackMail($comment));
        return 'Сообщение отправлено на адрес '. $toEmail;
    }
}
