<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    //

    public function login(Request $request){
        $memberid = $request->input('memberid');
        $password = $request->input('password');
        $result = DB::select("SELECT * FROM `members` WHERE memberid='".$memberid."' AND password='".$password."'");
        if(sizeof($result)==1){
            $msg = "start";
            $invresult = DB::select("SELECT *, COUNT(sale_num)AS tsnum, SUM(spiff) AS tspiff, SUM(sale_price)AS tsale FROM `invoices` WHERE member_id = '".$memberid."' GROUP BY sale_num");
            $maxsn = DB::select("SELECT MAX(sale_num) AS maxsn FROM `invoices`");
            $totalsp = DB::select("SELECT SUM(spiff) AS tospiff FROM `invoices` WHERE member_id = '".$memberid."' and status='1'");
            $data = [
                'totalsp' =>$totalsp,
                'invresult' => $invresult,
                'maxsn' => $maxsn,
                'msg' => $msg
            ];
            return view('home')->with($data);
        }else{
            return False;
        }
    }
}
