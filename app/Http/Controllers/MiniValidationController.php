<?php

namespace App\Http\Controllers;
use App\Miniaplicator;
use App\MiniValidation;
use Illuminate\Http\Request;
use App\Connector;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
class MiniValidationController extends Controller
{
	public function add_validation_view(){
		$minis = Miniaplicator::all();

		return view('add_validation',['minis'=>$minis]);
	}

	public function add_validation (Request $request){
		$validation = new MiniValidation;
        $validation->id_mini = $request->minaplicator_id;
        $validation->type_validation = $request->type_valid;
        $validation->status = $request->status;
        $validation->date = $request->date;
        $validation->save();
  	$miniaplicator = Miniaplicator::where('id','=',$request->minaplicator_id)->with('connector')->get();
    
    $mailto = "igor.bodean@sammycablaggi.com";
    $mailSub = "Validarea mini:".$miniaplicator['0']->name."";
   
    $mailMsg = "Buna ziua!<br> A fost efectuata schimbarea Kit!!<br> Data: ". $request->date.
               "<br>Miniaplicator: ".$miniaplicator['0']->name.
               "<br>Terminal: ".$miniaplicator['0']->connector->name.
               "<br>Tipul interventiei: ".$request->type_valid."";
    
    $mail = new PHPMailer();
   
    $mail->IsSmtp();
    $mail->SMTPDebug = 2;

    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = env('MAIL_HOST_2');
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    
    $mail->Port = 587; 

    $mail->IsHTML(true);
    $mail->Username = "igor.bodean@sammycablaggi.com";
    $mail->Password = env('MAIL_PASSWORD');
    $mail->setFrom("igor.bodean@sammycablaggi.com");
    $mail->Subject = $mailSub;
    $mail->Body = $mailMsg;
    $mail->AddAddress($mailto);
    $mail->Send();

		return redirect('mini/validations');
	}

	public function validation_list_view(){
	
		return view('validation_list');
	}

	public function validation_list_done_view(){
		$minis = Miniaplicator::all();

		return view('validation_list_done',['minis'=>$minis]);
	}

	public function validations_list(){
		$validatinos = MiniValidation::where('status','=','during')->with('minis.connector')->orderBy('date', 'desc')->get();
		
		return $validatinos;
	}

	public function validations_done_list(Request $request){
		$validations = MiniValidation::select('*');
		
        if($request->date != ''){
            $validations->date($request->date);
        }
        if($request->mini != ''){
        	$validations->mini($request->mini);
        }
        if($request->type != ''){
        	$validations->type($request->type);
        }
       	$validatinos =  $validations->where('status','=','done')->with('minis.connector')->orderBy('date', 'desc')->get();
		return $validatinos;
	}

	public function upload_validation_view($id){

		$cur_validation = MiniValidation::where('id',$id)->with('minis.connector')->get();
		return view('upload_validation',['cur_validation'=>$cur_validation]);
	}


	public function upload_validation(Request $request){
		$filename = $request->file('validation')->getClientOriginalName();
        $path = $request->file('validation')->storeAs('validations\\'.$request->mini_name.'\\'.$request->valid_type.'\\'.$request->valid_date, $filename);
        
        $file_name = "storage/validations/".basename($filename);

        MiniValidation::where('id',$request->valid_id)->update(['path'=>$path,'status'=>'done']);
        $storagePath  = Storage::disk('validations')->getDriver()->getAdapter()->getPathPrefix();
   
       
        $mailSub = "Validarea mini:".$request->mini_name."";
       
        $mailMsg = "Buna ziua!<br> A fost efectuata validarea ".$request->valid_type." miniaplicatorului: ".$request->mini_name."!!<br>Bodean Igor<br>Qualita";
                   
       
        $mail = new PHPMailer();
       
        $mail->IsSmtp();
        $mail->SMTPDebug = 2;

        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = env('MAIL_HOST_2');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        
        $mail->Port = 587; 

        $mail->IsHTML(true);
        $mail->Username = "igor.bodean@sammycablaggi.com";
        $mail->Password = env('MAIL_PASSWORD');
        $mail->setFrom("igor.bodean@sammycablaggi.com");
        $mail->Subject = $mailSub;
        $mail->Body = $mailMsg;
        $mail->addAttachment($storagePath.substr($path,12));
        $mail->AddAddress("sergiu.massoreti@sammycablaggi.com");
        $mail->AddAddress("marcel.manoli@sammycablaggi.com");
        $mail->AddAddress("igor.bodean@sammycablaggi.com");
        $mail->Send();



        return redirect(route('valid_list_view'));
	}

	public function download_validation(Request $request){
	    
	    $storagePath  = Storage::disk('validations')->getDriver()->getAdapter()->getPathPrefix();
        $headers = [
            'Content-Type' => 'application.pdf',
            'Content-dispozition' => 'attachment; filename=result',
        ];
		
        return response()->download($storagePath.substr($request->path,12), basename($request->path), $headers);
	}
}
