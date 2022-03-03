<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Notification;
use App\Notifications\MyFirstNotification;
class AdminController extends Controller
{
    public function addview(){
        return view('admin.add_doctor');
    }
    public function upload(Request $req){
        $image =$req->image;
        $imagename =time (). '.' .$image->getClientOriginalExtension();
        $req->image->move('photo',$imagename);
       Doctor::create([
           'name'=>$req->name,
           'phone'=>$req->phone,
           'speciality'=>$req->speciality,
           'room'=>$req->room,
           'image'=> $imagename,
       ]);
       return back()->with('message','Doctor Added Successfully ');
    }
    public function showappointment(){
        $data=Appointment::all();
        return view('admin.showappointment',compact('data'));
    }
    public function approved($id){
        $data=Appointment::find($id);
        $data->status='Approved';
        $data->save();
        return back();
    }
    public function canceled($id){
        $data=Appointment::find($id);
        $data->status='Canceled';
        $data->save();
        return back();
    }
    public function showdoctor(){
        $data=Doctor::all();
        return view('admin.showdoctor',compact('data'));
    }
    public function delete($id){
        $data=Doctor::find($id)->delete();
        return back();
    }
    public function updatedoctor($id){
        $data=Doctor::find($id);
        return view('admin.updatedoctor',compact('data'));
    }
    public function update(Request $req,$id){
        $data=Doctor::find($id);
        $data->name=$req->name;
        $data->phone=$req->phone;
        $data->speciality=$req->speciality;
        $data->room=$req->room;
        $image =$req->image;
        if($image){
            $imagename =time (). '.' .$image->getClientOriginalExtension();
            $req->image->move('photo',$imagename);
            $data->image=$imagename ;
        }
        $data->save();
        return redirect('showdoctor');
    }
    public function emailview($id){
        $data=Appointment::find($id);
        return view('admin.emailview',compact('data'));
    }
    public function sendmail(Request $req, $id){
        $data=Appointment::find($id);
        $details=[
           'greeting'=>$req->greeting,
           'body'=>$req->body,
           'actiontext'=>$req->actiontext,
           'actionurl'=>$req->actionurl,
           'endbody'=>$req->endbody
        ];
        Notification::send($data,new MyFirstNotification($details));
        return back();
    }
}
