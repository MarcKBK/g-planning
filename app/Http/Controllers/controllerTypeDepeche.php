<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\typeDepeche;

class controllerTypeDepeche extends Controller
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
    public function store(Request $request)
    {
        $reponse_server = "" ;


        if (typedepeche::where('type_depeche', $request->type_depeche)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {


               $type_depeche = typedepeche::create([
                    "type_depeche" => $request->type_depeche,
                    "actif" => 1,
                ]);

                $reponse_server = ([
                    "reponse" => "success",
                    "id" => $type_depeche->id,
                    "type_depeche" => strtoupper($type_depeche->type_depeche)
                ]) ;


            }



        return response()->json($reponse_server) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $type_depeche = DB::table("type_depeches")
                ->where("id", $request->id)->first() ;

        $reponse_server = ([
            "reponse" => "success",
            "id" => $type_depeche->id,
            "type_depeche" => ucfirst($type_depeche->type_depeche),
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

        if(typedepeche::where('type_depeche', $request->type_depeche)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {




                $type_depeche = DB::table('type_depeches')
                ->where('id', $request->id_type_depeche)
                ->update(['type_depeche' => $request->type_depeche]);

                $reponse_server = ([
                    "reponse" => "success",
                    "id" =>  $request->id_type_depeche,
                    "type_depeche" => ucfirst($request->type_depeche)
                ]) ;


            }//

         return response()->json($reponse_server) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
    {

        $type_depeche = DB::table('type_depeches')
        ->where('id', $request->id)
        ->update(['actif' => 0]);


        return response()->json($request->id) ;

    }


    public function search(Request $request)
    {
        $resultat = "" ;

        $liste_type_depeches = DB::table('type_depeches')
        ->where('type_depeche', 'like', $request->indice.'%')
        ->where('actif', 1)
        ->orderBy('type_depeche', 'asc')
        ->get();

        foreach($liste_type_depeches as $type_depeche)
            {
                $resultat.=' <tr id="tr_type_depeche'.$type_depeche->id.'">
                <td scope="row" >'.$type_depeche->id.'</td>
                <td id="td_nom_type_depeche'.$type_depeche->id.'">'.ucfirst($type_depeche->type_depeche).'</td>
                <td class="text-right">
                <i class="fas fa-pencil-alt btn-form-edite-type_depeche  icon-lg text-warning" data-id="'.$type_depeche->id.'">&ensp;
                </i> <i class="fa fa-trash  btn-delete-type_depeche  icon-lg text-primary" data-id="'.$type_depeche->id.'"></i>
                </td>

                 </tr>
                ';
            }

            $reponse_server = array(

                "resultat" => $resultat,
                "nombre_type_depeche"  => count($liste_type_depeches)

            );


        return response()->json($reponse_server) ;
    }
}
