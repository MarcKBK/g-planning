<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\depot;

class controllerDepot extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $reponse_server = "" ;


        if (depot::where('depot', $request->depot)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {


               $depot = depot::create([
                    "depot" => $request->depot,
                    "actif" => 1,
                ]);

                $reponse_server = ([
                    "reponse" => "success",
                    "id" => $depot->id,
                    "depot" => strtoupper($depot->depot)
                ]) ;


            }



        return response()->json($reponse_server) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $depot = DB::table("depots")
                ->where("id", $request->id)->first() ;

        $reponse_server = ([
            "reponse" => "success",
            "id" => $depot->id,
            "depot" => ucfirst($depot->depot),
            "actif" => $request->id,
            "depot" => strtoupper($depot->depot)
        ]) ;


        return response()->json($reponse_server) ;
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
    public function update(Request $request)
    {

        if(depot::where('depot', $request->depot)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {




                $depot = DB::table('depots')
                ->where('id', $request->id_depot)
                ->update(['depot' => $request->depot]);

                $reponse_server = ([
                    "reponse" => "success",
                    "id" =>  $request->id_depot,
                    "depot" => ucfirst($request->depot)
                ]) ;


            }//

         return response()->json($reponse_server) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
    {

        $depot = DB::table('depots')
        ->where('id', $request->id)
        ->update(['actif' => 0]);


        return response()->json($request->id) ;

    }


    public function search(Request $request)
    {
        $resultat = "" ;

        $liste_depots = DB::table('depots')
        ->where('depot', 'like', $request->indice.'%')
        ->where('actif', 1)
        ->orderBy('depot', 'asc')
        ->get();

        foreach($liste_depots as $depot)
            {
                $resultat.=' <tr id="tr_depot'.$depot->id.'">
                <td scope="row" >'.$depot->id.'</td>
                <td id="td_nom_depot'.$depot->id.'">'.ucfirst($depot->depot).'</td>
                <td class="text-right">
                <i class="fas fa-pencil-alt btn-form-edite-depot  icon-lg text-warning" data-id="'.$depot->id.'">&ensp;
                </i> <i class="fa fa-trash  btn-delete-depot  icon-lg text-primary" data-id="'.$depot->id.'"></i>
                </td>

                 </tr>
                ';
            }

            $reponse_server = array(

                "resultat" => $resultat,
                "nombre_depot"  => count($liste_depots)

            );


        return response()->json($reponse_server) ;
    }
}
