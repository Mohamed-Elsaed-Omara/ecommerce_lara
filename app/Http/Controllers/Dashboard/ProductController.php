<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Photo;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('dashboard.product.index',compact('products','categories'));
    }


    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        $data = $request->all();
        $data['sku'] = '';
        $newProduct = Product::create($data);

            if($request->hasFile('photos')){
    
                foreach($request->file('photos') as $photo){
    
                    $fileName = now()->timestamp .'_'. $photo->getClientOriginalName();
                    $filePath = "uploads/products/" . $fileName;
                    $photo->move('uploads/products/', $fileName);

                    Photo::create([
                        'path' => $filePath,
                        'product_id' => $newProduct->id
                    ]);
                
                }
            }

        toastr()->success('Product has been saved successfully!');
    
        return back();
    }


    public function show(Product $product)
    {
        $product->load(['category','photos']);
        return view('dashboard.product.show',compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.product.edit',compact('categories','product'));
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        $product->update($request->all());

        if($request->hasFile('photos')){

            foreach($request->file('photos') as $photo){

                $fileName = now()->timestamp .'_'. $photo->getClientOriginalName();

                $filePath = "uploads/products/". $fileName;

                $photo->move('uploads/products/',$fileName);

                Photo::create([
                    'path' => $filePath,
                    'product_id' => $product->id,
                ]);
            }
        }

        toastr()->info('Product has been updated successfully!');
        
        return back();
    }


    public function destroy(string $id)
    {
        try {

            Product::destroy($id);
    
            toastr()->warning('Product has been delete successfully!');
            return redirect()->route('products.index');

        } catch (\Exception $e) {
            
            return back()->with('error',$e->getMessage());
        }
    }

    public function removeImg($id)
    {
        Photo::destroy($id);

        toastr()->warning('Photo has been deleted successfully!');
        return back();
    }
}
