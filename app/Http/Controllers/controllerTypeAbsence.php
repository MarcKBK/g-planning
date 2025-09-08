<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\typeAbsence;

class controllerTypeAbsence extends Controller
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


        if (typeabsence::where('type_absence', $request->type_absence)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {


               $type_absence = typeabsence::create([
                    "type_absence" => $request->type_absence,
                    "actif" => 1,
                ]);

                $reponse_server = ([
                    "reponse" => "success",
                    "id" => $type_absence->id,
                    "type_absence" => strtoupper($type_absence->type_absence)
                ]) ;


            }



        return response()->json($reponse_server) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $type_absence = DB::table("type_absences")
                ->where("id", $request->id)->first() ;

        $reponse_server = ([
            "reponse" => "success",
            "id" => $type_absence->id,
            "type_absence" => ucfirst($type_absence->type_absence),
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

        if(typeabsence::where('type_absence', $request->type_absence)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {




                $type_absence = DB::table('type_absences')
                ->where('id', $request->id_type_absence)
                ->update(['type_absence' => $request->type_absence]);

                $reponse_server = ([
                    "reponse" => "success",
                    "id" =>  $request->id_type_absence,
                    "type_absence" => ucfirst($request->type_absence)
                ]) ;


            }//

         return response()->json($reponse_server) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
    {

        $type_absence = DB::table('type_absences')
        ->where('id', $request->id)
        ->update(['actif' => 0]);


        return response()->json($request->id) ;

    }


    public function search(Request $request)
    {
        $resultat = "" ;

        $liste_type_absences = DB::table('type_absences')
        ->where('type_absence', 'like', $request->indice.'%')
        ->where('actif', 1)
        ->orderBy('type_absence', 'asc')
        ->get();

        foreach($liste_type_absences as $type_absence)
            {
                $resultat.=' <tr id="tr_type_absence'.$type_absence->id.'">
                <td scope="row" >'.$type_absence->id.'</td>
                <td id="td_nom_type_absence'.$type_absence->id.'">'.ucfirst($type_absence->type_absence).'</td>
                <td class="text-right">
                <i class="fas fa-pencil-alt btn-form-edite-type_absence  icon-lg text-warning" data-id="'.$type_absence->id.'">&ensp;
                </i> <i class="fa fa-trash  btn-delete-type_absence  icon-lg text-primary" data-id="'.$type_absence->id.'"></i>
                </td>

                 </tr>
                ';
            }

            $reponse_server = array(

                "resultat" => $resultat,
                "nombre_type_absence"  => count($liste_type_absences)

            );


        return response()->json($reponse_server) ;
    }
}
