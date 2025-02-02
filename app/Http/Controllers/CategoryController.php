<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\categories;
use JsValidator;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
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
        'name' => 'required|unique:categories,name|min:3|max:50',
        'slug' => 'required|unique:categories|url',
        'category_image.*' => 'required|mimes:jpeg,png,jpg',

         
      ];
    

  


        public function index()
        {
            $data['validator'] = JsValidator::make($this->validationRules);
            $data['categories'] = categories::whereNull('parent_id')->with('children')->get();
           

           return view('category.add-category',$data);   
        }
        public function addcategory(Request $request)
        {
            $input= $request->all();
            // dd($input);
            $validator = Validator::make($input, $this->validationRules);
            if ($validator->fails()) {
                return $this->sendError($validator);
            }
           $imageName='';
            // Check if images are uploaded
            if ($request->hasFile('category_image')) {
                foreach ($request->file('category_image') as $image) {
                    // Generate unique name for each image
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('images'), $imageName); // Save image to public folder
           
                }
            }
    
            // Store category data with images
            $input['category_image'] = $imageName;
          
            $data= categories::create($input);
            
            
             return response()->json(['statusCode' => 1, "title" => 'Success', 'type' => 'success', "statusMsg" => 'data inserted successfully', 'data' =>$data]);
       
        
            }
        public function showlist()
        {
           return view('category.list-category');
        }
        public function listdata(Request $request )
        {
           $draw = $request->get('draw');
           $start = $request->get("start");
           $rowperpage = $request->get("length") ?? 10;
           $query = categories::with('parent');
    
       $search_arr = $request->get('search');
       $searchValue = $search_arr['value'] ?? '';
       if ($searchValue != "") {
           $query->where(function ($query) use ($searchValue) {
               $query->orWhere('name', 'like', '%' . $searchValue . '%');
               
           });
       }
           $totalRecords = $query->count();
           $query = $query->skip($start)->take($rowperpage);
           $totalRecordswithFilter = $totalRecords;
           $category = $query->get();
    
           
          
    
            $data_arr = [];
            foreach ($category as $record) {
                $image='';
            if(!empty($record->category_image)){
                $image='<img src="' . asset('images/'.$record->category_image) . '"  width="50" height="50" alt="Category Image">';

            }
               $data_arr[] = [
                   'id'=>$record->id,
                   'name'=>$record->name,
                   'slug'=>$record->slug,
                   'parent_id'=>$record->parent->name ?? '',
                   'category_image'=>$image,
                   'action'=> '<a href="'.url('edit-category/' .$record->id).'" action="'.url('edit-user/' .$record->id).'" ><i class="far fa-edit"></i></a>
                               <a href="'.url('deletecategory/' .$record->id).'" class="delete alert-danger" data-id="' . $record->id . '" id="delete-product"><i class="far fa-trash-alt"></i></a>'
                           
               ];          
              
           }
 
           $data_arr1["draw"] = $draw;
           $data_arr1["iTotalRecords"] = $totalRecords;
           $data_arr1["iTotalDisplayRecords"] = $totalRecordswithFilter;
           $data_arr1["aaData"] = $data_arr;
           return response()->json($data_arr1);
           
        }
        public function delete(Request $request, $id)
        {
            $category = categories::findOrFail($id);
            $category->children()->delete();
          
    
            $category->delete();

            
          return redirect()->back();
        }
        public function editcategory($id)
        {
           $data['category']= categories::find($id);
          
           $data['categories'] =categories::whereNull('parent_id')->with('parent')->get();
           $rules = [
            'name' => 'required|min:3|max:50',
             'slug' => 'required|url',
             'category_image' => 'nullable|mimes:jpeg,png,jpg|max:2048', // Make optional for updates
         ]; 

    
        $data['editvalidator'] = JsValidator::make($rules);
           return view('category.edit-category', $data);
        }
    
        public function update(Request $request,$id)
        {
           $input= $request->all();
                 $rules = [
                    'name' => 'required|unique:categories,name,' . $id . ',id|min:3|max:50',
                    'slug' => 'required|unique:categories,slug,' . $id . ',id|url',
                    'category_image.*' => 'nullable|mimes:jpeg,png,jpg|max:2048', // Optional image for updates
                ];
            
                // Perform validation
                $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return $this->sendError($validator);
            }
           $imageName='';
           $data= categories::where('id',$request->id)->first();
           if ($request->hasFile('category_image')) {
            foreach ($request->file('category_image') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('images'), $imageName); // Save image to public folder
       
            }
        }

        $input['category_image'] = $imageName;
           $data->update($input);
         
           return response()->json(['statusCode' => 1, "title" => 'Success', 'type' => 'success', "statusMsg" => 'data inserted successfully', 'data' =>$data]);
           
      
        }
        public function categories_display()
        {
            $data['categories'] = categories::whereNull('parent_id')->get();

            $data['subcategories'] = categories::whereNotNull('parent_id')->with('children')->get();
            
            return view('category.display-categories', $data);
        }
    
    }
    

