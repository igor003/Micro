<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::user()->status == 'minolog'){
            return redirect()->route('mini_calibration_list_view');
        }

    // $mailto = "igor.bodean@sammycablaggi.com";
    // $mailSub = "ciao";
    // $mailMsg = "e stato inserito un nuovo benestare ! ";
    
    // $mail = new PHPMailer();
   
    // $mail->IsSmtp();
    // $mail->SMTPDebug = 2;

    // $mail->SMTPAuth = true;
    // $mail->SMTPSecure = 'tls';
    // $mail->Host = "smtps.aruba.it";
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    
    // $mail->Port = 587; 

    // $mail->IsHTML(true);
    // $mail->Username = "igor.bodean@sammycablaggi.com";
    // $mail->Password = "mercedes190";
    // $mail->setFrom("igor.bodean@sammycablaggi.com");
    // $mail->Subject = $mailSub;
    // $mail->Body = $mailMsg;
    // $mail->AddAddress($mailto);
    // $mail->Send();
    

        return view('home');
    }
}
