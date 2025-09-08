<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\typeAgent;

class controllerTypeAgent extends Controller
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


        if (typeAgent::where('type_agent', $request->type_agent)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {


               $type_agent = typeAgent::create([
                    "type_agent" => $request->type_agent,
                    "actif" => 1,
                ]);

                $reponse_server = ([
                    "reponse" => "success",
                    "id" => $type_agent->id,
                    "type_agent" => strtoupper($type_agent->type_agent)
                ]) ;


            }



        return response()->json($reponse_server) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $type_agent = DB::table("type_agents")
                ->where("id", $request->id)->first() ;

        $reponse_server = ([
            "reponse" => "success",
            "id" => $type_agent->id,
            "type_agent" => ucfirst($type_agent->type_agent),
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

        if(typeAgent::where('type_agent', $request->type_agent)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {




                $type_agent = DB::table('type_agents')
                ->where('id', $request->id_type_agent)
                ->update(['type_agent' => $request->type_agent]);

                $reponse_server = ([
                    "reponse" => "success",
                    "id" =>  $request->id_type_agent,
                    "type_agent" => ucfirst($request->type_agent)
                ]) ;


            }//

         return response()->json($reponse_server) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
    {

        $type_agent = DB::table('type_agents')
        ->where('id', $request->id)
        ->update(['actif' => 0]);


        return response()->json($request->id) ;

    }


    public function search(Request $request)
    {
        $resultat = "" ;

        $liste_type_agents = DB::table('type_agents')
        ->where('type_agent', 'like', $request->indice.'%')
        ->where('actif', 1)
        ->orderBy('type_agent', 'asc')
        ->get();

        foreach($liste_type_agents as $type_agent)
            {
                $resultat.=' <tr id="tr_type_agent'.$type_agent->id.'">
                <td scope="row" >'.$type_agent->id.'</td>
                <td id="td_nom_type_agent'.$type_agent->id.'">'.ucfirst($type_agent->type_agent).'</td>
                <td class="text-right">
                <i class="fas fa-pencil-alt btn-form-edite-type_agent  icon-lg text-warning" data-id="'.$type_agent->id.'">&ensp;
                </i> <i class="fa fa-trash  btn-delete-type_agent  icon-lg text-primary" data-id="'.$type_agent->id.'"></i>
                </td>

                 </tr>
                ';
            }

            $reponse_server = array(

                "resultat" => $resultat,
                "nombre_type_agent"  => count($liste_type_agents)

            );


        return response()->json($reponse_server) ;
    }
}
