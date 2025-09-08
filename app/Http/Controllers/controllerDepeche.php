<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\typeDepeche;
use App\Models\depeche;
use App\Models\agent;

class controllerDepeche extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Liste des Type depeche
        $type_depeches = DB::table("type_depeches")
        ->where("actif", 1)
        ->get() ;

        // Liste des gare
        $liste_gares = DB::table("gares")
        ->where("actif", 1)
        ->get() ;

        // Liste des  types dez vehicules
        $liste_type_vehicules = DB::table("type_vehicules")
        ->where("actif", 1)
        ->get() ;

        // Liste des vehicules
        $liste_vehicules = DB::table("vehicules")
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





          // Liste des dépeches
          $depeches = DB::table("depeches")
        ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
        ->join("gares", "gares.id", "=", "depeches.id_gare")
        ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
        ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
        ->select(
            "depeches.id as id",
            "depeches.date_entree as date_entree",
            "depeches.date_prevue_sortie as date_prevue_sortie",
            "type_depeches.id as type",
            "depeches.actif as actif",
            "type_vehicules.type_vehicule as type_vehicule",
            "gares.gare as gare",
            "vehicules.vehicule as vehicule",
            "type_depeches.type_depeche as type_depeche",
             )->get() ;


        return view('pages/depeche', compact(

            "type_depeches",
            "liste_gares",
            "liste_type_vehicules",
            "liste_vehicules",
            "depeches",
            "agents",
        )) ;


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

        if (depeche::where('id_vehicule', $request->vehicule)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {


                $depeche = depeche::create([
                    "id_type" => $request->type,
                    "id_gare" => $request->gare,
                    "id_vehicule" => $request->vehicule,
                    "id_agent_entree_remis" => $request->agent_depot,
                    "id_agent_entre_recu" => $request->agent_reception,
                    "date_entree" => $request->date_entree,
                    "actif" => 1,
                ]);




                $date_prevue= "Pas de Date";

                 if($request->date_prevue != "")
                    {
                        $depeche = DB::table('depeches')
                        ->where('id', $depeche->id)
                        ->update([
                                    "date_prevue_sortie" => $request->date_prevue,
                                ]);

                        $date_prevue  =  date("d/m/Y", strtotime($request->date_prevue,)) ;
                    }



                // Véhicule
                 $vehicule = DB::table("vehicules")
                ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.type")
                ->where("vehicules.id", $request->vehicule)
                ->select(
                    "type_vehicules.type_vehicule as type_vehicule",
                    "vehicules.vehicule as vehicule",
                    )->first() ;


                //  tyepe Dépeche
                $type_depeche = DB::table("type_depeches")->where("id", $request->type)->first() ;


                 //  Gare
                 $gare = DB::table("gares")->where("id", $request->gare)->first() ;



                $reponse_server = ([
                    "reponse" => "success",
                    "type_vehicule" => ucfirst($vehicule->type_vehicule),
                    "vehicule" => ucfirst($vehicule->vehicule),
                    "type_depeche" => ucfirst($type_depeche->type_depeche),
                    "gare" => ucfirst($gare->gare),
                    "date_entree" => date("d/m/Y", strtotime($request->date_entree,)),
                    "date_prevue_sortie" => $date_prevue,
                ]) ;
            }



            return response()->json($reponse_server) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $depeche = DB::table("depeches")->where("id", $request->id)->first() ;

        $vehicule = DB::table("vehicules")->where("id",$depeche->id_vehicule)->first() ;

        $type_depeche = DB::table("type_depeches")->where("id",$depeche->id_type)->first() ;

        $agent_depot_entree_depeche = DB::table("agents")->where("id",$depeche->id_agent_entree_remis)->first() ;

        $agent_reception_entree_depeche = DB::table("agents")->where("id",$depeche->id_agent_entre_recu)->first() ;

        $agent_depot_sortie_depeche ="" ;

        if (agent::where("id",$depeche->id_agent_sortie_remis)->exists())
            {
                $agent_depot_sortie_depeche = DB::table("agents")->where("id",$depeche->id_agent_sortie_remis)->first() ;
                $agent_depot_sortie_depeche = strtoupper($agent_depot_sortie_depeche->nom).' '.ucfirst($agent_depot_sortie_depeche->prenom);


            }

        $agent_reception_sortie_depeche ="" ;

        if (agent::where("id",$depeche->id_agent_sortie_recu)->exists())
                {
                    $agent_reception_sortie_depeche = DB::table("agents")->where("id",$depeche->id_agent_sortie_recu)->first() ;
                    $agent_reception_sortie_depeche = strtoupper($agent_reception_sortie_depeche->nom).' '.ucfirst($agent_reception_sortie_depeche->prenom);


                }




        $gare = DB::table("gares")->where("id",$depeche->id_gare)->first() ;

                  $reponse_server = ([
                    "reponse" => "success",
                    "id" => $request->id,
                    "id_gare" => $depeche->id_gare,
                    "gare" => ucfirst($gare->gare),
                    "id_type" => $depeche->id_type,
                    "type_depeche" => ucfirst($type_depeche->type_depeche),
                    "id_vehicule" => $depeche->id_vehicule,
                    "vehicule" => ucfirst($vehicule->vehicule),
                    "id_agent_entree_remis" => $depeche->id_agent_entree_remis,
                    "agent_depot_entree_depeche" => strtoupper($agent_depot_entree_depeche->nom).' '.ucfirst($agent_depot_entree_depeche->prenom),
                    "agent_reception_entree_depeche" => strtoupper($agent_reception_entree_depeche->nom).' '.ucfirst($agent_reception_entree_depeche->prenom),

                    "agent_depot_sortie_depeche" => $agent_depot_sortie_depeche ,
                    "agent_reception_sortie_depeche" => $agent_reception_sortie_depeche ,

                    "id_agent_entre_recu" => $depeche->id_agent_entre_recu,
                    "date_entree" => $depeche->date_entree,
                    "date_prevue_sortie" => $depeche->date_prevue_sortie,
                    "date_sortie" => $depeche->date_sortie,
                    "actif" => $depeche->actif,
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

        if (depeche::where('id_vehicule', $request->vehicule)->where('id', '!=', $request->id_depeche)->where('actif', 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {
                $depeche = DB::table('depeches')
                ->where('id', $request->id_depeche)
                ->update([
                            "id_type" => $request->type,
                            "id_gare" => $request->gare,
                            "id_vehicule" => $request->vehicule,
                            "id_agent_entree_remis" => $request->agent_depot,
                            "id_agent_entre_recu" => $request->agent_reception,
                            "date_entree" => $request->date_entree,
                            "date_prevue_sortie" => $request->date_prevue,

                        ]);

                 // infos depeche
                $infos_depeche = DB::table("depeches")
                ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                ->join("gares", "gares.id", "=", "depeches.id_gare")
                ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                ->where("depeches.id", $request->id_depeche)
                ->select(
                    "depeches.id as id",
                    "depeches.date_entree as date_entree",
                    "depeches.date_prevue_sortie as date_prevue_sortie",
                    "type_depeches.id as type",
                    "depeches.actif as actif",
                    "type_vehicules.type_vehicule as type_vehicule",
                    "gares.gare as gare",
                    "vehicules.vehicule as vehicule",
                    "type_depeches.type_depeche as type_depeche",
                    )->first() ;

                    $reponse_server = ([
                        "reponse" => "success",
                        "id" => $infos_depeche->id,
                        "type_vehicule" => ucfirst($infos_depeche->type_vehicule),
                        "vehicule" => ucfirst($infos_depeche->vehicule),
                        "type_depeche" => ucfirst($infos_depeche->type_depeche),
                        "gare" => ucfirst($infos_depeche->gare),
                        "date_entree" => date("d/m/Y", strtotime($infos_depeche->date_entree,)),
                        "date_prevue_sortie" => date("d/m/Y", strtotime($infos_depeche->date_prevue_sortie,)) ,
                        "etat" => "Non Disponible",

                    ]) ;
            }



            return response()->json($reponse_server) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
    {

        DB::table('depeches')->where('id', $request->id)->delete();

        return response()->json($request->id) ;

    }


    public function search(Request $request)
    {
        $resultat = "" ;
        $liste_depeches = "" ;



        //  depeche
        if($request->depeche != "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
            {
                $liste_depeches = DB::table("depeches")
                ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                ->join("gares", "gares.id", "=", "depeches.id_gare")
                ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                ->where("type_depeches.id", $request->depeche)
                ->select(
                    "depeches.id as id",
                    "depeches.date_entree as date_entree",
                    "depeches.date_prevue_sortie as date_prevue_sortie",
                    "type_depeches.id as type",
                    "depeches.actif as actif",
                    "type_vehicules.type_vehicule as type_vehicule",
                    "gares.gare as gare",
                    "vehicules.vehicule as vehicule",
                    "type_depeches.type_depeche as type_depeche",
                     )->get() ;
            }


            //  depeche & Gare
            else if($request->depeche != "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
            {
                $liste_depeches = DB::table("depeches")
                ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                ->join("gares", "gares.id", "=", "depeches.id_gare")
                ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                ->where("type_depeches.id", $request->depeche)
                ->where("gares.id", $request->gare)
                ->select(
                    "depeches.id as id",
                    "depeches.date_entree as date_entree",
                    "depeches.date_prevue_sortie as date_prevue_sortie",
                    "type_depeches.id as type",
                    "depeches.actif as actif",
                    "type_vehicules.type_vehicule as type_vehicule",
                    "gares.gare as gare",
                    "vehicules.vehicule as vehicule",
                    "type_depeches.type_depeche as type_depeche",
                    )->get() ;
            }


                //  depeche & Date Entree
                else if($request->depeche != "tous" &&  $request->gare == "tous" && $request->date_entree != "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
                {
                    $liste_depeches = DB::table("depeches")
                    ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                    ->join("gares", "gares.id", "=", "depeches.id_gare")
                    ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                    ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                    ->where("type_depeches.id", $request->depeche)
                    ->where("depeches.date_entree", $request->date_entree)
                    ->select(
                        "depeches.id as id",
                        "depeches.date_entree as date_entree",
                        "depeches.date_prevue_sortie as date_prevue_sortie",
                        "type_depeches.id as type",
                        "depeches.actif as actif",
                        "type_vehicules.type_vehicule as type_vehicule",
                        "gares.gare as gare",
                        "vehicules.vehicule as vehicule",
                        "type_depeches.type_depeche as type_depeche",
                        )->get() ;
                }



                 //  depeche & Date Sortie
                 else if($request->depeche != "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie != "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
                 {
                     $liste_depeches = DB::table("depeches")
                     ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                     ->join("gares", "gares.id", "=", "depeches.id_gare")
                     ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                     ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                     ->where("type_depeches.id", $request->depeche)
                     ->where("depeches.date_sortie", $request->date_sortie)
                     ->select(
                         "depeches.id as id",
                         "depeches.date_entree as date_entree",
                         "depeches.date_prevue_sortie as date_prevue_sortie",
                         "type_depeches.id as type",
                         "depeches.actif as actif",
                         "type_vehicules.type_vehicule as type_vehicule",
                         "gares.gare as gare",
                         "vehicules.vehicule as vehicule",
                         "type_depeches.type_depeche as type_depeche",
                         )->get() ;
                 }



                  //  depeche & Véhicule
                  else if($request->depeche != "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule != "tous" && $request->type_vehicule == "tous" )
                  {
                      $liste_depeches = DB::table("depeches")
                      ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                      ->join("gares", "gares.id", "=", "depeches.id_gare")
                      ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                      ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                      ->where("type_depeches.id", $request->depeche)
                      ->where("vehicules.id", $request->vehicule)
                      ->select(
                          "depeches.id as id",
                          "depeches.date_entree as date_entree",
                          "depeches.date_prevue_sortie as date_prevue_sortie",
                          "type_depeches.id as type",
                          "depeches.actif as actif",
                          "type_vehicules.type_vehicule as type_vehicule",
                          "gares.gare as gare",
                          "vehicules.vehicule as vehicule",
                          "type_depeches.type_depeche as type_depeche",
                          )->get() ;
                  }



                  //  depeche &  type Véhicule
                  else if($request->depeche != "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule != "tous" )
                  {
                      $liste_depeches = DB::table("depeches")
                      ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                      ->join("gares", "gares.id", "=", "depeches.id_gare")
                      ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                      ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                      ->where("type_depeches.id", $request->depeche)
                      ->where("type_vehicules.id", $request->type_vehicule)
                      ->select(
                          "depeches.id as id",
                          "depeches.date_entree as date_entree",
                          "depeches.date_prevue_sortie as date_prevue_sortie",
                          "type_depeches.id as type",
                          "depeches.actif as actif",
                          "type_vehicules.type_vehicule as type_vehicule",
                          "gares.gare as gare",
                          "vehicules.vehicule as vehicule",
                          "type_depeches.type_depeche as type_depeche",
                          )->get() ;
                  }



                  //  depeche &  Gare &  Date Entree
                  else if($request->depeche != "tous" &&  $request->gare != "tous" && $request->date_entree != "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
                  {
                      $liste_depeches = DB::table("depeches")
                      ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                      ->join("gares", "gares.id", "=", "depeches.id_gare")
                      ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                      ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                      ->where("type_depeches.id", $request->depeche)
                      ->where("gares.id", $request->gare)
                      ->where("depeches.date_entree", $request->date_entree)
                      ->select(
                          "depeches.id as id",
                          "depeches.date_entree as date_entree",
                          "depeches.date_prevue_sortie as date_prevue_sortie",
                          "type_depeches.id as type",
                          "depeches.actif as actif",
                          "type_vehicules.type_vehicule as type_vehicule",
                          "gares.gare as gare",
                          "vehicules.vehicule as vehicule",
                          "type_depeches.type_depeche as type_depeche",
                          )->get() ;
                  }




                  //  depeche &  Gare &  Date Sortie
                  else if($request->depeche != "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie != "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
                  {
                      $liste_depeches = DB::table("depeches")
                      ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                      ->join("gares", "gares.id", "=", "depeches.id_gare")
                      ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                      ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                      ->where("type_depeches.id", $request->depeche)
                      ->where("gares.id", $request->gare)
                      ->where("depeches.date_sortie", $request->date_sortie)
                      ->select(
                          "depeches.id as id",
                          "depeches.date_entree as date_entree",
                          "depeches.date_prevue_sortie as date_prevue_sortie",
                          "type_depeches.id as type",
                          "depeches.actif as actif",
                          "type_vehicules.type_vehicule as type_vehicule",
                          "gares.gare as gare",
                          "vehicules.vehicule as vehicule",
                          "type_depeches.type_depeche as type_depeche",
                          )->get() ;
                  }



                 //  depeche &  Gare &  Véhicule
                 else if($request->depeche != "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule != "tous" && $request->type_vehicule == "tous" )
                 {
                     $liste_depeches = DB::table("depeches")
                     ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                     ->join("gares", "gares.id", "=", "depeches.id_gare")
                     ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                     ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                     ->where("type_depeches.id", $request->depeche)
                     ->where("gares.id", $request->gare)
                     ->where("vehicules.id", $request->vehicule)
                     ->select(
                         "depeches.id as id",
                         "depeches.date_entree as date_entree",
                         "depeches.date_prevue_sortie as date_prevue_sortie",
                         "type_depeches.id as type",
                         "depeches.actif as actif",
                         "type_vehicules.type_vehicule as type_vehicule",
                         "gares.gare as gare",
                         "vehicules.vehicule as vehicule",
                         "type_depeches.type_depeche as type_depeche",
                         )->get() ;
                 }



                  //  depeche &  Gare &   type Véhicule
                  else if($request->depeche != "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule != "tous" )
                  {
                      $liste_depeches = DB::table("depeches")
                      ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                      ->join("gares", "gares.id", "=", "depeches.id_gare")
                      ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                      ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                      ->where("type_depeches.id", $request->depeche)
                      ->where("gares.id", $request->gare)
                      ->where("type_vehicules.id", $request->type_vehicule)
                      ->select(
                          "depeches.id as id",
                          "depeches.date_entree as date_entree",
                          "depeches.date_prevue_sortie as date_prevue_sortie",
                          "type_depeches.id as type",
                          "depeches.actif as actif",
                          "type_vehicules.type_vehicule as type_vehicule",
                          "gares.gare as gare",
                          "vehicules.vehicule as vehicule",
                          "type_depeches.type_depeche as type_depeche",
                          )->get() ;
                  }




                 //  depeche &   Date Entrée & Date Sortie
                 else if($request->depeche != "tous" &&  $request->gare == "tous" && $request->date_entree != "" && $request->date_sortie != "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
                 {
                     $liste_depeches = DB::table("depeches")
                     ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                     ->join("gares", "gares.id", "=", "depeches.id_gare")
                     ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                     ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                     ->where("type_depeches.id", $request->depeche)
                     ->where('depeches.date_entree', '>=', $request->date_entree)
                    ->where('depeches.date_sortie', '<=', $request->date_sortie)
                     ->select(
                         "depeches.id as id",
                         "depeches.date_entree as date_entree",
                         "depeches.date_prevue_sortie as date_prevue_sortie",
                         "type_depeches.id as type",
                         "depeches.actif as actif",
                         "type_vehicules.type_vehicule as type_vehicule",
                         "gares.gare as gare",
                         "vehicules.vehicule as vehicule",
                         "type_depeches.type_depeche as type_depeche",
                         )->get() ;
                 }


                 //  depeche &  Date Entrée & Véhicule
                 else if($request->depeche != "tous" &&  $request->gare == "tous" && $request->date_entree != "" && $request->date_sortie == "" && $request->vehicule != "tous" && $request->type_vehicule == "tous" )
                 {
                     $liste_depeches = DB::table("depeches")
                     ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                     ->join("gares", "gares.id", "=", "depeches.id_gare")
                     ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                     ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                     ->where("type_depeches.id", $request->depeche)
                     ->where('depeches.date_entree', $request->date_entree)
                     ->where('vehicules.id', $request->vehicule)

                     ->select(
                         "depeches.id as id",
                         "depeches.date_entree as date_entree",
                         "depeches.date_prevue_sortie as date_prevue_sortie",
                         "type_depeches.id as type",
                         "depeches.actif as actif",
                         "type_vehicules.type_vehicule as type_vehicule",
                         "gares.gare as gare",
                         "vehicules.vehicule as vehicule",
                         "type_depeches.type_depeche as type_depeche",
                         )->get() ;
                 }


                 //  depeche &  Date Entrée & type  Véhicule
                 else if($request->depeche != "tous" &&  $request->gare == "tous" && $request->date_entree != "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule != "tous" )
                 {
                     $liste_depeches = DB::table("depeches")
                     ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                     ->join("gares", "gares.id", "=", "depeches.id_gare")
                     ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                     ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                     ->where("type_depeches.id", $request->depeche)
                     ->where('depeches.date_entree', $request->date_entree)
                     ->where('type_vehicules.id', $request->type_vehicule)

                     ->select(
                         "depeches.id as id",
                         "depeches.date_entree as date_entree",
                         "depeches.date_prevue_sortie as date_prevue_sortie",
                         "type_depeches.id as type",
                         "depeches.actif as actif",
                         "type_vehicules.type_vehicule as type_vehicule",
                         "gares.gare as gare",
                         "vehicules.vehicule as vehicule",
                         "type_depeches.type_depeche as type_depeche",
                         )->get() ;
                 }



                  //  depeche &  Date sortie & Véhicule
                  else if($request->depeche != "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie != "" && $request->vehicule != "tous" && $request->type_vehicule == "tous" )
                  {
                      $liste_depeches = DB::table("depeches")
                      ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                      ->join("gares", "gares.id", "=", "depeches.id_gare")
                      ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                      ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                      ->where("type_depeches.id", $request->depeche)
                      ->where('depeches.date_sortie', $request->date_sortie)
                      ->where('vehicules.id', $request->vehicule)

                      ->select(
                          "depeches.id as id",
                          "depeches.date_entree as date_entree",
                          "depeches.date_prevue_sortie as date_prevue_sortie",
                          "type_depeches.id as type",
                          "depeches.actif as actif",
                          "type_vehicules.type_vehicule as type_vehicule",
                          "gares.gare as gare",
                          "vehicules.vehicule as vehicule",
                          "type_depeches.type_depeche as type_depeche",
                          )->get() ;
                  }



                  //  depeche &  Date sortie &  type Véhicule
                  else if($request->depeche != "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie != "" && $request->vehicule == "tous" && $request->type_vehicule != "tous" )
                  {
                      $liste_depeches = DB::table("depeches")
                      ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                      ->join("gares", "gares.id", "=", "depeches.id_gare")
                      ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                      ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                      ->where("type_depeches.id", $request->depeche)
                      ->where('depeches.date_sortie', $request->date_sortie)
                      ->where('type_vehicules.id', $request->type_vehicule)

                      ->select(
                          "depeches.id as id",
                          "depeches.date_entree as date_entree",
                          "depeches.date_prevue_sortie as date_prevue_sortie",
                          "type_depeches.id as type",
                          "depeches.actif as actif",
                          "type_vehicules.type_vehicule as type_vehicule",
                          "gares.gare as gare",
                          "vehicules.vehicule as vehicule",
                          "type_depeches.type_depeche as type_depeche",
                          )->get() ;
                  }




                  //  Gare
                  else if($request->depeche == "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
                  {
                      $liste_depeches = DB::table("depeches")
                      ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                      ->join("gares", "gares.id", "=", "depeches.id_gare")
                      ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                      ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                      ->where("gares.id", $request->gare)
                      ->select(
                          "depeches.id as id",
                          "depeches.date_entree as date_entree",
                          "depeches.date_prevue_sortie as date_prevue_sortie",
                          "type_depeches.id as type",
                          "depeches.actif as actif",
                          "type_vehicules.type_vehicule as type_vehicule",
                          "gares.gare as gare",
                          "vehicules.vehicule as vehicule",
                          "type_depeches.type_depeche as type_depeche",
                          )->get() ;
                  }



                   //  Gare &  Date Entrée
                   else if($request->depeche == "tous" &&  $request->gare != "tous" && $request->date_entree != "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
                   {
                       $liste_depeches = DB::table("depeches")
                       ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                       ->join("gares", "gares.id", "=", "depeches.id_gare")
                       ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                       ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                       ->where("gares.id", $request->gare)
                       ->where("depeches.date_entree", $request->date_entree)
                       ->select(
                           "depeches.id as id",
                           "depeches.date_entree as date_entree",
                           "depeches.date_prevue_sortie as date_prevue_sortie",
                           "type_depeches.id as type",
                           "depeches.actif as actif",
                           "type_vehicules.type_vehicule as type_vehicule",
                           "gares.gare as gare",
                           "vehicules.vehicule as vehicule",
                           "type_depeches.type_depeche as type_depeche",
                           )->get() ;
                   }



                    //  Gare &  Date Sortie
                    else if($request->depeche == "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie != "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
                    {
                        $liste_depeches = DB::table("depeches")
                        ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                        ->join("gares", "gares.id", "=", "depeches.id_gare")
                        ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                        ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                        ->where("gares.id", $request->gare)
                        ->where("depeches.date_sortie", $request->date_sortie)
                        ->select(
                            "depeches.id as id",
                            "depeches.date_entree as date_entree",
                            "depeches.date_prevue_sortie as date_prevue_sortie",
                            "type_depeches.id as type",
                            "depeches.actif as actif",
                            "type_vehicules.type_vehicule as type_vehicule",
                            "gares.gare as gare",
                            "vehicules.vehicule as vehicule",
                            "type_depeches.type_depeche as type_depeche",
                            )->get() ;
                    }



            //  Gare &  Véhicule
            else if($request->depeche == "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule != "tous" && $request->type_vehicule == "tous" )
            {
                $liste_depeches = DB::table("depeches")
                ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                ->join("gares", "gares.id", "=", "depeches.id_gare")
                ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                ->where("gares.id", $request->gare)
                ->where("vehicules.id", $request->vehicule)
                ->select(
                    "depeches.id as id",
                    "depeches.date_entree as date_entree",
                    "depeches.date_prevue_sortie as date_prevue_sortie",
                    "type_depeches.id as type",
                    "depeches.actif as actif",
                    "type_vehicules.type_vehicule as type_vehicule",
                    "gares.gare as gare",
                    "vehicules.vehicule as vehicule",
                    "type_depeches.type_depeche as type_depeche",
                    )->get() ;
            }


        //  Gare &  type Véhicule
        else if($request->depeche == "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule != "tous" )
        {
            $liste_depeches = DB::table("depeches")
            ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
            ->join("gares", "gares.id", "=", "depeches.id_gare")
            ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
            ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
            ->where("gares.id", $request->gare)
            ->where("type_vehicules.id", $request->type_vehicule)
            ->select(
                "depeches.id as id",
                "depeches.date_entree as date_entree",
                "depeches.date_prevue_sortie as date_prevue_sortie",
                "type_depeches.id as type",
                "depeches.actif as actif",
                "type_vehicules.type_vehicule as type_vehicule",
                "gares.gare as gare",
                "vehicules.vehicule as vehicule",
                "type_depeches.type_depeche as type_depeche",
                )->get() ;
        }






         //  Gare &  Date Entréee & Date Sortie
         else if($request->depeche == "tous" &&  $request->gare != "tous" && $request->date_entree != "" && $request->date_sortie != "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
         {
             $liste_depeches = DB::table("depeches")
             ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
             ->join("gares", "gares.id", "=", "depeches.id_gare")
             ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
             ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
             ->where("gares.id", $request->gare)
             ->where('depeches.date_entree', '>=', $request->date_entree)
             ->where('depeches.date_sortie', '<=', $request->date_sortie)
             ->select(
                 "depeches.id as id",
                 "depeches.date_entree as date_entree",
                 "depeches.date_prevue_sortie as date_prevue_sortie",
                 "type_depeches.id as type",
                 "depeches.actif as actif",
                 "type_vehicules.type_vehicule as type_vehicule",
                 "gares.gare as gare",
                 "vehicules.vehicule as vehicule",
                 "type_depeches.type_depeche as type_depeche",
                 )->get() ;
         }


         //  Gare &  Date Entréee & Véhicule
         else if($request->depeche == "tous" &&  $request->gare != "tous" && $request->date_entree != "" && $request->date_sortie == "" && $request->vehicule != "tous" && $request->type_vehicule == "tous" )
         {
             $liste_depeches = DB::table("depeches")
             ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
             ->join("gares", "gares.id", "=", "depeches.id_gare")
             ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
             ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
             ->where("gares.id", $request->gare)
             ->where('depeches.date_entree',  $request->date_entree)
             ->where('vehicules.id', $request->vehicule)
             ->select(
                 "depeches.id as id",
                 "depeches.date_entree as date_entree",
                 "depeches.date_prevue_sortie as date_prevue_sortie",
                 "type_depeches.id as type",
                 "depeches.actif as actif",
                 "type_vehicules.type_vehicule as type_vehicule",
                 "gares.gare as gare",
                 "vehicules.vehicule as vehicule",
                 "type_depeches.type_depeche as type_depeche",
                 )->get() ;
         }




          //  Gare &  Date Entréee & type  Véhicule
          else if($request->depeche == "tous" &&  $request->gare != "tous" && $request->date_entree != "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule != "tous" )
          {
              $liste_depeches = DB::table("depeches")
              ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
              ->join("gares", "gares.id", "=", "depeches.id_gare")
              ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
              ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
              ->where("gares.id", $request->gare)
              ->where('depeches.date_entree',  $request->date_entree)
              ->where('type_vehicules.id', $request->type_vehicule)
              ->select(
                  "depeches.id as id",
                  "depeches.date_entree as date_entree",
                  "depeches.date_prevue_sortie as date_prevue_sortie",
                  "type_depeches.id as type",
                  "depeches.actif as actif",
                  "type_vehicules.type_vehicule as type_vehicule",
                  "gares.gare as gare",
                  "vehicules.vehicule as vehicule",
                  "type_depeches.type_depeche as type_depeche",
                  )->get() ;
          }



           //  Gare &  Date Sortie & Véhicule
           else if($request->depeche == "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie != "" && $request->vehicule != "tous" && $request->type_vehicule == "tous" )
           {
               $liste_depeches = DB::table("depeches")
               ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
               ->join("gares", "gares.id", "=", "depeches.id_gare")
               ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
               ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
               ->where("gares.id", $request->gare)
               ->where('depeches.date_sortie',  $request->date_sortie)
               ->where('vehicules.id', $request->vehicule)
               ->select(
                   "depeches.id as id",
                   "depeches.date_entree as date_entree",
                   "depeches.date_prevue_sortie as date_prevue_sortie",
                   "type_depeches.id as type",
                   "depeches.actif as actif",
                   "type_vehicules.type_vehicule as type_vehicule",
                   "gares.gare as gare",
                   "vehicules.vehicule as vehicule",
                   "type_depeches.type_depeche as type_depeche",
                   )->get() ;
           }


            //  Gare &  Date Sortie & type  Véhicule
            else if($request->depeche == "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie != "" && $request->vehicule == "tous" && $request->type_vehicule != "tous" )
            {
                $liste_depeches = DB::table("depeches")
                ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                ->join("gares", "gares.id", "=", "depeches.id_gare")
                ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                ->where("gares.id", $request->gare)
                ->where('depeches.date_sortie',  $request->date_sortie)
                ->where('type_vehicules.id', $request->type_vehicule)
                ->select(
                    "depeches.id as id",
                    "depeches.date_entree as date_entree",
                    "depeches.date_prevue_sortie as date_prevue_sortie",
                    "type_depeches.id as type",
                    "depeches.actif as actif",
                    "type_vehicules.type_vehicule as type_vehicule",
                    "gares.gare as gare",
                    "vehicules.vehicule as vehicule",
                    "type_depeches.type_depeche as type_depeche",
                    )->get() ;
            }



             //  Gare &  Date Sortie & type  Véhicule
             else if($request->depeche == "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie != "" && $request->vehicule == "tous" && $request->type_vehicule != "tous" )
             {
                 $liste_depeches = DB::table("depeches")
                 ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                 ->join("gares", "gares.id", "=", "depeches.id_gare")
                 ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                 ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                 ->where("gares.id", $request->gare)
                 ->where('depeches.date_sortie',  $request->date_sortie)
                 ->where('type_vehicules.id', $request->type_vehicule)
                 ->select(
                     "depeches.id as id",
                     "depeches.date_entree as date_entree",
                     "depeches.date_prevue_sortie as date_prevue_sortie",
                     "type_depeches.id as type",
                     "depeches.actif as actif",
                     "type_vehicules.type_vehicule as type_vehicule",
                     "gares.gare as gare",
                     "vehicules.vehicule as vehicule",
                     "type_depeches.type_depeche as type_depeche",
                     )->get() ;
             }



             //  Date Entrée
             else if($request->depeche == "tous" &&  $request->gare == "tous" && $request->date_entree != "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
             {
                 $liste_depeches = DB::table("depeches")
                 ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                 ->join("gares", "gares.id", "=", "depeches.id_gare")
                 ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                 ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                 ->where('depeches.date_entree',  $request->date_entree)
                 ->select(
                     "depeches.id as id",
                     "depeches.date_entree as date_entree",
                     "depeches.date_prevue_sortie as date_prevue_sortie",
                     "type_depeches.id as type",
                     "depeches.actif as actif",
                     "type_vehicules.type_vehicule as type_vehicule",
                     "gares.gare as gare",
                     "vehicules.vehicule as vehicule",
                     "type_depeches.type_depeche as type_depeche",
                     )->get() ;
             }


             //  Date Entrée & Date Sortie
             else if($request->depeche == "tous" &&  $request->gare == "tous" && $request->date_entree != "" && $request->date_sortie != "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
             {
                 $liste_depeches = DB::table("depeches")
                 ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                 ->join("gares", "gares.id", "=", "depeches.id_gare")
                 ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                 ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                 ->where('depeches.date_entree', '>=', $request->date_entree)
                 ->where('depeches.date_sortie', '<=', $request->date_sortie)
                 ->select(
                     "depeches.id as id",
                     "depeches.date_entree as date_entree",
                     "depeches.date_prevue_sortie as date_prevue_sortie",
                     "type_depeches.id as type",
                     "depeches.actif as actif",
                     "type_vehicules.type_vehicule as type_vehicule",
                     "gares.gare as gare",
                     "vehicules.vehicule as vehicule",
                     "type_depeches.type_depeche as type_depeche",
                     )->get() ;
             }



             //  Date Entrée & Véhicule
             else if($request->depeche == "tous" &&  $request->gare == "tous" && $request->date_entree != "" && $request->date_sortie == "" && $request->vehicule != "tous" && $request->type_vehicule == "tous" )
             {
                 $liste_depeches = DB::table("depeches")
                 ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                 ->join("gares", "gares.id", "=", "depeches.id_gare")
                 ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                 ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                 ->where('depeches.date_entree', $request->date_entree)
                 ->where('vehicules.id', $request->vehicule)
                 ->select(
                     "depeches.id as id",
                     "depeches.date_entree as date_entree",
                     "depeches.date_prevue_sortie as date_prevue_sortie",
                     "type_depeches.id as type",
                     "depeches.actif as actif",
                     "type_vehicules.type_vehicule as type_vehicule",
                     "gares.gare as gare",
                     "vehicules.vehicule as vehicule",
                     "type_depeches.type_depeche as type_depeche",
                     )->get() ;
             }



             //  Date Entrée &  type Véhicule
             else if($request->depeche == "tous" &&  $request->gare == "tous" && $request->date_entree != "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule != "tous" )
             {
                 $liste_depeches = DB::table("depeches")
                 ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                 ->join("gares", "gares.id", "=", "depeches.id_gare")
                 ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                 ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                 ->where('depeches.date_entree', $request->date_entree)
                 ->where('type_vehicules.id', $request->type_vehicule)
                 ->select(
                     "depeches.id as id",
                     "depeches.date_entree as date_entree",
                     "depeches.date_prevue_sortie as date_prevue_sortie",
                     "type_depeches.id as type",
                     "depeches.actif as actif",
                     "type_vehicules.type_vehicule as type_vehicule",
                     "gares.gare as gare",
                     "vehicules.vehicule as vehicule",
                     "type_depeches.type_depeche as type_depeche",
                     )->get() ;
             }



              //  Date Sortie
              else if($request->depeche == "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie != "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
              {
                  $liste_depeches = DB::table("depeches")
                  ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                  ->join("gares", "gares.id", "=", "depeches.id_gare")
                  ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                  ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                  ->where('depeches.date_sortie', $request->date_sortie)
                  ->select(
                      "depeches.id as id",
                      "depeches.date_entree as date_entree",
                      "depeches.date_prevue_sortie as date_prevue_sortie",
                      "type_depeches.id as type",
                      "depeches.actif as actif",
                      "type_vehicules.type_vehicule as type_vehicule",
                      "gares.gare as gare",
                      "vehicules.vehicule as vehicule",
                      "type_depeches.type_depeche as type_depeche",
                      )->get() ;
              }


               //  Date Sortie $ Véhicule
               else if($request->depeche == "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie != "" && $request->vehicule != "tous" && $request->type_vehicule == "tous" )
               {
                   $liste_depeches = DB::table("depeches")
                   ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                   ->join("gares", "gares.id", "=", "depeches.id_gare")
                   ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                   ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                   ->where('depeches.date_sortie', $request->date_sortie)
                   ->where('vehicules.id', $request->vehicule)
                   ->select(
                       "depeches.id as id",
                       "depeches.date_entree as date_entree",
                       "depeches.date_prevue_sortie as date_prevue_sortie",
                       "type_depeches.id as type",
                       "depeches.actif as actif",
                       "type_vehicules.type_vehicule as type_vehicule",
                       "gares.gare as gare",
                       "vehicules.vehicule as vehicule",
                       "type_depeches.type_depeche as type_depeche",
                       )->get() ;
               }


               //  Date Sortie $ type Véhicule
               else if($request->depeche == "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie != "" && $request->vehicule == "tous" && $request->type_vehicule != "tous" )
               {
                   $liste_depeches = DB::table("depeches")
                   ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                   ->join("gares", "gares.id", "=", "depeches.id_gare")
                   ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                   ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                   ->where('depeches.date_sortie', $request->date_sortie)
                   ->where('type_vehicules.id', $request->type_vehicule)
                   ->select(
                       "depeches.id as id",
                       "depeches.date_entree as date_entree",
                       "depeches.date_prevue_sortie as date_prevue_sortie",
                       "type_depeches.id as type",
                       "depeches.actif as actif",
                       "type_vehicules.type_vehicule as type_vehicule",
                       "gares.gare as gare",
                       "vehicules.vehicule as vehicule",
                       "type_depeches.type_depeche as type_depeche",
                       )->get() ;
               }




               //   Véhicule
               else if($request->depeche == "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule != "tous" && $request->type_vehicule == "tous" )
               {
                   $liste_depeches = DB::table("depeches")
                   ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                   ->join("gares", "gares.id", "=", "depeches.id_gare")
                   ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                   ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                   ->where('vehicules.id', $request->vehicule)
                   ->select(
                       "depeches.id as id",
                       "depeches.date_entree as date_entree",
                       "depeches.date_prevue_sortie as date_prevue_sortie",
                       "type_depeches.id as type",
                       "depeches.actif as actif",
                       "type_vehicules.type_vehicule as type_vehicule",
                       "gares.gare as gare",
                       "vehicules.vehicule as vehicule",
                       "type_depeches.type_depeche as type_depeche",
                       )->get() ;
               }


            //   Véhicule & type Véhicule
            else if($request->depeche == "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule != "tous" && $request->type_vehicule != "tous" )
            {
                $liste_depeches = DB::table("depeches")
                ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                ->join("gares", "gares.id", "=", "depeches.id_gare")
                ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                ->where('vehicules.id', $request->vehicule)
                ->where('type_vehicules.id', $request->type_vehicule)
                ->select(
                    "depeches.id as id",
                    "depeches.date_entree as date_entree",
                    "depeches.date_prevue_sortie as date_prevue_sortie",
                    "type_depeches.id as type",
                    "depeches.actif as actif",
                    "type_vehicules.type_vehicule as type_vehicule",
                    "gares.gare as gare",
                    "vehicules.vehicule as vehicule",
                    "type_depeches.type_depeche as type_depeche",
                    )->get() ;
            }


            //  type Véhicule
            else if($request->depeche == "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule != "tous" )
            {
                $liste_depeches = DB::table("depeches")
                ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                ->join("gares", "gares.id", "=", "depeches.id_gare")
                ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                ->where('type_vehicules.id', $request->type_vehicule)
                ->select(
                    "depeches.id as id",
                    "depeches.date_entree as date_entree",
                    "depeches.date_prevue_sortie as date_prevue_sortie",
                    "type_depeches.id as type",
                    "depeches.actif as actif",
                    "type_vehicules.type_vehicule as type_vehicule",
                    "gares.gare as gare",
                    "vehicules.vehicule as vehicule",
                    "type_depeches.type_depeche as type_depeche",
                    )->get() ;
            }

            //  depeche & gare & date Entrée & Date Sortie & Véhicule & type Véhicule
            else if($request->depeche != "tous" &&  $request->gare != "tous" && $request->date_entree != "" && $request->date_sortie != "" && $request->vehicule != "tous" && $request->type_vehicule != "tous" )
            {
                $liste_depeches = DB::table("depeches")
                ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                ->join("gares", "gares.id", "=", "depeches.id_gare")
                ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                ->where('depeches.id', $request->depeche)
                ->where('gares.id', $request->gare)
                ->where('type_vehicules.id', $request->type_vehicule)
                ->where('vehicules.id', $request->vehicule)
                ->where('depeches.date_entree', '>=', $request->date_entree)
                ->where('depeches.date_sortie', '<=', $request->date_sortie)
                ->select(
                    "depeches.id as id",
                    "depeches.date_entree as date_entree",
                    "depeches.date_prevue_sortie as date_prevue_sortie",
                    "type_depeches.id as type",
                    "depeches.actif as actif",
                    "type_vehicules.type_vehicule as type_vehicule",
                    "gares.gare as gare",
                    "vehicules.vehicule as vehicule",
                    "type_depeches.type_depeche as type_depeche",
                    )->get() ;
            }



            //  depeche & gare & Date Sortie & type Véhicule
            else if($request->depeche != "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie != "" && $request->vehicule == "tous" && $request->type_vehicule != "tous" )
            {
                $liste_depeches = DB::table("depeches")
                ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                ->join("gares", "gares.id", "=", "depeches.id_gare")
                ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                ->where('depeches.id', $request->depeche)
                ->where('gares.id', $request->gare)
                ->where('type_vehicules.id', $request->type_vehicule)
                ->where('depeches.date_sortie', $request->date_sortie)
                ->select(
                    "depeches.id as id",
                    "depeches.date_entree as date_entree",
                    "depeches.date_prevue_sortie as date_prevue_sortie",
                    "type_depeches.id as type",
                    "depeches.actif as actif",
                    "type_vehicules.type_vehicule as type_vehicule",
                    "gares.gare as gare",
                    "vehicules.vehicule as vehicule",
                    "type_depeches.type_depeche as type_depeche",
                    )->get() ;
            }


            //  gare &  Véhicule & type Véhicule
            else if($request->depeche == "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule != "tous" && $request->type_vehicule != "tous" )
            {
                $liste_depeches = DB::table("depeches")
                ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                ->join("gares", "gares.id", "=", "depeches.id_gare")
                ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                ->where('gares.id', $request->gare)
                ->where('type_vehicules.id', $request->type_vehicule)
                ->where('vehicules.id', $request->vehicule)
                ->select(
                    "depeches.id as id",
                    "depeches.date_entree as date_entree",
                    "depeches.date_prevue_sortie as date_prevue_sortie",
                    "type_depeches.id as type",
                    "depeches.actif as actif",
                    "type_vehicules.type_vehicule as type_vehicule",
                    "gares.gare as gare",
                    "vehicules.vehicule as vehicule",
                    "type_depeches.type_depeche as type_depeche",
                    )->get() ;
            }


            //  Depeche & gare &  Véhicule & type Véhicule
            else if($request->depeche != "tous" &&  $request->gare != "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule != "tous" && $request->type_vehicule != "tous" )
            {
                $liste_depeches = DB::table("depeches")
                ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                ->join("gares", "gares.id", "=", "depeches.id_gare")
                ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                ->where('type_depeches.id', $request->depeche)
                ->where('gares.id', $request->gare)
                ->where('type_vehicules.id', $request->type_vehicule)
                ->where('vehicules.id', $request->vehicule)
                ->select(
                    "depeches.id as id",
                    "depeches.date_entree as date_entree",
                    "depeches.date_prevue_sortie as date_prevue_sortie",
                    "type_depeches.id as type",
                    "depeches.actif as actif",
                    "type_vehicules.type_vehicule as type_vehicule",
                    "gares.gare as gare",
                    "vehicules.vehicule as vehicule",
                    "type_depeches.type_depeche as type_depeche",
                    )->get() ;
            }




            //  Depeche &  Véhicule & type Véhicule
            else if($request->depeche != "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule != "tous" && $request->type_vehicule != "tous" )
            {
                $liste_depeches = DB::table("depeches")
                ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                ->join("gares", "gares.id", "=", "depeches.id_gare")
                ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                ->where('type_depeches.id', $request->depeche)
                ->where('type_vehicules.id', $request->type_vehicule)
                ->where('vehicules.id', $request->vehicule)
                ->select(
                    "depeches.id as id",
                    "depeches.date_entree as date_entree",
                    "depeches.date_prevue_sortie as date_prevue_sortie",
                    "type_depeches.id as type",
                    "depeches.actif as actif",
                    "type_vehicules.type_vehicule as type_vehicule",
                    "gares.gare as gare",
                    "vehicules.vehicule as vehicule",
                    "type_depeches.type_depeche as type_depeche",
                    )->get() ;
            }


             //  rien
             else if($request->depeche == "tous" &&  $request->gare == "tous" && $request->date_entree == "" && $request->date_sortie == "" && $request->vehicule == "tous" && $request->type_vehicule == "tous" )
             {
                 $liste_depeches = DB::table("depeches")
                 ->join("type_depeches", "type_depeches.id", "=", "depeches.id_type")
                 ->join("gares", "gares.id", "=", "depeches.id_gare")
                 ->join("vehicules", "vehicules.id", "=", "depeches.id_vehicule")
                 ->join("type_vehicules", "type_vehicules.id", "=", "vehicules.id")
                 ->select(
                     "depeches.id as id",
                     "depeches.date_entree as date_entree",
                     "depeches.date_prevue_sortie as date_prevue_sortie",
                     "type_depeches.id as type",
                     "depeches.actif as actif",
                     "type_vehicules.type_vehicule as type_vehicule",
                     "gares.gare as gare",
                     "vehicules.vehicule as vehicule",
                     "type_depeches.type_depeche as type_depeche",
                     )->get() ;
             }


            foreach($liste_depeches as $depeche)
                {

                    $date_prevue_sortie = "Pas de Date" ;
                    if($depeche->date_prevue_sortie != null){ $date_prevue_sortie = date("d/m/Y", strtotime($depeche->date_prevue_sortie,)) ;}

                    $etat = "Disponible";
                    $coleur_etat = "text-success";
                    if($depeche->actif == 1){ $etat = "Non Disponible" ; $coleur_etat ="text-danger";}


                    $options = '<i class="fas fa-eye-slash text-dark  btn-show-depeche" data-id="'.$depeche->id.'">&ensp;</i>
                                <i class="fa fa-trash  btn-delete-depeche  icon-lg text-primary" data-id="'.$depeche->id.'"></i>' ;
                    if($depeche->actif == 1)
                        {
                            $options ='<i class="fas fa-eye-slash text-dark  btn-show-depeche" data-id="'.$depeche->id.'">&ensp;</i>
                            <i class="fas fa-pencil-alt btn-form-edite-depeche icon-lg text-warning" id="btn_form_edite_depeche'.$depeche->id.'" data-id="'.$depeche->id.'">&ensp;</i>
                            <i class="fas fa-reply  btn-form-sortie-depeche icon-lg text-info" id="btn_form_sortie_depeche'.$depeche->id.'" data-id="'.$depeche->id.'">&ensp;</i>
                            <i class="fa fa-trash  btn-delete-depeche  icon-lg text-primary" data-id="'.$depeche->id.'"></i>' ;
                        }




                    $resultat.='<tr id="tr_depeche'.$depeche->id.'">
                                <td id="td_type_vehicule_depeche'.$depeche->id.'">'. ucfirst($depeche->type_vehicule) .'</td>
                                <td id="td_vehicule_depeche'.$depeche->id.'">'. ucfirst($depeche->vehicule) .'</td>
                                <td id="td_type_depeche'.$depeche->id.'">'. ucfirst($depeche->type_depeche) .'</td>
                                <td id="td_gare_depeche'.$depeche->id.'">'. ucfirst($depeche->gare) .'</td>
                                <td id="td_date_entree_depeche'.$depeche->id.'">'. date("d/m/Y", strtotime($depeche->date_entree,)) .'</td>
                                <td id="td_date_prevue_sortie_depeche'.$depeche->id.'">'.$date_prevue_sortie.'</td>
                                <td id="td_date_etat_depeche'.$depeche->id.'" class="text-left '.$coleur_etat.'">'.$etat.'</td>
                                <td class="text-right">'.$options.'</td>
                            </tr>';

                }







        $reponse_server = array(

            "resultat" => $resultat,
            "nombre_depeche" => count($liste_depeches),

        );

    return response()->json($reponse_server) ;


    }

    public function sortie(Request $request)
    {
        $reponse_server = "" ;

        $depeche = DB::table('depeches')
                ->where('id', $request->id_depeche	)
                ->update([
                            "id_agent_sortie_remis" => $request->agent_sortie,
                            "id_agent_sortie_recu" => $request->agent_reception,
                            "date_sortie" => $request->date_sortie,
                            "actif" => 0,

                        ]);

                        $reponse_server = ([
                            "reponse" => "success",
                            "id" => $request->id_depeche,
                            "etat" => "Disponible",

                        ]) ;




            return response()->json($reponse_server) ;
    }
}
