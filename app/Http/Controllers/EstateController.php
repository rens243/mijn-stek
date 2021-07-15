<?php

namespace App\Http\Controllers;

use App\Models\House\Estate;
use Illuminate\Http\Request;

class EstateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estates = Estate::query()
            ->get();

        return view('houses.estate.index', ['estates' => $estates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('houses.estate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\House\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function show(Estate $estate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\House\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function edit(Estate $estate)
    {
        return view('houses.estate.edit', ['estate' => $estate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\House\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estate $estate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\House\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estate $estate)
    {
        //
    }
}
