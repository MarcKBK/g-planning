<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\agent;

class controllerAgent extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          // Liste des Type Véhicules
          $type_agents = DB::table("type_agents")
          ->where("actif", 1)
          ->get() ;

           // Liste des Véhicules
           $agents = DB::table("agents")
           ->where("actif", 1)
           ->get() ;

            // Liste des Depots
            $depots = DB::table("depots")
            ->where("actif", 1)
            ->get();

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


        return view('pages/agent', compact(

            "type_agents",
            "agents",
            "depots"

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
        $photo = "" ;

        // Matricule
        if (agent::where('matricule', $request->matricule)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "matricule-exist"
                    ]) ;
            }
        // nom & prénom
        else if (agent::where('nom', $request->nom)->where('prenom', $request->prenom)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "nom-prenom-exist"
                    ]) ;
            }

        else
            {


               $agent = agent::create([
                    "type" => $request->type_agent,
                    "nom" => $request->nom,
                    "prenom" => $request->prenom,
                    "matricule" => $request->matricule,
                    "depot" => $request->depot,
                    "actif" => 1,
                ]);


                            $photo = "assets/media/svg/avatars/001-boy.svg";

                             // on verifie qu'un fichier est présent dans la request
                             if($request->hasFile('photo'))
                             {
                                 // on verifie qu'il n'y a eu aucun problème lors du téléchargement du fichier
                                 if($request->file('photo')->isValid())
                                     {
                                         // on recupere l'extension du fichier
                                         $extensionPhoto = strtolower($request->photo->getClientOriginalExtension()) ;

                                         // nom de la photo
                                         $photo = md5(uniqid(rand(), true)).'.'.$extensionPhoto;


                                         // destination du téléchargement de l'photo
                                         $chemin_destination_photo = '..\storage\images\agent';


                                         // on enregistre la photo dans le dossier
                                         $request->photo->move($chemin_destination_photo, $photo);

                                         // on enregistre le nom de la photo dans la base de donné
                                         $photo_agent = DB::table('agents')
                                         ->where('id', $agent->id)
                                         ->update([
                                             'photo' => $photo,
                                             ]);

                                        $photo = "../storage/images/agent/$photo";

                                     }
                             }


                // nom du type de l'Agent
                $type = DB::table("type_agents")->where("id", $request->type_agent)->first() ;

                 // nom du type du Dépot
                 $depot = DB::table("depots")->where("id", $request->depot)->first() ;


                $reponse_server = ([
                    "reponse" => "success",
                    "id" => $agent->id,
                    "type" => $type->type_agent,
                    "nom" =>  $request->nom,
                    "prenom" => ucfirst($request->prenom),
                    "matricule" => $request->matricule,
                    "depot" => $depot->depot,
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
        // detail Agent
        $agent = DB::table("agents")
        ->join("type_agents", "type_agents.id", "=", "agents.type")
        ->join("depots", "depots.id", "=", "agents.depot")
        ->where("agents.id", $request->id)
        ->select(
            "agents.id as id",
            "type_agents.id as id_type",
            "type_agents.type_agent as type",
            "depots.id as id_depot",
            "depots.depot as depot",
            "agents.nom as nom",
            "agents.prenom as prenom",
            "agents.matricule as matricule",
            "agents.photo as photo",

             )->first() ;


             $photo = "assets/media/svg/avatars/001-boy.svg";

             if($agent->photo != null)
                {
                    $photo = "../storage/images/agent/$agent->photo";
                }


             $reponse_server = ([
                "reponse" => "success",
                "id" => $agent->id,
                "id_type" => $agent->id_type,
                "type" => $agent->type,
                "nom" =>  $agent->nom,
                "prenom" => ucfirst($agent->prenom),
                "matricule" => $agent->matricule,
                "id_depot" => $agent->id_depot,
                "depot" => $agent->depot,
                "photo" => $photo,
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
        $photo = "assets/media/svg/avatars/001-boy.svg";

        // Matricule
        if (agent::where('matricule', $request->matricule)->where("id","!=",$request->id_agent)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "matricule-exist"
                    ]) ;
            }
        // nom & prénom
        else if (agent::where('nom', $request->nom)->where('prenom', $request->prenom)->where("id","!=",$request->id_agent)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "nom-prenom-exist"
                    ]) ;
            }
        else
            {
                $agent = DB::table('agents')
                            ->where('id', $request->id_agent)
                            ->update([
                                "type" => $request->type_agent,
                                "nom" => $request->nom,
                                "prenom" => $request->prenom,
                                "matricule" => $request->matricule,
                                "depot" => $request->depot,
                                ]);




                // on verifie qu'un fichier est présent dans la request
                if($request->hasFile('photo'))
                {
                    // on verifie qu'il n'y a eu aucun problème lors du téléchargement du fichier
                    if($request->file('photo')->isValid())
                        {
                            // on recupere l'extension du fichier
                            $extensionPhoto = strtolower($request->photo->getClientOriginalExtension()) ;

                            // nom de la photo
                            $photo = md5(uniqid(rand(), true)).'.'.$extensionPhoto;


                            // destination du téléchargement de l'photo
                            $chemin_destination_photo = '..\storage\images\agent';


                            // on enregistre la photo dans le dossier
                            $request->photo->move($chemin_destination_photo, $photo);

                            // on enregistre le nom de la photo dans la base de donné
                            $photo_agent = DB::table('agents')
                            ->where('id', $request->id_agent)
                            ->update([
                                'photo' => $photo,
                                ]);

                           $photo = "../storage/images/agent/$photo";

                        }
                }



                 // nom du type de l'Agent
                 $type = DB::table("type_agents")->where("id", $request->type_agent)->first() ;

                 // nom du type du Dépot
                 $depot = DB::table("depots")->where("id", $request->depot)->first() ;


                $reponse_server = ([
                    "reponse" => "success",
                    "id" => $request->id_agent,
                    "type" => $type->type_agent,
                    "nom" =>  $request->nom,
                    "prenom" => ucfirst($request->prenom),
                    "matricule" => $request->matricule,
                    "depot" => $depot->depot,
                    "photo" => $photo,
                ]) ;
            }

            return response()->json($reponse_server) ;
    }



    public function search(Request $request)
    {
        $resultat = "" ;
        $liste_agents = "" ;

        if($request->type == "tous" && $request->depot == "tous" && $request->agent != "")
            {
                $liste_agents = DB::table("agents")
                ->join("type_agents", "type_agents.id", "=", "agents.type")
                ->join("depots", "depots.id", "=", "agents.depot")
                ->where('agents.nom', 'like', $request->agent.'%')
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
            }

        // agent  && type
        else if($request->type != "tous" && $request->depot == "tous" && $request->agent != "")
            {
                $liste_agents = DB::table("agents")
                ->join("type_agents", "type_agents.id", "=", "agents.type")
                ->join("depots", "depots.id", "=", "agents.depot")
                ->where('agents.nom', 'like', $request->agent.'%')
                ->where('type_agents.id', $request->type)
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
            }


        // agent  && depot
        else if($request->type == "tous" && $request->depot != "tous" && $request->agent != "")
            {
                $liste_agents = DB::table("agents")
                ->join("type_agents", "type_agents.id", "=", "agents.type")
                ->join("depots", "depots.id", "=", "agents.depot")
                ->where('agents.nom', 'like', $request->agent.'%')
                ->where('type_agents.id', $request->type)
                ->where('depots.id', $request->depot)
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
            }

            // agent  && type && depot
            else if($request->type != "tous" && $request->depot != "tous" && $request->agent != "")
            {
                $liste_agents = DB::table("agents")
                ->join("type_agents", "type_agents.id", "=", "agents.type")
                ->join("depots", "depots.id", "=", "agents.depot")
                ->where('agents.nom', 'like', $request->agent.'%')
                ->where('depots.id', $request->depot)
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
            }

        // type
        else if($request->type != "tous" && $request->depot == "tous" && $request->agent == "")
            {
                $liste_agents = DB::table("agents")
                ->join("type_agents", "type_agents.id", "=", "agents.type")
                ->join("depots", "depots.id", "=", "agents.depot")
                ->where('type_agents.id', $request->type)
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
            }

            // type && depot
            else if($request->type != "tous" && $request->depot != "tous" && $request->agent == "")
            {
                $liste_agents = DB::table("agents")
                ->join("type_agents", "type_agents.id", "=", "agents.type")
                ->join("depots", "depots.id", "=", "agents.depot")
                ->where('type_agents.id', $request->type)
                ->where('depots.id', $request->depot)
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
            }


            // depot
            else if($request->type == "tous" && $request->depot != "tous" && $request->agent == "")
            {
                $liste_agents = DB::table("agents")
                ->join("type_agents", "type_agents.id", "=", "agents.type")
                ->join("depots", "depots.id", "=", "agents.depot")
                ->where('depots.id', $request->depot)
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
            }


        foreach($liste_agents as $agent)
            {

                $photo = "assets/media/svg/avatars/001-boy.svg";

                if($agent->photo != "")
                    {
                        $photo = "../storage/images/agent/$agent->photo";
                    }

                $resultat.='
                        <tr id="tr_agent'.$agent->id.'">
                            <td class="pr-0">
                                <div class="symbol symbol-50 symbol-light mt-1">
                                    <span class="symbol-label">
                                        <img src="'.$photo.'" class="h-75 align-self-end" alt="" id="td_photo_agent'.$agent->id.'" width="100%"/>
                                    </span>
                                </div>
                            </td>
                            <td class="pl-0">
                                <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg" id="td_nom_agent'. $agent->id .'"> &ensp;&ensp;'.strtoupper($agent->nom).'</a>
                                <span class="text-muted font-weight-bold text-muted d-block" id="td_prenom_agent'. $agent->id .'"> &ensp;&ensp;'.ucfirst($agent->prenom).'</span>
                            </td>
                            <td >
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg" id="td_type_agent'. $agent->id .'">
                                    '.ucfirst($agent->type).'
                                </span>

                            </td>
                            <td >
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg" id="td_matricule_agent'. $agent->id .'">
                                    '.$agent->matricule .'
                                </span>
                            </td>
                            <td>
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg" id="td_depot_agent'. $agent->id .'">
                                    '.ucfirst($agent->depot).'
                                </span>
                            </td>
                            <td class="pr-0 text-right">
                                <i class="fas fa-pencil-alt btn-form-edite-agent icon-lg text-warning" data-id="'.$agent->id.'">&ensp;</i>
                                <i class="fa fa-trash  btn-delete-agent  icon-lg text-primary" data-id="'.$agent->id.'"></i>
                            </td>
                        </tr>
                ';
            }

            $reponse_server = array(

                "resultat" => $resultat,
                "nombre_agent" => count($liste_agents),

            );


        return response()->json($reponse_server) ;
    }



    public function destroy(request $request)
    {

        $agent = DB::table('agents')
        ->where('id', $request->id)
        ->update(['actif' => 0]);


        return response()->json($request->id) ;

    }

    /**
     * Remove the specified resource from storage.
     */

}
