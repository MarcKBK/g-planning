<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\prise_service;
use Illuminate\Http\Request;

class controllerPriseService extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Liste des Gares
        $gares = DB::table("gares")
                ->where("actif", 1)
                ->get() ;

         // Liste des Type Agents
         $type_agents = DB::table("type_agents")
         ->where("actif", 1)
         ->get() ;
                
         // Liste des Agents
         $agents = DB::table("agents")
         ->join("type_agents", "type_agents.id", "=", "agents.type")
         ->join("depots", "depots.id", "=", "agents.depot")
         ->where("agents.actif", 1)
         ->select(
             "agents.id as id",
             "type_agents.type_agent as type",
             "depots.depot as depot",
             "agents.nom as nom",
             "agents.prenom as prenom",
             "agents.matricule as matricule",
             "agents.photo as photo",
 
              )->orderBy('agents.nom', 'ASC')->get() ;





            // Liste des prise de sercies 
           $liste_prise_services = DB::table("prise_services")
           ->join("agents", "agents.id", "=", "prise_services.id_agent")
           ->join("type_agents", "type_agents.id", "=", "agents.type")
           ->join("gares", "gares.id", "=", "prise_services.id_gare")
           ->select(
               "prise_services.id as id",
               "type_agents.type_agent as type_agent",
               "gares.gare as gare",
               "agents.nom as nom",
               "agents.prenom as prenom",
               "agents.photo as photo",
               "prise_services.date_heure as date_heure",
               "prise_services.actif as actif",
               
                )->orderBy('prise_services.date_heure', 'desc')->get() ;

        return view('pages/prise_service', compact(
            'type_agents',
            'agents',
            'gares',
            'liste_prise_services'
        )) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function search(Request $request)
        {
            $resultat = "" ;
            $liste_prise_services = "" ;

            // Gare
            if($request->gare != "tous" && $request->agent == "tous" && $request->type_agent == "tous")
                {
                    $liste_prise_services = DB::table("prise_services")
                    ->join("agents", "agents.id", "=", "prise_services.id_agent")
                    ->join("type_agents", "type_agents.id", "=", "agents.type")
                    ->join("gares", "gares.id", "=", "prise_services.id_gare")
                    ->where("prise_services.id_gare", $request->gare)
                    ->select(
                        "prise_services.id as id",
                        "type_agents.type_agent as type_agent",
                        "gares.gare as gare",
                        "agents.nom as nom",
                        "agents.prenom as prenom",
                        "agents.photo as photo",
                        "prise_services.date_heure as date_heure",
                        "prise_services.actif as actif",
                        
                        )->orderBy('prise_services.date_heure', 'desc')->get() ;
                }

            // Gare & Agent
           else if($request->gare != "tous" && $request->agent != "tous" && $request->type_agent == "tous")
                {
                    $liste_prise_services = DB::table("prise_services")
                    ->join("agents", "agents.id", "=", "prise_services.id_agent")
                    ->join("type_agents", "type_agents.id", "=", "agents.type")
                    ->join("gares", "gares.id", "=", "prise_services.id_gare")
                    ->where("prise_services.id_gare", $request->gare)
                    ->where("prise_services.id_agent", $request->agent)
                    ->select(
                        "prise_services.id as id",
                        "type_agents.type_agent as type_agent",
                        "gares.gare as gare",
                        "agents.nom as nom",
                        "agents.prenom as prenom",
                        "agents.photo as photo",
                        "prise_services.date_heure as date_heure",
                        "prise_services.actif as actif",
                        
                        )->orderBy('prise_services.date_heure', 'desc')->get() ;
                }


            // Gare & type Agent
            else if($request->gare != "tous" && $request->agent == "tous" && $request->type_agent != "tous")
                {
                    $liste_prise_services = DB::table("prise_services")
                    ->join("agents", "agents.id", "=", "prise_services.id_agent")
                    ->join("type_agents", "type_agents.id", "=", "agents.type")
                    ->join("gares", "gares.id", "=", "prise_services.id_gare")
                    ->where("prise_services.id_gare", $request->gare)
                    ->where("type_agents.id", $request->type_agent)
                    ->select(
                        "prise_services.id as id",
                        "type_agents.type_agent as type_agent",
                        "gares.gare as gare",
                        "agents.nom as nom",
                        "agents.prenom as prenom",
                        "agents.photo as photo",
                        "prise_services.date_heure as date_heure",
                        "prise_services.actif as actif",
                        
                        )->orderBy('prise_services.date_heure', 'desc')->get() ;
                }


            // Gare &  agent & type Agent
            else if($request->gare != "tous" && $request->agent != "tous" && $request->type_agent != "tous")
                {
                    $liste_prise_services = DB::table("prise_services")
                    ->join("agents", "agents.id", "=", "prise_services.id_agent")
                    ->join("type_agents", "type_agents.id", "=", "agents.type")
                    ->join("gares", "gares.id", "=", "prise_services.id_gare")
                    ->where("prise_services.id_gare", $request->gare)
                    ->where("prise_services.id_agent", $request->agent)
                    ->where("type_agents.id", $request->type_agent)
                    ->select(
                        "prise_services.id as id",
                        "type_agents.type_agent as type_agent",
                        "gares.gare as gare",
                        "agents.nom as nom",
                        "agents.prenom as prenom",
                        "agents.photo as photo",
                        "prise_services.date_heure as date_heure",
                        "prise_services.actif as actif",
                        
                        )->orderBy('prise_services.date_heure', 'desc')->get() ;
                }

            // agent 
            else if($request->gare == "tous" && $request->agent != "tous" && $request->type_agent == "tous")
                {
                    $liste_prise_services = DB::table("prise_services")
                    ->join("agents", "agents.id", "=", "prise_services.id_agent")
                    ->join("type_agents", "type_agents.id", "=", "agents.type")
                    ->join("gares", "gares.id", "=", "prise_services.id_gare")
                    ->where("prise_services.id_agent", $request->agent)
                    ->select(
                        "prise_services.id as id",
                        "type_agents.type_agent as type_agent",
                        "gares.gare as gare",
                        "agents.nom as nom",
                        "agents.prenom as prenom",
                        "agents.photo as photo",
                        "prise_services.date_heure as date_heure",
                        "prise_services.actif as actif",
                        
                        )->orderBy('prise_services.date_heure', 'desc')->get() ;
                }

            // agent  & type Agent
            else if($request->gare == "tous" && $request->agent != "tous" && $request->type_agent != "tous")
                {
                    $liste_prise_services = DB::table("prise_services")
                    ->join("agents", "agents.id", "=", "prise_services.id_agent")
                    ->join("type_agents", "type_agents.id", "=", "agents.type")
                    ->join("gares", "gares.id", "=", "prise_services.id_gare")
                    ->where("prise_services.id_agent", $request->agent)
                    ->where("type_agents.id", $request->type_agent)
                    ->select(
                        "prise_services.id as id",
                        "type_agents.type_agent as type_agent",
                        "gares.gare as gare",
                        "agents.nom as nom",
                        "agents.prenom as prenom",
                        "agents.photo as photo",
                        "prise_services.date_heure as date_heure",
                        "prise_services.actif as actif",
                        
                        )->orderBy('prise_services.date_heure', 'desc')->get() ;
                }

        
            // agent  & type Agent
            else if($request->gare == "tous" && $request->agent == "tous" && $request->type_agent != "tous")
                {
                    $liste_prise_services = DB::table("prise_services")
                    ->join("agents", "agents.id", "=", "prise_services.id_agent")
                    ->join("type_agents", "type_agents.id", "=", "agents.type")
                    ->join("gares", "gares.id", "=", "prise_services.id_gare")
                    ->where("type_agents.id", $request->type_agent)
                    ->select(
                        "prise_services.id as id",
                        "type_agents.type_agent as type_agent",
                        "gares.gare as gare",
                        "agents.nom as nom",
                        "agents.prenom as prenom",
                        "agents.photo as photo",
                        "prise_services.date_heure as date_heure",
                        "prise_services.actif as actif",
                        
                        )->orderBy('prise_services.date_heure', 'desc')->get() ;
                }

            // tous
            else if($request->gare == "tous" && $request->agent == "tous" && $request->type_agent == "tous")
            {
                $liste_prise_services = DB::table("prise_services")
                ->join("agents", "agents.id", "=", "prise_services.id_agent")
                ->join("type_agents", "type_agents.id", "=", "agents.type")
                ->join("gares", "gares.id", "=", "prise_services.id_gare")
                ->select(
                    "prise_services.id as id",
                    "type_agents.type_agent as type_agent",
                    "gares.gare as gare",
                    "agents.nom as nom",
                    "agents.prenom as prenom",
                    "agents.photo as photo",
                    "prise_services.date_heure as date_heure",
                    "prise_services.actif as actif",
                    
                    )->orderBy('prise_services.date_heure', 'desc')->get() ;
            }



        

                foreach($liste_prise_services as $prise_service)
                {
                    
                    $options = '<i class="fa fa-trash  btn-delete-prise-service  icon-lg text-primary" data-id="'.$prise_service->id.'"></i>' ;

                    if($prise_service->actif == 1)
                        {
                            $options =' <i class="fas fa-pencil-alt btn-form-edite-prise-service icon-lg text-warning" data-id="'.$prise_service->id.'">&ensp;</i>
                                        <i class="fa fa-trash  btn-delete-prise-service  icon-lg text-primary" data-id="'.$prise_service->id.'"></i>' ;
                        }
                    $photo = "assets/media/svg/avatars/001-boy.svg";
    
                    if($prise_service->photo != "")
                        {
                            $photo = "../storage/images/agent/$prise_service->photo";
                        }
    
                    $resultat.='<tr id="tr_prise_service'.$prise_service->id.'">

                                            <td class="pr-0">
                                                <div class="symbol symbol-50 symbol-light mt-1">
                                                    <span class="symbol-label">
                                                        <img src="'.$photo.'" class="h-75 align-self-end" alt="" id="td_photo_agent_prise_service'.$prise_service->id.'" width="100%"/>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="pl-0">
                                                <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg" id="td_nom_prise_service'. $prise_service->id .'"> &ensp;&ensp;'.strtoupper($prise_service->nom).'</a>
                                                <span class="text-muted font-weight-bold text-muted d-block" id="td_prenom_prise_service'. $prise_service->id .'"> &ensp;&ensp;'.ucfirst($prise_service->prenom).'</span>
                                            </td>
                                            <td >
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg" id="td_type_agent_prise_service'. $prise_service->id .'">
                                                    '.ucfirst($prise_service->type_agent).'
                                                </span>
                
                                            </td>
                                            <td >
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg" id="td_gare_prise_service'. $prise_service->id .'">
                                                    '.ucfirst($prise_service->gare).'
                                                </span>
                
                                            </td>

                                            <td >
                                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg" id="td_date_heure_prise_service'. $prise_service->id .'">
                                                    '. $prise_service->date_heure .' 
                                                </span>
                
                                            </td>

                                            <td class="pr-0 text-right">
                                                '.$options.'
                                            </td>

                                            
                                            

                                               
                                        </tr>
                            
                    ';
                }



                $reponse_server = array(

                    "resultat" => $resultat,
                    "nombre_prise_service" => count($liste_prise_services),
        
                );
        
            return response()->json($reponse_server) ;
        

        }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reponse_server = "" ;


        // Prise de Service 
        if (prise_service::where('id_agent', $request->agent)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else 
            {
                $prise_service = prise_service::create([
                    "id_agent" => $request->agent,
                    "id_gare" => $request->gare,
                    "date_heure" => $request->date_heure,
                    "actif" => 1,
                ]);





                // Agent
                $agent = DB::table("agents")->where("id", $request->agent)->first() ;

                $photo = "assets/media/svg/avatars/001-boy.svg";

                if($agent->photo != null)
                   {
                       $photo = "../storage/images/agent/$agent->photo";
                   }


                // Type Agent
                $type_agent = DB::table("type_agents")->where("id", $agent->type)->first() ;

                 // Gare
                 $gare = DB::table("gares")->where("id", $request->gare)->first() ;


                $reponse_server = ([
                    "reponse" => "success",
                    "id" => $prise_service->id,
                    "gare" => ucfirst($gare->gare),
                    "type_agent" => ucfirst($type_agent->type_agent), 
                    "nom_agent" => strtoupper($agent->nom),
                    "prenom_agent" => ucfirst($agent->prenom),
                    "date_heure" => $request->date_heure,
                    "photo" => $photo,
                ]) ;

               

            }




            return response()->json($reponse_server) ;

        
    }

    /**
     * Display the specified resource.
     */
    public function show(request $request)
    {
        $prise_service = DB::table("prise_services")
        ->join("gares", "gares.id", "=", "prise_services.id_gare")
        ->join("agents", "agents.id", "=", "prise_services.id_agent")
        ->where("prise_services.id", $request->id)
        ->select(
            "prise_services.id as id",
            "agents.id as id_agent",
            "gares.id as id_gare",
            "prise_services.date_heure as date_heure",
        
             )->first() ;
                $reponse_server = ([
                  "reponse" => "success",
                  "id" => $prise_service->id,
                  "agent" => $prise_service->id_agent,
                  "gare" => $prise_service->id_gare,
                  "date_heure" =>$prise_service->date_heure,
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
        $reponse_server = "" ;


        // Prise de Service 
        if (prise_service::where('id_agent', $request->agent)->where('id', '!=',  $request->id_prise_service )->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else 
            {

                $prise_service = DB::table('prise_services')
                            ->where('id', $request->id_prise_service)
                            ->update([
                                "id_agent" => $request->agent,
                                "id_gare" => $request->gare,
                                "date_heure" => $request->date_heure,
                                ]);
                // Agent
                $agent = DB::table("agents")->where("id", $request->agent)->first() ;

                $photo = "assets/media/svg/avatars/001-boy.svg";

                if($agent->photo != null)
                   {
                       $photo = "../storage/images/agent/$agent->photo";
                   }


                // Type Agent
                $type_agent = DB::table("type_agents")->where("id", $agent->type)->first() ;

                 // Gare
                 $gare = DB::table("gares")->where("id", $request->gare)->first() ;


                $reponse_server = ([
                    "reponse" => "success",
                    "id" => $request->id_prise_service,
                    "gare" => ucfirst($gare->gare),
                    "type_agent" => ucfirst($type_agent->type_agent), 
                    "nom_agent" => strtoupper($agent->nom),
                    "prenom_agent" => ucfirst($agent->prenom),
                    "date_heure" => $request->date_heure,
                    "photo" => $photo,
                ]) ;

               

            }




            return response()->json($reponse_server) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
        {

            DB::table('prise_services')->where('id', $request->id)->delete();

            return response()->json($request->id) ;

        }
}
