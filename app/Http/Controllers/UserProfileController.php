<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use JsValidator;



class UserProfileController extends Controller
{
    protected function sendError($errors, $message = 'Validation Error', $code = 422)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors->errors()
        ], $code);
    }
    protected $validationRules = [
        'name' => 'required|min:3|max:50',
        'email' => 'required',
        'password'=> 'required|min:8|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/',
        'image_uploaded.*' => 'nullable|mimes:jpeg,png,jpg',

         
      ];
    public function index()
    {
        $data['user']= Auth::user();
        $data['validator'] = JsValidator::make($this->validationRules);
        return view('edit_user_profile',$data);
    }
    public function edit(Request $request)
    {
        $input= $request->all();
        $user= Auth::user();
        // dd($user->id);
        $rules = [
            'email' => 'required|unique:users,email,' . $user->id . ',id|email', // Optional image for updates
       ];
   
       // Perform validation
       $validator = Validator::make($input, $rules);
   
   if ($validator->fails()) {
       return $this->sendError($validator);
   }

 
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        if ($request->hasFile('image_uploaded')) {
            foreach($request->file('image_uploaded') as $image){
            if ($user->image_uploaded && File::exists(public_path('images/' . $user->image_uploaded))) {
                File::delete(public_path('images/' . $user->image_uploaded));
            }
    
            // Upload new image
          
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
    
            $user->image_uploaded = $imageName;
        }
        }
        

        $data =$user->save();
        return response()->json(['statusCode' => 1, "title" => 'Success', 'type' => 'success', "statusMsg" => 'data inserted successfully', 'data' =>$data]);

  

    }
}
