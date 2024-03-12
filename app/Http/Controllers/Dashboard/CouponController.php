<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::paginate(10);
        return view('dashboard.coupon.show',compact('coupons'));
    }

    public function create()
    {
        return view('dashboard.coupon.create');
    }

    public function store(Request $request)
    {
        request()->validate([
            'code' => 'required',
            'type'=>'required',
            'discount'=> 'required',
            'redeems' => 'required',
        ]);

        try {

            Coupon::create($request->all());

            toastr()->success('Coupon has been saved successfully!');

            return back();
        } catch (\Exception $e) {
            return back()->with('error',$e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $coupon = Coupon::find($id);
        return view('dashboard.coupon.edit',compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        request()->validate([
            'code' => 'required',
            'type'=>'required',
            'discount'=> 'required',
            'redeems' => 'required',
        ]);

        $coupon->update($request->all());

        toastr()->info('Coupon has been updated successfully!');
                
        return back();
    }

    public function destroy(string $id)
    {
        try {
            Coupon::findOrFail($id)->delete();
    
            toastr()->warning('Coupon has been Deleted successfully!');
    
            return back();
            
        } catch (\Exception $e) {
            
            return back()->with('error',$e->getMessage());
        }
    }
}
