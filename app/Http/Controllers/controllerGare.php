<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\gare;

class controllerGare extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reponse_server = "" ;


        if (gare::where('gare', $request->gare)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {


               $gare = gare::create([
                    "gare" => $request->gare,
                    "longitude" => $request->longitude,
                    "latitude" => $request->latitude,
                    "voie" => $request->voie,
                    "actif" => 1,
                ]);

                $reponse_server = ([
                    "reponse" => "success",
                    "id" => $gare->id,
                    "gare" => strtoupper($gare->gare),
                    "voie" => $request->voie,
                    "longitude" => $request->longitude,
                    "latitude" => $request->latitude,
                ]) ;


            }



        return response()->json($reponse_server) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $gare = DB::table("gares")
                ->where("id", $request->id)->first() ;

        $reponse_server = ([
            "reponse" => "success",
            "id" => $gare->id,
            "gare" => ucfirst($gare->gare),
            "voie" => $gare->voie,
            "longitude" => $gare->longitude,
            "latitude" => $gare->latitude,
            "actif" => $request->id,
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

        if(gare::where('gare', $request->gare)->where("id","!=", $request->id_gare)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {




                $gare = DB::table('gares')
                ->where('id', $request->id_gare)
                ->update([
                            'gare' => $request->gare,
                            "voie" => $request->voie,
                            "longitude" => $request->longitude,
                            "latitude" => $request->latitude,
                        ]);

                $reponse_server = ([
                    "reponse" => "success",
                    "id" =>  $request->id_gare,
                    "gare" => ucfirst($request->gare),
                    "voie" => $request->voie,
                    "longitude" => $request->longitude,
                    "latitude" => $request->latitude,
                ]) ;


            }//

         return response()->json($reponse_server) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
    {

        $gare = DB::table('gares')
        ->where('id', $request->id)
        ->update(['actif' => 0]);


        return response()->json($request->id) ;

    }


    public function search(Request $request)
    {
        $resultat = "" ;

        $liste_gares = DB::table('gares')
        ->where('gare', 'like', $request->indice.'%')
        ->where('actif', 1)
        ->orderBy('gare', 'asc')
        ->get();

        foreach($liste_gares as $gare)
            {
                $resultat.=' <tr id="tr_gare'.$gare->id.'">
                <td scope="row" >'.$gare->id.'</td>
                <td id="td_nom_gare'.$gare->id.'">'.strtoupper($gare->gare).'</td>
                <td id="td_longitude_gare'.$gare->id.'">'.$gare->longitude.'</td>
                <td id="td_latitude_gare'.$gare->id.'">'.$gare->latitude.'</td>
                <td class="text-right">
                <i class="fas fa-pencil-alt btn-form-edite-gare  icon-lg text-warning" data-id="'.$gare->id.'">&ensp;
                </i> <i class="fa fa-trash  btn-delete-gare  icon-lg text-primary" data-id="'.$gare->id.'"></i>
                </td>

                 </tr>
                ';
            }

            $reponse_server = array(

                "resultat" => $resultat,
                "nombre_gare"  => count($liste_gares)

            );


        return response()->json($reponse_server) ;
    }
}
