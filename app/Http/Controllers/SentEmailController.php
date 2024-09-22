<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SentEmailController extends Controller
{
    private function sentemails($a)
    {

       
    }

    public function sentemail()
    {
        
        $to_name = "no-reply";
        $to_email = "luan.dangminh01@gmail.com"; //send to this email
       
        $data = array("name" => "FULLHDPHIM", "price" => '29.999',"name_package"=>"goi 999",
        "total"=> '39999',"payment"=>"momo","date"=>"69","orderId"=>'20230312');
        Mail::send('pages.sent_email',$data,function($message)use($to_name,$to_email){
            $message->to($to_email)->subject('Hóa Đơn Thanh Toán Gói Phim');
            $message->from($to_email,$to_name);//sent from this email
        });
        dd('thanh cong');
        // return view('pages.sent_email');
    }
}
