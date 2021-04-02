<?php

namespace App\Http\Controllers;

use App\Models\Methodology;
use Illuminate\Http\Request;

class MethodologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('methodologies.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Methodology  $methodology
     * @return \Illuminate\Http\Response
     */
    public function show(Methodology $methodology)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Methodology  $methodology
     * @return \Illuminate\Http\Response
     */
    public function edit(Methodology $methodology)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Methodology  $methodology
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Methodology $methodology)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Methodology  $methodology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Methodology $methodology)
    {
        //
    }

    public function scrum(){
        return view('methodologies.scrum');
    }
    public function kanban (){
        return view('methodologies.kanban');
    }
    public function crystal(){
        return view('methodologies.crystal');
    }
    public function ld (){
        return view('methodologies.ld');
    }
    public function dsdm (){
        return view('methodologies.dsdm');
    }
    public function xp(){
        return view('methodologies.xp');
    }
    public function fdd(){
        return view('methodologies.fdd');
    }
}
