<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\typeVehicule;

class controllerTypeVehicule extends Controller
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


        if (typeVehicule::where('type_vehicule', $request->type_vehicule)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {


               $type_vehicule = typeVehicule::create([
                    "type_vehicule" => $request->type_vehicule,
                    "actif" => 1,
                ]);

                $reponse_server = ([
                    "reponse" => "success",
                    "id" => $type_vehicule->id,
                    "type_vehicule" => strtoupper($type_vehicule->type_vehicule)
                ]) ;


            }



        return response()->json($reponse_server) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $type_vehicule = DB::table("type_vehicules")
                ->where("id", $request->id)->first() ;

        $reponse_server = ([
            "reponse" => "success",
            "id" => $type_vehicule->id,
            "type_vehicule" => ucfirst($type_vehicule->type_vehicule),
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

        if(typeVehicule::where('type_vehicule', $request->type_vehicule)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {




                $type_vehicule = DB::table('type_vehicules')
                ->where('id', $request->id_type_vehicule)
                ->update(['type_vehicule' => $request->type_vehicule]);

                $reponse_server = ([
                    "reponse" => "success",
                    "id" =>  $request->id_type_vehicule,
                    "type_vehicule" => ucfirst($request->type_vehicule)
                ]) ;


            }//

         return response()->json($reponse_server) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
    {

        $type_vehicule = DB::table('type_vehicules')
        ->where('id', $request->id)
        ->update(['actif' => 0]);


        return response()->json($request->id) ;

    }


    public function search(Request $request)
    {
        $resultat = "" ;

        $liste_type_vehicules = DB::table('type_vehicules')
        ->where('type_vehicule', 'like', $request->indice.'%')
        ->where('actif', 1)
        ->orderBy('type_vehicule', 'asc')
        ->get();

        foreach($liste_type_vehicules as $type_vehicule)
            {
                $resultat.=' <tr id="tr_type_vehicule'.$type_vehicule->id.'">
                <td scope="row" >'.$type_vehicule->id.'</td>
                <td id="td_nom_type_vehicule'.$type_vehicule->id.'">'.ucfirst($type_vehicule->type_vehicule).'</td>
                <td class="text-right">
                <i class="fas fa-pencil-alt btn-form-edite-type_vehicule  icon-lg text-warning" data-id="'.$type_vehicule->id.'">&ensp;
                </i> <i class="fa fa-trash  btn-delete-type_vehicule  icon-lg text-primary" data-id="'.$type_vehicule->id.'"></i>
                </td>

                 </tr>
                ';
            }

            $reponse_server = array(

                "resultat" => $resultat,
                "nombre_type_vehicule"  => count($liste_type_vehicules)

            );


        return response()->json($reponse_server) ;
    }
}
