<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
class MainController extends Controller
{
     public function getIndex() {
                return view('pages.welcome');
            }
    // public function getAbout() {
    //             return view('pages.welcome');
    //         }
    // public function getGoals() {
    //             return view('pages.welcome');
    //         }
    // public function getPortfolio() {
    //             return view('pages.welcome');
    //         }
     
    public function contact(Request $request)
   {
       $this->validate($request, [
           'firstname'=>'required',
             'lname'=>'required',
           'email'=>'required',
           'mobile'=>'required',
           'message'=>'required'
            ]);
       $fname=$request->firstname;
       $lname=$request->lname;
       $email=trim($request->email);
       $mobile=$request->mobile;
       $msg=$request->message;
       $hostname=\config('config.mail');
       $this->sendEmailQ($hostname,$msg,$email, $fname, $lname, $mobile);
       return redirect()->back()->with('Success','Thank you for your response. ');
   }
    
    private function sendEmailQ($hostname,$msg,$email, $fname, $lname,$mobile){
       Mail::send('email.contact',[
           'email'=>$email,
           'fname'=>$fname,
            'lname'=>$lname,
           'mobile'=>$mobile,
           'msg'=>$msg,
           'hostname'=>$hostname
           ], function($message) use ($hostname){
               $customer="a1abilities@gmail.com";
               $customern='Srinivas Ankam';
            $message->from($customer, $customern);
            $message->replyTo($customer, $customern);
               $message->to($customer,$customern)->subject("There is response from your website");
           });
   }         
}
