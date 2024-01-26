<?php

namespace App\Http\Controllers;

use App\Models\Guild;
use Illuminate\Http\Request;

class GuildController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Guild::all();
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Guild $guild)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guild $guild)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guild $guild)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guild $guild)
    {
        //
    }
}
