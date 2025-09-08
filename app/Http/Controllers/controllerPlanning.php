<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\planning;

class controllerPlanning extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gares = DB::table("gares")
        ->where("actif", 1)
        ->get() ;


        // Liste des Depots
        $depots = DB::table("depots")
                ->where("actif", 1)
                ->get();

        return view('pages/planning', compact(
            "gares",
            "depots"
            
            )) ;//
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
