<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Deal;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DealController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deals = Deal::paginate();
        return view('dashboard.deal.show',compact('deals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('dashboard.deal.create',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'name'=>'required',
            'product_id' => 'required',
            'discount' => 'required',
            'duration' => 'required',
            'start_at' => 'required',
        ],[
            'product_id.required'=>'The product name field is required.'
        ]);

        $data = request()->all();

        $startTime = Carbon::parse($data['start_at']);
        
        $data['end_at'] = $startTime->addHours($data['duration']);
        
        $product = Product::find(request()->product_id);

        $data['amount'] = $data['discount'] * $product->price / 100;

        Deal::create($data);

        toastr()->success('Deal has been saved successfully!');

        return back();
    }


    public function edit(string $id)
    {
        $deal = Deal::find($id);
        $products = Product::get();
        return view('dashboard.deal.edit',compact('deal','products'));
    }

    public function update(Request $request, Deal $deal)
    {
        request()->validate([
            'name'=>'required',
            'product_id' => 'required',
            'discount' => 'required',
            'duration' => 'required',
            
        ],[
            'product_id.required'=>'The product name field is required.'
        ]);

        
        try {
            $data = request()->all();
            $startTime = Carbon::parse($data['start_at']);
            
            $data['end_at'] = $startTime->addHours($data['duration']);
    
            $product = Product::find(request()->product_id);
    
            $data['amount'] = $data['discount'] * $product->price / 100;

            $deal->update($data);
        
            toastr()->info('Deal has been updated successfully!');
                
            return back();

        } catch (\Exception $e) {
            
            return back()->with('error',$e->getMessage());
        }

    }

    public function destroy(string $id)
    {
        Deal::findOrFail($id)->delete();

        toastr()->warning('Deal has been Deleted successfully!');

        return back();
    }
}
