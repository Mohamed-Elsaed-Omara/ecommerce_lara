<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $slides = Slide::with('product')->paginate(10);

        return view('dashboard.slide.show',compact('slides'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::get();

        return view('dashboard.slide.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'content'=>'required',
            'photo' => 'required|image'
        ],[
            'product_id.required'=>'The product name field is required.'
        ]);

        $fileName = now()->timestamp .'_'. request()->file('photo')->getClientOriginalName(); 
        $filePath = "uploads/slides/" . $fileName;
        $request->file('photo')->move('uploads/slides/',$fileName);

        $data = request()->all();
        $data['photo'] = $filePath;

        $newSlide = Slide::create($data);

        toastr()->success('Slide has been saved successfully!');
    
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $slide = Slide::find($id);
        $products = Product::get();
        return view('dashboard.slide.edit',compact('slide','products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slide $slide)
    {
        if(request()->hasFile('photo')){
            $fileName = now()->timestamp .'_'. request()->file('photo')->getClientOriginalName(); 
            $filePath = "uploads/slides/" . $fileName;
            $request->file('photo')->move('uploads/slides/',$fileName);
        }
        
        $data = request()->all();
        if(isset($filePath)){
            $data['photo']= $filePath;
        }

        $slide->update($data);

        toastr()->success('Slide has been updated successfully!');
    
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        dd($id);
    }

    public function toggleActive(string $id)
    {
        $slide = Slide::find($id);

        $slide->update([
            'active'=> ! $slide->active
        ]);

        toastr()->info('tiggle has been change successfully!');

        return back();
    }
}
