<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\gare;

class controllerParametre extends Controller
{
    //
    public function index()
    {
        // Liste des Gares
        $gares = DB::table("gares")
                ->where("actif", 1)
                ->get() ;


        // Liste des Depots
        $depots = DB::table("depots")
                ->where("actif", 1)
                ->get();

        return view('pages/parametre', compact(
            "gares",
            "depots"
            )) ;
    }



}
