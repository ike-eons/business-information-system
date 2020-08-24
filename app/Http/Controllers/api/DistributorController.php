<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Distributor;
use Illuminate\Http\Response;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $distributors = Distributor::latest()->get();

        return response()->json([
            'distributors'  => $distributors
        ]);
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required',
            'address'   => 'required',
            'phone'     => 'required|distributors:unique|regex:/(0)[0-9]{9}/',
            'email'     => 'required|distributors:unique|email'
        ]);

        $distributor = Distributor::create($request->all());

        return response()->json([
            'message'   => 'distributor created',
            'distributor'    =>  $distributor
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'company_name' => 'required',
            'address'   => 'required',
            'phone'     => 'required|regex:/(0)[0-9]{9}/',
            'email'     => 'required|email'
        ]);

        Distributor::update($request->all());

        return response()->json([
            'message'   => 'distributor updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $distributor = Distributor::findOrFail($id);

        $distributor->delete();

        return response(null,Response::HTTP_NO_CONTENT);
    }
}
