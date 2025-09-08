<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\vehicule;

class controllerVehicule extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          // Liste des Type Véhicules
          $type_vehicules = DB::table("type_vehicules")
          ->where("actif", 1)
          ->get() ;

           // Liste des Véhicules
           $vehicules = DB::table("vehicules")
           ->where("actif", 1)
           ->get() ;

        return view('pages/vehicule', compact(

            "type_vehicules",
            "vehicules"


        )) ;
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


        if (vehicule::where('type', $request->type_vehicule)->where("vehicule", $request->vehicule)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {


               $vehicule = vehicule::create([
                    "type" => $request->type_vehicule,
                    "vehicule" => $request->vehicule,
                    "actif" => 1,
                ]);

                // nom du type de voiture
                $type = DB::table("type_vehicules")->where("id", $request->type_vehicule)->first() ;
                $reponse_server = ([
                    "reponse" => "success",
                    "id" => $vehicule->id,
                    "type" => ucfirst($type->type_vehicule),
                    "vehicule" => ucfirst($vehicule->vehicule)
                ]) ;


            }



        return response()->json($reponse_server) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $vehicule = DB::table("vehicules")
                ->where("id", $request->id)->first() ;

        $reponse_server = ([
            "reponse" => "success",
            "id" => $vehicule->id,
            "type" => ucfirst($vehicule->type),
            "vehicule" => ucfirst($vehicule->vehicule),
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

        if (vehicule::where('type', $request->type_vehicule)->where("vehicule", $request->vehicule)->where("id","!=" ,$request->id_vehicule)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {




                $type_vehicule = DB::table('vehicules')
                ->where('id', $request->id_vehicule)
                ->update([
                            'type' => $request->type_vehicule,
                            'vehicule' => $request->vehicule,
                        ]);

                // nom du type de voiture
                $type = DB::table("type_vehicules")->where("id", $request->type_vehicule)->first() ;

                $reponse_server = ([
                    "reponse" => "success",
                    "id" =>  $request->id_vehicule,
                    "type" => ucfirst($type->type_vehicule),
                    "vehicule" => ucfirst($request->vehicule),
                ]) ;


            }//

         return response()->json($reponse_server) ;
    }



    public function search(Request $request)
    {

        // initialisation  des variables
        $resultat = "" ;
        $vehicules = "" ;

        // Véhicule & tous
        if($request->type_vehicule == "tous" && $request->vehicule != "")
            {
                $vehicules = DB::table('vehicules')
                ->where('vehicule', 'like', $request->vehicule.'%')
                ->where('actif', 1)
                ->orderBy('vehicule', 'asc')
                ->get();
            }

        // Véhicule & type Véhicule
       else if($request->type_vehicule != "tous" && $request->vehicule != "")
            {
                $vehicules = DB::table('vehicules')
                ->where('type', $request->type_vehicule)
                ->where('vehicule', 'like', $request->vehicule.'%')
                ->where('actif', 1)
                ->orderBy('vehicule', 'asc')
                ->get();
            }
         // type Véhicule && null
       else if($request->type_vehicule != "tous" && $request->vehicule == "")
        {
            $vehicules = DB::table('vehicules')
            ->where('type', $request->type_vehicule)
            ->where('actif', 1)
            ->orderBy('vehicule', 'asc')
            ->get();
        }
        else
            {
                $vehicules = DB::table('vehicules')
                ->where('actif', 1)
                ->orderBy('vehicule', 'asc')
                ->get();
            }




        foreach($vehicules as $vehicule)
            {

                // nom du type de voiture
                $type = DB::table("type_vehicules")->where("id", $vehicule->type)->first() ;

                $resultat.=' <tr id="tr_vehicule'.$vehicule->id.'">
                <td scope="row" >'.$vehicule->id.'</td>
                <td id="td_type_vehicule'.$vehicule->id.'">'.ucfirst($type->type_vehicule).'</td>
                <td id="td_nom_vehicule'.$vehicule->id.'">'.ucfirst($vehicule->vehicule).'</td>
                <td class="text-right">
                <i class="fas fa-pencil-alt  btn-form-edite-vehicule  icon-lg text-warning" data-id="'.$vehicule->id.'">&ensp;
                </i> <i class="fa fa-trash  btn-delete-vehicule  icon-lg text-primary" data-id="'.$vehicule->id.'"></i>
                </td>

                 </tr>
                ';
            }

            $reponse_server = array(

                "resultat" => $resultat,
                "nombre_vehicule"  => count($vehicules)

            );


        return response()->json($reponse_server) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
    {

        $type_vehicule = DB::table('vehicules')
        ->where('id', $request->id)
        ->update(['actif' => 0]);


        return response()->json($request->id) ;

    }
}
