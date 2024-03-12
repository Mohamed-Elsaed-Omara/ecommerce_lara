<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    
    public function index()
    {
        $category = Category::all();
        return view('dashboard.category.show',compact('category'));
    }

    
    public function store(Request $request)
    {
            $request->validate([
                'category_name' => 'required|unique:categories',
                'photo' => 'required|image'
            ]);
        try{

            if($request->hasFile('photo')){
    
                $fileName = now()->timestamp .'_'. $request->file('photo')->getClientOriginalName();
                $filePath = "uploads/categories/" . $fileName;
                $request->file('photo')->move('uploads/categories/',$fileName);
                
            }
            Category::create([
                'category_name'=> $request->category_name,
                'photo'=> $filePath
            ]);
    
            toastr()->success('Category has been saved successfully!');
    
            return back();

        }catch (\Exception $e){

            return back()->with('error',$e->getMessage());
        }
        
    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
    
            'category_name'=>['required',
            Rule::unique('categories')->ignore($category->id),
            
        ],
            'photo'=>'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try{
            $category->update(request()->all());

            if(!$request->has('bestsalers')){
                $category->bestsalers = false;
                $category->save();
            }else{
                $category->bestsalers = true;
                $category->save();
            }

            if($request->hasFile('photo')){
    
                $fileName = now()->timestamp .'_'. $request->file('photo')->getClientOriginalName();
                $filePath = "uploads/categories/" . $fileName;
                $request->file('photo')->move('uploads/categories/',$fileName);

                $category->photo = $filePath;
                $category->save();
            }

            toastr()->info('Category has been updated successfully!');
        
            return back();

        }catch (\Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }

    }


    public function destroy(string $id)
    {
        try{

            Category::findOrFail($id)->delete();
    
            toastr()->warning('category has been delete successfully!');
    
            return back();

        }catch(\Exception $e)
        {
            return back()->with('error',$e->getMessage());
        }

    }
}
