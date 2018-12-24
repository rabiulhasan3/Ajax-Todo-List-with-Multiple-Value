<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use DB;

class StudentController extends Controller
{
   	//***************************************
	// Redirect To All Student Show Page
	// **************************************
	public function index(){
		$students = DB::table('students')->get();
		return view('student.all_student',compact('students'));
	}

   	//***************************************
	// Student Create In this section
	// **************************************
	public function create_student(Request $request){
		$name = $request->name;
		$mobile = $request->mobile;
		$email = $request->email;

		DB::table('students')->insert([
			'name' => $name,
			'mobile' => $mobile,
			'email' => $email,
		]);
	}


    //***************************************
	// Student Delete Section
	// **************************************
    public function delete(Request $request){
    	$id = $request->id;
    	echo $id;
    	DB::table('students')->where('id',$id)->delete();
    }


    //***************************************
	// Student Update Section
	// **************************************
	public function update(Request $request){
		$name = $request->name;
		$mobile = $request->mobile;
		$email = $request->email;
		$id = $request->id;
		DB::table('students')->where('id',$id)->update([
			'name' => $name,
			'mobile' => $mobile,
			'email' => $email,
		]);
	}

}
