<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::latest()->get();
        return view('project.all', ['data' => $packages]);
    }

    public function listAll()
    {
        $packages = Package::latest()->get();
        return response()->json([
            'data' => $packages,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "price" => "required|numeric",
            "unit" => "required|numeric"
        ]);

        $total = $request->price * $request->unit;
        $package = new Package;
        $package->name = $request->name;
        $package->unity = $request->unit;
        $package->total = $total;
        $package->price_unity = $request->price;
        $package->save();
        return redirect('/project');
    }

    public function projectCreate(Request $request)
    {
        $request->validate([
            "name" => "required",
            "price" => "required|numeric",
            "unit" => "required|numeric"
        ]);

        $total = $request->price * $request->unit;
        $package = new Package;
        $package->name = $request->name;
        $package->unity = $request->unit;
        $package->total = $total;
        $package->price_unity = $request->price;
        $package->save();
        return response()->json([
            'message' => 'Request send'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($package)
    {
        $package = Package::find($package);
        $package->delete();
        return redirect('/project/all');
    }

    public function delete($package)
    {
        $package = Package::find($package);
        $package->delete();
        return response()->json([
            'message' => 'Package deleted'
        ], 200);
    }

    public function financeList()
    {
        $packages = Package::where('status', 'pending')->get();
        return view('finance.all', ['data' => $packages]);
    }

    public function financeApprove($id)
    {
        $package = Package::find($id)->first();
        $package->status = 'financeApproved';
        $package->update();
        return redirect('/finance');
    }

    public function reject($id)
    {
        $package = Package::find($id)->first();
        $package->status = 'rejected';
        $package->update();
        if (Auth::user()->role == 'finance') {
            return redirect('/finance');
        } else {
            return redirect('/general');
        }
    }

    public function rejectApi($id)
    {
        $package = Package::find($id)->first();
        $package->status = 'rejected';
        $package->update();
        return response()->json([
            'message' => 'Package rejected'
        ], 200);
    }

    public function generalList()
    {
        $packages = Package::where('status', 'financeApproved')->get();
        return view('general.all', ['data' => $packages]);
    }

    public function generalApprove($id)
    {
        $package = Package::find($id)->first();
        $package->status = 'generalApproved';
        $package->update();
        return redirect('/general');
    }

    public function approveApi($id)
    {
        $package = Package::find($id)->first();
        if (Auth::guard('api')->user()->role == 'finance') {
            $package->status = 'financeApproved';
        } else {
            $package->status = 'generalApproved';
        }
        $package->update();
        return response()->json([
            'message' => 'Package Approved'
        ], 200);
    }
}
