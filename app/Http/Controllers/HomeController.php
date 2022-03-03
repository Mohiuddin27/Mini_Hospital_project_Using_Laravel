<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirect(){
        if(Auth::id()){
            if(Auth::user()->usertype == '0'){
                $data=Doctor::all();
                return view('user.home',compact('data'));
            }else{
                return view('admin.home');
            }
        }else{
            return back();
        }
    }
    public function index(){
        if(Auth::id()){
            return redirect('home');
        }
        else{
        $data=Doctor::all();
        return view("user.home",compact('data'));
        }
    }
    public function uploadappointment(Request $req){
       
       $data=new Appointment;
       $data->name=$req->name;
       $data->email=$req->email;
       $data->phone=$req->phone;
       $data->date=$req->date;
       $data->message=$req->message;
       $data->doctor=$req->doctor;
       $data->status='In Progress';
       if(Auth::id()){
           $data->user_id=Auth::user()->id;
       }
       $data->save();
       return back();

    }
    public function showappoint(){
        if(Auth::id()){
            $user_id=Auth::User()->id;
            $appoint=Appointment::where('user_id',$user_id)->get();
            return view('user.myappointment',compact('appoint'));
        }
        else{
            return back();
        }
    }
    public function cancelappoint($id){
        $data=Appointment::find($id)->delete();
        return redirect()->back();
    }
  
}
