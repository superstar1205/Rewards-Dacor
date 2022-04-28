<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function ellogin(){
        return view('ellogin');
    }
    public function fllogin(){
        return view('fllogin');
    }
    public function ehome(Request $request){
        $memberid = $request->input('memberid');
        $password = $request->input('password');
        $uth = DB::select("SELECT * FROM `members` WHERE memberid='".$memberid."' AND password='".$password."'");
        if(sizeof($uth)==1){
            $msg = "start";
            $langef='français';
            $textlng = DB::select("SELECT * FROM `lang` WHERE lang='".$langef."'");
            $invresult = DB::select("SELECT *, COUNT(sale_num)AS tsnum, SUM(spiff) AS tspiff, SUM(sale_price)AS tsale FROM `invoices` WHERE member_id = '".$memberid."' AND in_num IS NOT NULL GROUP BY sale_num");
            $rf = DB::select("SELECT * FROM `invoices` WHERE member_id='".$memberid."' AND in_num IS NULL");
            if(sizeof($rf)>0){
                $maxsn = $rf[0]->sale_num;
            }else{
                $maxsn1 = DB::select("SELECT MAX(sale_num) AS maxsn FROM `invoices`");
                if($maxsn1[0]->maxsn==0){
                    $maxsn='10000000';
                }else{ 
                    $maxsn=((int) $maxsn1[0]->maxsn)+1; 
                }
                DB::insert("INSERT INTO `invoices` (sale_num, member_id) value(?,?)", [$maxsn, $memberid]);
            }
            $totalsp = DB::select("SELECT SUM(spiff) AS tospiff FROM `invoices` WHERE member_id = '".$memberid."' and status='1'");
            $data = [
                'uth' => $uth[0],
                'totalsp' =>$totalsp,
                'invresult' => $invresult,
                'maxsn' => $maxsn,
                'msg' => $msg,
                'lang' => $textlng[0]
            ];
            return view('home')->with($data);
        }else{
            return view('ellogin');
        }
    }


    public function fhome(Request $request){
        $memberid = $request->input('memberid');
        $password = $request->input('password');
        $uth = DB::select("SELECT * FROM `members` WHERE memberid='".$memberid."' AND password='".$password."'");
        if(sizeof($uth)==1){
            $msg = "start";
            $langef='English';
            $textlng = DB::select("SELECT * FROM `lang` WHERE lang='".$langef."'");
            $invresult = DB::select("SELECT *, COUNT(sale_num)AS tsnum, SUM(spiff) AS tspiff, SUM(sale_price)AS tsale FROM `invoices` WHERE member_id = '".$memberid."' AND in_num IS NOT NULL GROUP BY sale_num");
            $rf = DB::select("SELECT * FROM `invoices` WHERE member_id='".$memberid."' AND in_num IS NULL");
            if(sizeof($rf)>0){
                $maxsn = $rf[0]->sale_num;
            }else{
                $maxsn1 = DB::select("SELECT MAX(sale_num) AS maxsn FROM `invoices`");
                if($maxsn1[0]->maxsn==0){
                    $maxsn='10000000';
                }else{ 
                    $maxsn=((int) $maxsn1[0]->maxsn)+1; 
                }
                DB::insert("INSERT INTO `invoices` (sale_num, member_id) value(?,?)", [$maxsn, $memberid]);
            }
            $totalsp = DB::select("SELECT SUM(spiff) AS tospiff FROM `invoices` WHERE member_id = '".$memberid."' and status='1'");
            $data = [
                'uth' => $uth[0],
                'totalsp' =>$totalsp,
                'invresult' => $invresult,
                'maxsn' => $maxsn,
                'msg' => $msg,
                'lang' => $textlng[0]
            ];
            return view('home')->with($data);
        }else{
            return view('fllogin');
        }
    }
    ///////////////////////////////////////////////////
    // Get Product list from Model Number /////////////
    ///////////////////////////////////////////////////
    public function getproduts(Request $request){
        $modelnum = $request->input('modelnum');
        $results = DB::select("SELECT * FROM `product` WHERE sku LIKE '".$modelnum."_%'");
        $data = [
            'results' => $results,
        ];
        return $data;
    }
    ///////////////////////////////////////////////////
    // Get detail Invoice data ////////////////////////
    ///////////////////////////////////////////////////
    public function getdetailinv(Request $request){
        $sale_num=$request->input('sale_num');
        $results = DB::select("SELECT * FROM `invoices` WHERE sale_num ='".$sale_num."'");
        $data = [
            'results' => $results,
        ];
        return $data;
    }
    ///////////////////////////////////////////////////
    // Add Product on the DB //////////////////////////
    ///////////////////////////////////////////////////
    public function addproduct(Request $request){

        $member_id = $request->input('memberid');
        $sale_num = $request->input('sale_num');
        $in_num = $request->input('in_num');
        $in_date = $request->input('in_date');
        $de_date = $request->input('de_date');
        $model_num = $request->input('model');
        $description = $request->input('description');
        $spiff = $request->input('spiff');
        $series = $request->input('series');
        $sale_price = $request->input('sale_price');
        DB::delete("DELETE FROM `invoices` WHERE member_id ='".$member_id."' AND in_num IS NULL");
        DB::insert("INSERT INTO `invoices` (sale_num, member_id, in_num, in_date, de_date, model_num, description, spiff, series, sale_price) value(?,?,?,?,?,?,?,?,?,?)", [$sale_num, $member_id, $in_num, $in_date, $de_date, $model_num, $description, $spiff, $series, $sale_price]);
        $results = DB::select("SELECT * FROM `invoices` WHERE sale_num ='".$sale_num."' AND member_id = '".$member_id."'");
        $data = [
            'results' =>$results
        ];
        return $data;

    }
    ///////////////////////////////////////////////////
    // Send Invoice file //////////////////////////////
    ///////////////////////////////////////////////////
    public function sendinvoice (Request $request){
        $member_id = $request->input('memberuth');
        $sale_num = $request->input('salenum');
        $in_num = $request->input('innum');
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,png|max:5242880',
        ]);
        $fileName = $in_num.'.'.$request->file->extension();  
        $request->file->move(public_path('uploads'), $fileName);
        $filePath = "public/uploads/".$fileName;
        DB::update("UPDATE `invoices` SET file_path =? WHERE sale_num =?", [$filePath, $sale_num]);
        $invresult = DB::select("SELECT *, COUNT(sale_num)AS tsnum, SUM(spiff) AS tspiff, SUM(sale_price)AS tsale FROM `invoices` WHERE member_id = '".$member_id."' AND in_num IS NOT NULL GROUP BY sale_num");
        $uth = DB::select("SELECT * FROM `members` WHERE memberid='".$member_id."'");
        $totalsp = DB::select("SELECT SUM(spiff) AS tospiff FROM `invoices` WHERE member_id = '".$member_id."' and status='1'");
        $maxsn1 = DB::select("SELECT MAX(sale_num) AS maxsn FROM `invoices`");
        $maxsn = ((int) $maxsn1[0]->maxsn)+1;
        DB::insert("INSERT INTO `invoices` (sale_num, member_id) value(?,?)", [$maxsn, $member_id]);
        $lgflag = $request->input('lgflag');
        $textlng = DB::select("SELECT * FROM `lang` WHERE lang='".$lgflag."'");
        if($lgflag =='français' ){
            $lang = $textlng[0];
            $msg="We’ve received your submission. You’re on the way to earning big $!";
        }else{
            $lang = $textlng[0];
            $msg="Nous avons reçu votre soumission. Vous êtes en bonne voie de gagnez beaucoup d’argent !";
        }
        $data = [
            'uth' => $uth[0],
            'totalsp' =>$totalsp,
            'invresult' => $invresult,
            'maxsn' => $maxsn,
            'msg' => $msg,
            'lang' =>$lang
        ];
        return view('home')->with($data);
    }
    ///////////////////////////////////////////////////
    // Send email function ////////////////////////////
    ///////////////////////////////////////////////////
    public function sendtemail (Request $request) {
        $memberid = $request->input('muth');
        $cemail = $request->input('cemail');
        $ctitle = $request->input('ctitle');
        $ctext = $request->input('ctext');
        $to="James@gristmill.ca";
        $headers="From: ".$cemail. "\r\n"."CC: somebodyelse@example.com";
        mail($to, $ctitle, $ctext, $headers);
        $msg="Mail send success!";
        $invresult = DB::select("SELECT *, COUNT(sale_num)AS tsnum, SUM(spiff) AS tspiff, SUM(sale_price)AS tsale FROM `invoices` WHERE member_id = '".$memberid."' AND in_num IS NOT NULL GROUP BY sale_num");
        $uth = DB::select("SELECT * FROM `members` WHERE memberid='".$memberid."'");
        $maxsn1 = DB::select("SELECT MAX(sale_num) AS maxsn FROM `invoices` WHERE member_id='".$memberid."'");
        $maxsn = (int) $maxsn1[0]->maxsn;
        $totalsp = DB::select("SELECT SUM(spiff) AS tospiff FROM `invoices` WHERE member_id = '".$memberid."' and status='1'");
        $lgflag = $request->input('lgflag');
        $textlng = DB::select("SELECT * FROM `lang` WHERE lang='".$lgflag."'");
        if($lgflag =='français' ){
            $lang = $textlng[0];
        }else{
            $lang = $textlng[0];
        }
        $data = [
            'uth' => $uth[0],
            'totalsp' =>$totalsp,
            'invresult' => $invresult,
            'maxsn' => $maxsn,
            'msg' => $msg,
            'lang' =>$lang
        ];
        return view('home')->with($data);
    }
    ///////////////////////////////////////////////////
    // Language change funcion ////////////////////////
    ///////////////////////////////////////////////////
    public function changelang(Request $request){
        $memberid = $request->input('memberid');
        $lgflag = $request->input('lgflag');
        $msg = "start";
        if($lgflag=='français'){$langf='English';}else{$langf='français';}
        $textlng = DB::select("SELECT * FROM `lang` WHERE lang='".$langf."'");
        $uth = DB::select("SELECT * FROM `members` WHERE memberid='".$memberid."'");
        $invresult = DB::select("SELECT *, COUNT(sale_num)AS tsnum, SUM(spiff) AS tspiff, SUM(sale_price)AS tsale FROM `invoices` WHERE member_id = '".$memberid."' AND in_num IS NOT NULL GROUP BY sale_num");
        $maxsn = DB::select("SELECT MAX(sale_num) AS maxsn FROM `invoices` WHERE member_id='".$memberid."'");
        $totalsp = DB::select("SELECT SUM(spiff) AS tospiff FROM `invoices` WHERE member_id = '".$memberid."' and status='1'");
        $data = [
            'uth' => $uth[0],
            'totalsp' =>$totalsp,
            'invresult' => $invresult,
            'maxsn' => $maxsn[0]->maxsn,
            'msg' => $msg,
            'lang' => $textlng[0]
        ];
        return view('home')->with($data);
    }

}
