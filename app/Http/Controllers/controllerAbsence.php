<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\absence;

use Carbon\Carbon;

class controllerAbsence extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          // Liste des Type Absence
          $type_absences = DB::table("type_absences")
          ->where("actif", 1)
          ->get() ;

        // Liste des Type Agents
          $type_agents = DB::table("type_agents")
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


          // Liste des absences
          $absences = DB::table("absences")
        ->join("type_absences", "type_absences.id", "=", "absences.id_type")
        ->join("agents", "agents.id", "=", "absences.id_agent")
        ->where("absences.actif", 1)
        ->select(
            "absences.id as id",
            "type_absences.type_absence as type",
            "absences.date_debut as date_debut",
            "absences.date_fin as date_fin",
            "agents.nom as nom",
            "agents.prenom as prenom",
            "agents.matricule as matricule",
            "agents.photo as photo",

             )->orderBy('agents.nom', 'ASC')->get() ;




             // Liste des Agents en Absence
           $liste_absences = DB::table("agents")
           ->join("type_agents", "type_agents.id", "=", "agents.type")
           ->join("depots", "depots.id", "=", "agents.depot")
           ->join("absences", "absences.id_agent", "=", "agents.id")
           ->join("type_absences", "type_absences.id", "=", "absences.id_type")
           ->where("agents.actif", 1)
           ->where("absences.actif", 1)
           ->select(
               "absences.id as id",
               "type_agents.type_agent as type_agent",
               "depots.depot as depot",
               "agents.nom as nom",
               "agents.prenom as prenom",
               "type_absences.type_absence as type_absence",
               "absences.date_debut as date_debut",
               "absences.date_fin as date_fin",
               "agents.photo as photo",

                )->orderBy('agents.nom', 'ASC')->get() ;


        return view('pages/absence', compact(

            "type_absences",
            "type_agents",
            "absences",
            "agents",
            "depots",
            "liste_absences",

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

        if (absence::where('id_agent', $request->agent)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {
                $absence = absence::create([
                    "id_type" => $request->absence,
                    "id_agent" => $request->agent,
                    "date_debut" => $request->date_debut,
                    "date_fin" => $request->date_fin,
                    "actif" => 1,
                ]);

                //Agent
                $agent = DB::table("agents")->where("id", $request->agent)->first() ;

                $photo = "assets/media/svg/avatars/001-boy.svg";

                if($agent->photo != null)
                   {
                       $photo = "../storage/images/agent/$agent->photo";
                   }


                // type d'Agent
                $type_agent = DB::table("type_agents")->where("id", $agent->type)->first() ;



                 //  Dépot
                 $depot = DB::table("depots")->where("id", $agent->depot)->first() ;

                //  type Absence
                $type_absence= DB::table("type_absences")->where("id", $request->absence)->first() ;

                $reponse_server = ([
                    "reponse" => "success",
                    "id" => $absence->id,
                    "type_agent" => ucfirst($type_agent->type_agent),
                    "nom_agent" => ucfirst($agent->nom),
                    "prenom_agent" => ucfirst($agent->prenom),
                    "depot" => ucfirst($depot->depot),
                    "photo" => $photo,
                    "absence" => ucfirst($type_absence->type_absence),
                    "date_debut" =>$request->date_debut,
                    "date_fin" =>$request->date_fin,
                ]) ;
            }



            return response()->json($reponse_server) ;
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

          $absence = DB::table("agents")
          ->join("type_agents", "type_agents.id", "=", "agents.type")
          ->join("depots", "depots.id", "=", "agents.depot")
          ->join("absences", "absences.id_agent", "=", "agents.id")
          ->join("type_absences", "type_absences.id", "=", "absences.id_type")
          ->where("absences.id", $request->id)
          ->where("agents.actif", 1)
          ->where("absences.actif", 1)
          ->select(
              "absences.id as id",
              "agents.id as id_agent",
              "type_absences.id as id_type_absence",
              "absences.date_debut as date_debut",
              "absences.date_fin as date_fin",

               )->orderBy('agents.nom', 'ASC')->first() ;


                  $reponse_server = ([
                    "reponse" => "success",
                    "id" => $absence->id,
                    "agent" => $absence->id_agent,
                    "type_absence" => $absence->id_type_absence,
                    "date_debut" =>$absence->date_debut,
                    "date_fin" =>$absence->date_fin,
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

        if (absence::where('id_agent', $request->agent)->where('id', "!=", $request->id_absence)->where("actif", 1)->exists())
            {
                $reponse_server = ([
                        "reponse" => "exist"
                    ]) ;
            }
        else
            {
                $absence = DB::table('absences')
                            ->where('id', $request->id_absence)
                            ->update([
                                "id_type" => $request->absence,
                                "id_agent" => $request->agent,
                                "date_debut" => $request->date_debut,
                                "date_fin" => $request->date_fin,
                                ]);



                //Agent
                $agent = DB::table("agents")->where("id", $request->agent)->first() ;

                $photo = "assets/media/svg/avatars/001-boy.svg";

                if($agent->photo != null)
                   {
                       $photo = "../storage/images/agent/$agent->photo";
                   }


                // type d'Agent
                $type_agent = DB::table("type_agents")->where("id", $agent->type)->first() ;



                 //  Dépot
                 $depot = DB::table("depots")->where("id", $agent->depot)->first() ;

                //  type Absence
                $type_absence= DB::table("type_absences")->where("id", $request->absence)->first() ;

                $reponse_server = ([
                    "reponse" => "success",
                    "id" => $request->id_absence,
                    "type_agent" => ucfirst($type_agent->type_agent),
                    "nom_agent" => strtoupper($agent->nom),
                    "prenom_agent" => ucfirst($agent->prenom),
                    "depot" => ucfirst($depot->depot),
                    "photo" => $photo,
                    "absence" => ucfirst($type_absence->type_absence),
                    "date_debut" =>$request->date_debut,
                    "date_fin" =>$request->date_fin,
                ]) ;
            }

            return response()->json($reponse_server) ;

    }


    public function search(Request $request)
    {
        $resultat = "" ;
        $liste_absences = "" ;


        // formation
        if($request->absence != "tous" && $request->depot == "tous" && $request->date_debut == "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent == "tous")
            {
                // formation
                $liste_absences = DB::table("agents")
                ->join("type_agents", "type_agents.id", "=", "agents.type")
                ->join("depots", "depots.id", "=", "agents.depot")
                ->join("absences", "absences.id_agent", "=", "agents.id")
                ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                ->where("type_absences.id", $request->absence)
                ->where("agents.actif", 1)
                ->where("absences.actif", 1)
                ->select(
                    "absences.id as id",
                    "type_agents.type_agent as type_agent",
                    "depots.depot as depot",
                    "agents.nom as nom",
                    "agents.prenom as prenom",
                    "type_absences.type_absence as type_absence",
                    "absences.date_debut as date_debut",
                    "absences.date_fin as date_fin",
                    "agents.photo as photo",

                        )->orderBy('agents.nom', 'ASC')->get() ;
            }


        // formation & Dépot
       else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut == "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent == "tous")
        {
            // formation
            $liste_absences = DB::table("agents")
            ->join("type_agents", "type_agents.id", "=", "agents.type")
            ->join("depots", "depots.id", "=", "agents.depot")
            ->join("absences", "absences.id_agent", "=", "agents.id")
            ->join("type_absences", "type_absences.id", "=", "absences.id_type")
            ->where("type_absences.id", $request->absence)
            ->where("depots.id", $request->depot)
            ->where("agents.actif", 1)
            ->where("absences.actif", 1)
            ->select(
                "absences.id as id",
                "type_agents.type_agent as type_agent",
                "depots.depot as depot",
                "agents.nom as nom",
                "agents.prenom as prenom",
                "type_absences.type_absence as type_absence",
                "absences.date_debut as date_debut",
                "absences.date_fin as date_fin",
                "agents.photo as photo",

                    )->orderBy('agents.nom', 'ASC')->get() ;
        }


        // formation & date debut
       else if($request->absence != "tous" && $request->depot == "tous" && $request->date_debut != "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent == "tous")
       {
           // formation
           $liste_absences = DB::table("agents")
           ->join("type_agents", "type_agents.id", "=", "agents.type")
           ->join("depots", "depots.id", "=", "agents.depot")
           ->join("absences", "absences.id_agent", "=", "agents.id")
           ->join("type_absences", "type_absences.id", "=", "absences.id_type")
           ->where("type_absences.id", $request->absence)
           ->where('absences.date_debut', $request->date_debut)
           ->where("agents.actif", 1)
           ->where("absences.actif", 1)
           ->select(
               "absences.id as id",
               "type_agents.type_agent as type_agent",
               "depots.depot as depot",
               "agents.nom as nom",
               "agents.prenom as prenom",
               "type_absences.type_absence as type_absence",
               "absences.date_debut as date_debut",
               "absences.date_fin as date_fin",
               "agents.photo as photo",

                   )->orderBy('agents.nom', 'ASC')->get() ;
       }


         // formation & date fin
         else if($request->absence != "tous" && $request->depot == "tous" && $request->date_debut == "" && $request->date_fin != "" && $request->agent == "tous" && $request->type_agent == "tous")
         {
             // formation
             $liste_absences = DB::table("agents")
             ->join("type_agents", "type_agents.id", "=", "agents.type")
             ->join("depots", "depots.id", "=", "agents.depot")
             ->join("absences", "absences.id_agent", "=", "agents.id")
             ->join("type_absences", "type_absences.id", "=", "absences.id_type")
             ->where("type_absences.id", $request->absence)
             ->where('absences.date_fin', $request->date_fin)
             ->where("agents.actif", 1)
             ->where("absences.actif", 1)
             ->select(
                 "absences.id as id",
                 "type_agents.type_agent as type_agent",
                 "depots.depot as depot",
                 "agents.nom as nom",
                 "agents.prenom as prenom",
                 "type_absences.type_absence as type_absence",
                 "absences.date_debut as date_debut",
                 "absences.date_fin as date_fin",
                 "agents.photo as photo",

                     )->orderBy('agents.nom', 'ASC')->get() ;
         }

    // formation & agent
    else if($request->absence != "tous" && $request->depot == "tous" && $request->date_debut == "" && $request->date_fin == "" && $request->agent != "tous" && $request->type_agent == "tous")
    {
        // formation
        $liste_absences = DB::table("agents")
        ->join("type_agents", "type_agents.id", "=", "agents.type")
        ->join("depots", "depots.id", "=", "agents.depot")
        ->join("absences", "absences.id_agent", "=", "agents.id")
        ->join("type_absences", "type_absences.id", "=", "absences.id_type")
        ->where("type_absences.id", $request->absence)
        ->where('agents.id', $request->agent)
        ->where("agents.actif", 1)
        ->where("absences.actif", 1)
        ->select(
            "absences.id as id",
            "type_agents.type_agent as type_agent",
            "depots.depot as depot",
            "agents.nom as nom",
            "agents.prenom as prenom",
            "type_absences.type_absence as type_absence",
            "absences.date_debut as date_debut",
            "absences.date_fin as date_fin",
            "agents.photo as photo",

                )->orderBy('agents.nom', 'ASC')->get() ;
    }


    // formation & tyep agent
    else if($request->absence != "tous" && $request->depot == "tous" && $request->date_debut == "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent != "tous")
    {
        // formation
        $liste_absences = DB::table("agents")
        ->join("type_agents", "type_agents.id", "=", "agents.type")
        ->join("depots", "depots.id", "=", "agents.depot")
        ->join("absences", "absences.id_agent", "=", "agents.id")
        ->join("type_absences", "type_absences.id", "=", "absences.id_type")
        ->where("type_absences.id", $request->absence)
        ->where('type_agents.id', $request->type_agent)
        ->where("agents.actif", 1)
        ->where("absences.actif", 1)
        ->select(
            "absences.id as id",
            "type_agents.type_agent as type_agent",
            "depots.depot as depot",
            "agents.nom as nom",
            "agents.prenom as prenom",
            "type_absences.type_absence as type_absence",
            "absences.date_debut as date_debut",
            "absences.date_fin as date_fin",
            "agents.photo as photo",

                )->orderBy('agents.nom', 'ASC')->get() ;
    }



    // formation & Dépot & Date debut
    else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent == "tous")
    {
        // formation
        $liste_absences = DB::table("agents")
        ->join("type_agents", "type_agents.id", "=", "agents.type")
        ->join("depots", "depots.id", "=", "agents.depot")
        ->join("absences", "absences.id_agent", "=", "agents.id")
        ->join("type_absences", "type_absences.id", "=", "absences.id_type")
        ->where("type_absences.id", $request->absence)
        ->where("depots.id", $request->depot)
       ->where('absences.date_debut', $request->date_debut)
        ->where("agents.actif", 1)
        ->where("absences.actif", 1)
        ->select(
            "absences.id as id",
            "type_agents.type_agent as type_agent",
            "depots.depot as depot",
            "agents.nom as nom",
            "agents.prenom as prenom",
            "type_absences.type_absence as type_absence",
            "absences.date_debut as date_debut",
            "absences.date_fin as date_fin",
            "agents.photo as photo",

                )->orderBy('agents.nom', 'ASC')->get() ;
    }


        // formation & Dépot & Date fin
        else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut == "" && $request->date_fin != "" && $request->agent == "tous" && $request->type_agent == "tous")
        {
            // formation
            $liste_absences = DB::table("agents")
            ->join("type_agents", "type_agents.id", "=", "agents.type")
            ->join("depots", "depots.id", "=", "agents.depot")
            ->join("absences", "absences.id_agent", "=", "agents.id")
            ->join("type_absences", "type_absences.id", "=", "absences.id_type")
            ->where("type_absences.id", $request->absence)
            ->where("depots.id", $request->depot)
        ->where('absences.date_fin', $request->date_fin)
            ->where("agents.actif", 1)
            ->where("absences.actif", 1)
            ->select(
                "absences.id as id",
                "type_agents.type_agent as type_agent",
                "depots.depot as depot",
                "agents.nom as nom",
                "agents.prenom as prenom",
                "type_absences.type_absence as type_absence",
                "absences.date_debut as date_debut",
                "absences.date_fin as date_fin",
                "agents.photo as photo",

                    )->orderBy('agents.nom', 'ASC')->get() ;
        }




        // formation & Dépot & Agent
        else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut == "" && $request->date_fin == "" && $request->agent != "tous" && $request->type_agent == "tous")
        {
            // formation
            $liste_absences = DB::table("agents")
            ->join("type_agents", "type_agents.id", "=", "agents.type")
            ->join("depots", "depots.id", "=", "agents.depot")
            ->join("absences", "absences.id_agent", "=", "agents.id")
            ->join("type_absences", "type_absences.id", "=", "absences.id_type")
            ->where("type_absences.id", $request->absence)
            ->where("depots.id", $request->depot)
            ->where('agents.id', $request->agent)
            ->where("agents.actif", 1)
            ->where("absences.actif", 1)
            ->select(
                "absences.id as id",
                "type_agents.type_agent as type_agent",
                "depots.depot as depot",
                "agents.nom as nom",
                "agents.prenom as prenom",
                "type_absences.type_absence as type_absence",
                "absences.date_debut as date_debut",
                "absences.date_fin as date_fin",
                "agents.photo as photo",

                    )->orderBy('agents.nom', 'ASC')->get() ;
        }



        // formation & Dépot & type Agent
        else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut == "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent != "tous")
        {
            // formation
            $liste_absences = DB::table("agents")
            ->join("type_agents", "type_agents.id", "=", "agents.type")
            ->join("depots", "depots.id", "=", "agents.depot")
            ->join("absences", "absences.id_agent", "=", "agents.id")
            ->join("type_absences", "type_absences.id", "=", "absences.id_type")
            ->where("type_absences.id", $request->absence)
            ->where("depots.id", $request->depot)
            ->where('type_agents.id', $request->type_agent)
            ->where("agents.actif", 1)
            ->where("absences.actif", 1)
            ->select(
                "absences.id as id",
                "type_agents.type_agent as type_agent",
                "depots.depot as depot",
                "agents.nom as nom",
                "agents.prenom as prenom",
                "type_absences.type_absence as type_absence",
                "absences.date_debut as date_debut",
                "absences.date_fin as date_fin",
                "agents.photo as photo",

                    )->orderBy('agents.nom', 'ASC')->get() ;
        }




        // formation & Dépot & date debut & date fin
        else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin != "" && $request->agent == "tous" && $request->type_agent == "tous")
        {
            // formation

            $liste_absences = DB::table("agents")
            ->join("type_agents", "type_agents.id", "=", "agents.type")
            ->join("depots", "depots.id", "=", "agents.depot")
            ->join("absences", "absences.id_agent", "=", "agents.id")
            ->join("type_absences", "type_absences.id", "=", "absences.id_type")
            ->where("type_absences.id", $request->absence)
            ->where("depots.id", $request->depot)
            ->where('absences.date_debut', '>=', $request->date_debut)
            ->where('absences.date_fin', '>=', $request->date_fin)
            ->where("agents.actif", 1)
            ->where("absences.actif", 1)
            ->select(
                "absences.id as id",
                "type_agents.type_agent as type_agent",
                "depots.depot as depot",
                "agents.nom as nom",
                "agents.prenom as prenom",
                "type_absences.type_absence as type_absence",
                "absences.date_debut as date_debut",
                "absences.date_fin as date_fin",
                "agents.photo as photo",

                    )->orderBy('agents.nom', 'ASC')->get() ;
        }




         // formation & Dépot & date debut & Agent
         else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin == "" && $request->agent != "tous" && $request->type_agent == "tous")
         {
             // formation

             $liste_absences = DB::table("agents")
             ->join("type_agents", "type_agents.id", "=", "agents.type")
             ->join("depots", "depots.id", "=", "agents.depot")
             ->join("absences", "absences.id_agent", "=", "agents.id")
             ->join("type_absences", "type_absences.id", "=", "absences.id_type")
             ->where("type_absences.id", $request->absence)
             ->where("depots.id", $request->depot)
             ->where('absences.date_debut', '>=', $request->date_debut)
             ->where('agents.id', $request->agent)
             ->where("agents.actif", 1)
             ->where("absences.actif", 1)
             ->select(
                 "absences.id as id",
                 "type_agents.type_agent as type_agent",
                 "depots.depot as depot",
                 "agents.nom as nom",
                 "agents.prenom as prenom",
                 "type_absences.type_absence as type_absence",
                 "absences.date_debut as date_debut",
                 "absences.date_fin as date_fin",
                 "agents.photo as photo",

                     )->orderBy('agents.nom', 'ASC')->get() ;
         }


         // formation & Dépot & date debut &  type Agent
         else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent != "tous")
         {

             $liste_absences = DB::table("agents")
             ->join("type_agents", "type_agents.id", "=", "agents.type")
             ->join("depots", "depots.id", "=", "agents.depot")
             ->join("absences", "absences.id_agent", "=", "agents.id")
             ->join("type_absences", "type_absences.id", "=", "absences.id_type")
             ->where("type_absences.id", $request->absence)
             ->where("depots.id", $request->depot)
             ->where('absences.date_debut', $request->date_debut)
             ->where('type_agents.id', $request->type_agent)
             ->where("agents.actif", 1)
             ->where("absences.actif", 1)
             ->select(
                 "absences.id as id",
                 "type_agents.type_agent as type_agent",
                 "depots.depot as depot",
                 "agents.nom as nom",
                 "agents.prenom as prenom",
                 "type_absences.type_absence as type_absence",
                 "absences.date_debut as date_debut",
                 "absences.date_fin as date_fin",
                 "agents.photo as photo",

                     )->orderBy('agents.nom', 'ASC')->get() ;
         }




         // formation & Dépot & date debut & date fin & agent
        else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin != "" && $request->agent != "tous" && $request->type_agent == "tous")
        {
            // formation

            $liste_absences = DB::table("agents")
            ->join("type_agents", "type_agents.id", "=", "agents.type")
            ->join("depots", "depots.id", "=", "agents.depot")
            ->join("absences", "absences.id_agent", "=", "agents.id")
            ->join("type_absences", "type_absences.id", "=", "absences.id_type")
            ->where("type_absences.id", $request->absence)
            ->where("depots.id", $request->depot)
            ->where('absences.date_debut', '>=', $request->date_debut)
            ->where('absences.date_fin', '>=', $request->date_fin)
            ->where('agents.id', $request->agent)
            ->where("agents.actif", 1)
            ->where("absences.actif", 1)
            ->select(
                "absences.id as id",
                "type_agents.type_agent as type_agent",
                "depots.depot as depot",
                "agents.nom as nom",
                "agents.prenom as prenom",
                "type_absences.type_absence as type_absence",
                "absences.date_debut as date_debut",
                "absences.date_fin as date_fin",
                "agents.photo as photo",

                    )->orderBy('agents.nom', 'ASC')->get() ;
        }



         // formation & Dépot & date debut & date fin & type agent $ agent
         else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin != "" && $request->agent != "tous" && $request->type_agent != "tous")
         {

             $liste_absences = DB::table("agents")
             ->join("type_agents", "type_agents.id", "=", "agents.type")
             ->join("depots", "depots.id", "=", "agents.depot")
             ->join("absences", "absences.id_agent", "=", "agents.id")
             ->join("type_absences", "type_absences.id", "=", "absences.id_type")
             ->where("type_absences.id", $request->absence)
             ->where("depots.id", $request->depot)
             ->where('absences.date_debut', '>=', $request->date_debut)
             ->where('absences.date_fin', '>=', $request->date_fin)
             ->where('type_agents.id', $request->type_agent)
             ->where('agents.id', $request->agent)
             ->where("agents.actif", 1)
             ->where("absences.actif", 1)
             ->select(
                 "absences.id as id",
                 "type_agents.type_agent as type_agent",
                 "depots.depot as depot",
                 "agents.nom as nom",
                 "agents.prenom as prenom",
                 "type_absences.type_absence as type_absence",
                 "absences.date_debut as date_debut",
                 "absences.date_fin as date_fin",
                 "agents.photo as photo",

                     )->orderBy('agents.nom', 'ASC')->get() ;
         }




          // Dépot
          else if($request->absence == "tous" && $request->depot != "tous" && $request->date_debut == "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent == "tous")
          {
              // formation

              $liste_absences = DB::table("agents")
              ->join("type_agents", "type_agents.id", "=", "agents.type")
              ->join("depots", "depots.id", "=", "agents.depot")
              ->join("absences", "absences.id_agent", "=", "agents.id")
              ->join("type_absences", "type_absences.id", "=", "absences.id_type")
              ->where("depots.id", $request->depot)
              ->where("agents.actif", 1)
              ->where("absences.actif", 1)
              ->select(
                  "absences.id as id",
                  "type_agents.type_agent as type_agent",
                  "depots.depot as depot",
                  "agents.nom as nom",
                  "agents.prenom as prenom",
                  "type_absences.type_absence as type_absence",
                  "absences.date_debut as date_debut",
                  "absences.date_fin as date_fin",
                  "agents.photo as photo",

                      )->orderBy('agents.nom', 'ASC')->get() ;
          }


          //  Depot & Date debut
          else if($request->absence == "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent == "tous")
          {


              $liste_absences = DB::table("agents")
              ->join("type_agents", "type_agents.id", "=", "agents.type")
              ->join("depots", "depots.id", "=", "agents.depot")
              ->join("absences", "absences.id_agent", "=", "agents.id")
              ->join("type_absences", "type_absences.id", "=", "absences.id_type")
              ->where("depots.id", $request->depot)
              ->where('absences.date_debut', $request->date_debut)
              ->where("agents.actif", 1)
              ->where("absences.actif", 1)
              ->select(
                  "absences.id as id",
                  "type_agents.type_agent as type_agent",
                  "depots.depot as depot",
                  "agents.nom as nom",
                  "agents.prenom as prenom",
                  "type_absences.type_absence as type_absence",
                  "absences.date_debut as date_debut",
                  "absences.date_fin as date_fin",
                  "agents.photo as photo",

                      )->orderBy('agents.nom', 'ASC')->get() ;
          }




          //  Depot & Date fin
          else if($request->absence == "tous" && $request->depot != "tous" && $request->date_debut == "" && $request->date_fin != "" && $request->agent == "tous" && $request->type_agent == "tous")
          {


              $liste_absences = DB::table("agents")
              ->join("type_agents", "type_agents.id", "=", "agents.type")
              ->join("depots", "depots.id", "=", "agents.depot")
              ->join("absences", "absences.id_agent", "=", "agents.id")
              ->join("type_absences", "type_absences.id", "=", "absences.id_type")
              ->where("depots.id", $request->depot)
              ->where('absences.date_fin', $request->date_fin)
              ->where("agents.actif", 1)
              ->where("absences.actif", 1)
              ->select(
                  "absences.id as id",
                  "type_agents.type_agent as type_agent",
                  "depots.depot as depot",
                  "agents.nom as nom",
                  "agents.prenom as prenom",
                  "type_absences.type_absence as type_absence",
                  "absences.date_debut as date_debut",
                  "absences.date_fin as date_fin",
                  "agents.photo as photo",

                      )->orderBy('agents.nom', 'ASC')->get() ;
          }




         // Dépot  & agent
         else if($request->absence == "tous" && $request->depot != "tous" && $request->date_debut == "" && $request->date_fin == "" && $request->agent != "tous" && $request->type_agent == "tous")
         {

             $liste_absences = DB::table("agents")
             ->join("type_agents", "type_agents.id", "=", "agents.type")
             ->join("depots", "depots.id", "=", "agents.depot")
             ->join("absences", "absences.id_agent", "=", "agents.id")
             ->join("type_absences", "type_absences.id", "=", "absences.id_type")
             ->where("depots.id", $request->depot)
             ->where('agents.id', $request->agent)
             ->where("agents.actif", 1)
             ->where("absences.actif", 1)
             ->select(
                 "absences.id as id",
                 "type_agents.type_agent as type_agent",
                 "depots.depot as depot",
                 "agents.nom as nom",
                 "agents.prenom as prenom",
                 "type_absences.type_absence as type_absence",
                 "absences.date_debut as date_debut",
                 "absences.date_fin as date_fin",
                 "agents.photo as photo",

                     )->orderBy('agents.nom', 'ASC')->get() ;
         }


         // Dépot  & tyepe agent
         else if($request->absence == "tous" && $request->depot != "tous" && $request->date_debut == "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent != "tous")
         {

             $liste_absences = DB::table("agents")
             ->join("type_agents", "type_agents.id", "=", "agents.type")
             ->join("depots", "depots.id", "=", "agents.depot")
             ->join("absences", "absences.id_agent", "=", "agents.id")
             ->join("type_absences", "type_absences.id", "=", "absences.id_type")
             ->where("depots.id", $request->depot)
             ->where('type_agents.id', $request->type_agent)
             ->where("agents.actif", 1)
             ->where("absences.actif", 1)
             ->select(
                 "absences.id as id",
                 "type_agents.type_agent as type_agent",
                 "depots.depot as depot",
                 "agents.nom as nom",
                 "agents.prenom as prenom",
                 "type_absences.type_absence as type_absence",
                 "absences.date_debut as date_debut",
                 "absences.date_fin as date_fin",
                 "agents.photo as photo",

                     )->orderBy('agents.nom', 'ASC')->get() ;
         }


          //  Depot & Date debut & Date fin
          else if($request->absence == "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin != "" && $request->agent == "tous" && $request->type_agent == "tous")
          {


              $liste_absences = DB::table("agents")
              ->join("type_agents", "type_agents.id", "=", "agents.type")
              ->join("depots", "depots.id", "=", "agents.depot")
              ->join("absences", "absences.id_agent", "=", "agents.id")
              ->join("type_absences", "type_absences.id", "=", "absences.id_type")
              ->where("depots.id", $request->depot)
              ->where('absences.date_debut', '>=', $request->date_debut)
              ->where('absences.date_fin', '>=', $request->date_fin)
              ->where("agents.actif", 1)
              ->where("absences.actif", 1)
              ->select(
                  "absences.id as id",
                  "type_agents.type_agent as type_agent",
                  "depots.depot as depot",
                  "agents.nom as nom",
                  "agents.prenom as prenom",
                  "type_absences.type_absence as type_absence",
                  "absences.date_debut as date_debut",
                  "absences.date_fin as date_fin",
                  "agents.photo as photo",

                      )->orderBy('agents.nom', 'ASC')->get() ;
          }



           //  Depot & Date debut & Date fin & agent
           else if($request->absence == "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin != "" && $request->agent != "tous" && $request->type_agent == "tous")
           {


               $liste_absences = DB::table("agents")
               ->join("type_agents", "type_agents.id", "=", "agents.type")
               ->join("depots", "depots.id", "=", "agents.depot")
               ->join("absences", "absences.id_agent", "=", "agents.id")
               ->join("type_absences", "type_absences.id", "=", "absences.id_type")
               ->where("depots.id", $request->depot)
               ->where('absences.date_debut', '>=', $request->date_debut)
               ->where('absences.date_fin', '>=', $request->date_fin)
               ->where('agents.id', $request->agent)
               ->where("agents.actif", 1)
               ->where("absences.actif", 1)
               ->select(
                   "absences.id as id",
                   "type_agents.type_agent as type_agent",
                   "depots.depot as depot",
                   "agents.nom as nom",
                   "agents.prenom as prenom",
                   "type_absences.type_absence as type_absence",
                   "absences.date_debut as date_debut",
                   "absences.date_fin as date_fin",
                   "agents.photo as photo",

                       )->orderBy('agents.nom', 'ASC')->get() ;
           }




           //  Depot & Date debut & Date fin & tyep agent
           else if($request->absence == "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin != "" && $request->agent == "tous" && $request->type_agent != "tous")
           {


               $liste_absences = DB::table("agents")
               ->join("type_agents", "type_agents.id", "=", "agents.type")
               ->join("depots", "depots.id", "=", "agents.depot")
               ->join("absences", "absences.id_agent", "=", "agents.id")
               ->join("type_absences", "type_absences.id", "=", "absences.id_type")
               ->where("depots.id", $request->depot)
               ->where('absences.date_debut', '>=', $request->date_debut)
               ->where('absences.date_fin', '>=', $request->date_fin)
               ->where('type_agents.id', $request->type_agent)
               ->where("agents.actif", 1)
               ->where("absences.actif", 1)
               ->select(
                   "absences.id as id",
                   "type_agents.type_agent as type_agent",
                   "depots.depot as depot",
                   "agents.nom as nom",
                   "agents.prenom as prenom",
                   "type_absences.type_absence as type_absence",
                   "absences.date_debut as date_debut",
                   "absences.date_fin as date_fin",
                   "agents.photo as photo",

                       )->orderBy('agents.nom', 'ASC')->get() ;
           }



            //  Depot & Date debut & Date fin & agent &tyep agent
            else if($request->absence == "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin != "" && $request->agent != "tous" && $request->type_agent != "tous")
            {


                $liste_absences = DB::table("agents")
                ->join("type_agents", "type_agents.id", "=", "agents.type")
                ->join("depots", "depots.id", "=", "agents.depot")
                ->join("absences", "absences.id_agent", "=", "agents.id")
                ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                ->where("depots.id", $request->depot)
                ->where('absences.date_debut', '>=', $request->date_debut)
                ->where('absences.date_fin', '>=', $request->date_fin)
                ->where('type_agents.id', $request->type_agent)
                ->where('agents.id', $request->agent)
                ->where("agents.actif", 1)
                ->where("absences.actif", 1)
                ->select(
                    "absences.id as id",
                    "type_agents.type_agent as type_agent",
                    "depots.depot as depot",
                    "agents.nom as nom",
                    "agents.prenom as prenom",
                    "type_absences.type_absence as type_absence",
                    "absences.date_debut as date_debut",
                    "absences.date_fin as date_fin",
                    "agents.photo as photo",

                        )->orderBy('agents.nom', 'ASC')->get() ;
            }




            //  Date debut
            else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut != "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent == "tous")
            {


                $liste_absences = DB::table("agents")
                ->join("type_agents", "type_agents.id", "=", "agents.type")
                ->join("depots", "depots.id", "=", "agents.depot")
                ->join("absences", "absences.id_agent", "=", "agents.id")
                ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                ->where('absences.date_debut', $request->date_debut)
                ->where("agents.actif", 1)
                ->where("absences.actif", 1)
                ->select(
                    "absences.id as id",
                    "type_agents.type_agent as type_agent",
                    "depots.depot as depot",
                    "agents.nom as nom",
                    "agents.prenom as prenom",
                    "type_absences.type_absence as type_absence",
                    "absences.date_debut as date_debut",
                    "absences.date_fin as date_fin",
                    "agents.photo as photo",

                        )->orderBy('agents.nom', 'ASC')->get() ;
            }



             // Date debut & Date fin
             else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut != "" && $request->date_fin != "" && $request->agent == "tous" && $request->type_agent == "tous")
             {


                 $liste_absences = DB::table("agents")
                 ->join("type_agents", "type_agents.id", "=", "agents.type")
                 ->join("depots", "depots.id", "=", "agents.depot")
                 ->join("absences", "absences.id_agent", "=", "agents.id")
                 ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                 ->where('absences.date_debut', '>=', $request->date_debut)
                 ->where('absences.date_fin', '>=', $request->date_fin)
                 ->where("agents.actif", 1)
                 ->where("absences.actif", 1)
                 ->select(
                     "absences.id as id",
                     "type_agents.type_agent as type_agent",
                     "depots.depot as depot",
                     "agents.nom as nom",
                     "agents.prenom as prenom",
                     "type_absences.type_absence as type_absence",
                     "absences.date_debut as date_debut",
                     "absences.date_fin as date_fin",
                     "agents.photo as photo",

                         )->orderBy('agents.nom', 'ASC')->get() ;
             }



              // Date debut & Agent
              else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut != "" && $request->date_fin == "" && $request->agent != "tous" && $request->type_agent == "tous")
              {


                  $liste_absences = DB::table("agents")
                  ->join("type_agents", "type_agents.id", "=", "agents.type")
                  ->join("depots", "depots.id", "=", "agents.depot")
                  ->join("absences", "absences.id_agent", "=", "agents.id")
                  ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                  ->where('absences.date_debut', $request->date_debut)
                  ->where('agents.id', $request->agent)
                  ->where("agents.actif", 1)
                  ->where("absences.actif", 1)
                  ->select(
                      "absences.id as id",
                      "type_agents.type_agent as type_agent",
                      "depots.depot as depot",
                      "agents.nom as nom",
                      "agents.prenom as prenom",
                      "type_absences.type_absence as type_absence",
                      "absences.date_debut as date_debut",
                      "absences.date_fin as date_fin",
                      "agents.photo as photo",

                          )->orderBy('agents.nom', 'ASC')->get() ;
              }




               // Date debut & type Agent
               else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut != "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent != "tous")
               {


                   $liste_absences = DB::table("agents")
                   ->join("type_agents", "type_agents.id", "=", "agents.type")
                   ->join("depots", "depots.id", "=", "agents.depot")
                   ->join("absences", "absences.id_agent", "=", "agents.id")
                   ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                   ->where('absences.date_debut', $request->date_debut)
                   ->where('type_agents.id', $request->type_agent)
                   ->where("agents.actif", 1)
                   ->where("absences.actif", 1)
                   ->select(
                       "absences.id as id",
                       "type_agents.type_agent as type_agent",
                       "depots.depot as depot",
                       "agents.nom as nom",
                       "agents.prenom as prenom",
                       "type_absences.type_absence as type_absence",
                       "absences.date_debut as date_debut",
                       "absences.date_fin as date_fin",
                       "agents.photo as photo",

                           )->orderBy('agents.nom', 'ASC')->get() ;
               }


            // Date debut & Date fin & agent
             else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut != "" && $request->date_fin != "" && $request->agent != "tous" && $request->type_agent == "tous")
             {


                 $liste_absences = DB::table("agents")
                 ->join("type_agents", "type_agents.id", "=", "agents.type")
                 ->join("depots", "depots.id", "=", "agents.depot")
                 ->join("absences", "absences.id_agent", "=", "agents.id")
                 ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                 ->where('absences.date_debut', '>=', $request->date_debut)
                 ->where('absences.date_fin', '>=', $request->date_fin)
                 ->where('agents.id', $request->agent)
                 ->where("agents.actif", 1)
                 ->where("absences.actif", 1)
                 ->select(
                     "absences.id as id",
                     "type_agents.type_agent as type_agent",
                     "depots.depot as depot",
                     "agents.nom as nom",
                     "agents.prenom as prenom",
                     "type_absences.type_absence as type_absence",
                     "absences.date_debut as date_debut",
                     "absences.date_fin as date_fin",
                     "agents.photo as photo",

                         )->orderBy('agents.nom', 'ASC')->get() ;
             }




             // Date debut & Date fin & type agent
             else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut != "" && $request->date_fin != "" && $request->agent == "tous" && $request->type_agent != "tous")
             {


                 $liste_absences = DB::table("agents")
                 ->join("type_agents", "type_agents.id", "=", "agents.type")
                 ->join("depots", "depots.id", "=", "agents.depot")
                 ->join("absences", "absences.id_agent", "=", "agents.id")
                 ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                 ->where('absences.date_debut', '>=', $request->date_debut)
                 ->where('absences.date_fin', '>=', $request->date_fin)
                 ->where('type_agents.id', $request->type_agent)
                 ->where("agents.actif", 1)
                 ->where("absences.actif", 1)
                 ->select(
                     "absences.id as id",
                     "type_agents.type_agent as type_agent",
                     "depots.depot as depot",
                     "agents.nom as nom",
                     "agents.prenom as prenom",
                     "type_absences.type_absence as type_absence",
                     "absences.date_debut as date_debut",
                     "absences.date_fin as date_fin",
                     "agents.photo as photo",

                         )->orderBy('agents.nom', 'ASC')->get() ;
             }



             // Date debut & Date fin & type agent
             else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut != "" && $request->date_fin != "" && $request->agent == "tous" && $request->type_agent != "tous")
             {


                 $liste_absences = DB::table("agents")
                 ->join("type_agents", "type_agents.id", "=", "agents.type")
                 ->join("depots", "depots.id", "=", "agents.depot")
                 ->join("absences", "absences.id_agent", "=", "agents.id")
                 ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                 ->where('absences.date_debut', '>=', $request->date_debut)
                 ->where('absences.date_fin', '>=', $request->date_fin)
                 ->where('type_agents.id', $request->type_agent)
                 ->where("agents.actif", 1)
                 ->where("absences.actif", 1)
                 ->select(
                     "absences.id as id",
                     "type_agents.type_agent as type_agent",
                     "depots.depot as depot",
                     "agents.nom as nom",
                     "agents.prenom as prenom",
                     "type_absences.type_absence as type_absence",
                     "absences.date_debut as date_debut",
                     "absences.date_fin as date_fin",
                     "agents.photo as photo",

                         )->orderBy('agents.nom', 'ASC')->get() ;
             }





              // Date fin
              else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut == "" && $request->date_fin != "" && $request->agent == "tous" && $request->type_agent == "tous")
              {


                  $liste_absences = DB::table("agents")
                  ->join("type_agents", "type_agents.id", "=", "agents.type")
                  ->join("depots", "depots.id", "=", "agents.depot")
                  ->join("absences", "absences.id_agent", "=", "agents.id")
                  ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                  ->where('absences.date_fin', $request->date_fin)
                  ->where("agents.actif", 1)
                  ->where("absences.actif", 1)
                  ->select(
                      "absences.id as id",
                      "type_agents.type_agent as type_agent",
                      "depots.depot as depot",
                      "agents.nom as nom",
                      "agents.prenom as prenom",
                      "type_absences.type_absence as type_absence",
                      "absences.date_debut as date_debut",
                      "absences.date_fin as date_fin",
                      "agents.photo as photo",

                          )->orderBy('agents.nom', 'ASC')->get() ;
              }



             // Date fin &  agent
             else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut == "" && $request->date_fin != "" && $request->agent != "tous" && $request->type_agent == "tous")
             {


                 $liste_absences = DB::table("agents")
                 ->join("type_agents", "type_agents.id", "=", "agents.type")
                 ->join("depots", "depots.id", "=", "agents.depot")
                 ->join("absences", "absences.id_agent", "=", "agents.id")
                 ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                 ->where('absences.date_fin', $request->date_fin)
                 ->where('agents.id', $request->agent)
                 ->where("agents.actif", 1)
                 ->where("absences.actif", 1)
                 ->select(
                     "absences.id as id",
                     "type_agents.type_agent as type_agent",
                     "depots.depot as depot",
                     "agents.nom as nom",
                     "agents.prenom as prenom",
                     "type_absences.type_absence as type_absence",
                     "absences.date_debut as date_debut",
                     "absences.date_fin as date_fin",
                     "agents.photo as photo",

                         )->orderBy('agents.nom', 'ASC')->get() ;
             }




              // Date fin &  type agent
              else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut == "" && $request->date_fin != "" && $request->agent == "tous" && $request->type_agent != "tous")
              {


                  $liste_absences = DB::table("agents")
                  ->join("type_agents", "type_agents.id", "=", "agents.type")
                  ->join("depots", "depots.id", "=", "agents.depot")
                  ->join("absences", "absences.id_agent", "=", "agents.id")
                  ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                  ->where('absences.date_fin', $request->date_fin)
                  ->where('type_agents.id', $request->type_agent)
                  ->where("agents.actif", 1)
                  ->where("absences.actif", 1)
                  ->select(
                      "absences.id as id",
                      "type_agents.type_agent as type_agent",
                      "depots.depot as depot",
                      "agents.nom as nom",
                      "agents.prenom as prenom",
                      "type_absences.type_absence as type_absence",
                      "absences.date_debut as date_debut",
                      "absences.date_fin as date_fin",
                      "agents.photo as photo",

                          )->orderBy('agents.nom', 'ASC')->get() ;
              }



               // Date fin &  type agent & agent
               else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut == "" && $request->date_fin != "" && $request->agent != "tous" && $request->type_agent != "tous")
                {


                    $liste_absences = DB::table("agents")
                    ->join("type_agents", "type_agents.id", "=", "agents.type")
                    ->join("depots", "depots.id", "=", "agents.depot")
                    ->join("absences", "absences.id_agent", "=", "agents.id")
                    ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                    ->where('absences.date_fin', $request->date_fin)
                    ->where('type_agents.id', $request->type_agent)
                    ->where('agents.id', $request->agent)
                    ->where("agents.actif", 1)
                    ->where("absences.actif", 1)
                    ->select(
                        "absences.id as id",
                        "type_agents.type_agent as type_agent",
                        "depots.depot as depot",
                        "agents.nom as nom",
                        "agents.prenom as prenom",
                        "type_absences.type_absence as type_absence",
                        "absences.date_debut as date_debut",
                        "absences.date_fin as date_fin",
                        "agents.photo as photo",

                            )->orderBy('agents.nom', 'ASC')->get() ;
                }








                // agent
               else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut == "" && $request->date_fin == "" && $request->agent != "tous" && $request->type_agent == "tous")
               {


                   $liste_absences = DB::table("agents")
                   ->join("type_agents", "type_agents.id", "=", "agents.type")
                   ->join("depots", "depots.id", "=", "agents.depot")
                   ->join("absences", "absences.id_agent", "=", "agents.id")
                   ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                   ->where('agents.id', $request->agent)
                   ->where("agents.actif", 1)
                   ->where("absences.actif", 1)
                   ->select(
                       "absences.id as id",
                       "type_agents.type_agent as type_agent",
                       "depots.depot as depot",
                       "agents.nom as nom",
                       "agents.prenom as prenom",
                       "type_absences.type_absence as type_absence",
                       "absences.date_debut as date_debut",
                       "absences.date_fin as date_fin",
                       "agents.photo as photo",

                           )->orderBy('agents.nom', 'ASC')->get() ;
               }



                // agent & type
                else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut == "" && $request->date_fin == "" && $request->agent != "tous" && $request->type_agent != "tous")
                {


                    $liste_absences = DB::table("agents")
                    ->join("type_agents", "type_agents.id", "=", "agents.type")
                    ->join("depots", "depots.id", "=", "agents.depot")
                    ->join("absences", "absences.id_agent", "=", "agents.id")
                    ->join("type_absences", "type_absences.id", "=", "absences.id_type")
                    ->where('type_agents.id', $request->type_agent)
                    ->where('agents.id', $request->agent)
                    ->where("agents.actif", 1)
                    ->where("absences.actif", 1)
                    ->select(
                        "absences.id as id",
                        "type_agents.type_agent as type_agent",
                        "depots.depot as depot",
                        "agents.nom as nom",
                        "agents.prenom as prenom",
                        "type_absences.type_absence as type_absence",
                        "absences.date_debut as date_debut",
                        "absences.date_fin as date_fin",
                        "agents.photo as photo",

                            )->orderBy('agents.nom', 'ASC')->get() ;
                }

         //type
         else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut == "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent != "tous")
         {


             $liste_absences = DB::table("agents")
             ->join("type_agents", "type_agents.id", "=", "agents.type")
             ->join("depots", "depots.id", "=", "agents.depot")
             ->join("absences", "absences.id_agent", "=", "agents.id")
             ->join("type_absences", "type_absences.id", "=", "absences.id_type")
             ->where('type_agents.id', $request->type_agent)
             ->where("agents.actif", 1)
             ->where("absences.actif", 1)
             ->select(
                 "absences.id as id",
                 "type_agents.type_agent as type_agent",
                 "depots.depot as depot",
                 "agents.nom as nom",
                 "agents.prenom as prenom",
                 "type_absences.type_absence as type_absence",
                 "absences.date_debut as date_debut",
                 "absences.date_fin as date_fin",
                 "agents.photo as photo",

                     )->orderBy('agents.nom', 'ASC')->get() ;
         }



          //tout et vide
          else if($request->absence == "tous" && $request->depot == "tous" && $request->date_debut == "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent == "tous")
          {


              $liste_absences = DB::table("agents")
              ->join("type_agents", "type_agents.id", "=", "agents.type")
              ->join("depots", "depots.id", "=", "agents.depot")
              ->join("absences", "absences.id_agent", "=", "agents.id")
              ->join("type_absences", "type_absences.id", "=", "absences.id_type")
              ->where("agents.actif", 1)
              ->where("absences.actif", 1)
              ->select(
                  "absences.id as id",
                  "type_agents.type_agent as type_agent",
                  "depots.depot as depot",
                  "agents.nom as nom",
                  "agents.prenom as prenom",
                  "type_absences.type_absence as type_absence",
                  "absences.date_debut as date_debut",
                  "absences.date_fin as date_fin",
                  "agents.photo as photo",

                      )->orderBy('agents.nom', 'ASC')->get() ;
          }



          //Depot & date debut & type agent
          else if($request->absence == "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent != "tous")
          {



             $liste_absences = DB::table("agents")
             ->join("type_agents", "type_agents.id", "=", "agents.type")
             ->join("depots", "depots.id", "=", "agents.depot")
             ->join("absences", "absences.id_agent", "=", "agents.id")
             ->join("type_absences", "type_absences.id", "=", "absences.id_type")
             ->where("depots.id", $request->depot)
             ->where('absences.date_debut', $request->date_debut)
             ->where('type_agents.id', $request->type_agent)
             ->where("agents.actif", 1)
             ->where("absences.actif", 1)
             ->select(
                 "absences.id as id",
                 "type_agents.type_agent as type_agent",
                 "depots.depot as depot",
                 "agents.nom as nom",
                 "agents.prenom as prenom",
                 "type_absences.type_absence as type_absence",
                 "absences.date_debut as date_debut",
                 "absences.date_fin as date_fin",
                 "agents.photo as photo",

                     )->orderBy('agents.nom', 'ASC')->get() ;
          }




          //Absence & Depot & date debut & type agent
          else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin == "" && $request->agent == "tous" && $request->type_agent != "tous")
          {



             $liste_absences = DB::table("agents")
             ->join("type_agents", "type_agents.id", "=", "agents.type")
             ->join("depots", "depots.id", "=", "agents.depot")
             ->join("absences", "absences.id_agent", "=", "agents.id")
             ->join("type_absences", "type_absences.id", "=", "absences.id_type")
             ->where("type_absences.id", $request->absence)
             ->where("depots.id", $request->depot)
             ->where('absences.date_debut', $request->date_debut)
             ->where('type_agents.id', $request->type_agent)
             ->where("agents.actif", 1)
             ->where("absences.actif", 1)
             ->select(
                 "absences.id as id",
                 "type_agents.type_agent as type_agent",
                 "depots.depot as depot",
                 "agents.nom as nom",
                 "agents.prenom as prenom",
                 "type_absences.type_absence as type_absence",
                 "absences.date_debut as date_debut",
                 "absences.date_fin as date_fin",
                 "agents.photo as photo",

                     )->orderBy('agents.nom', 'ASC')->get() ;
          }




           //Absence & Depot & date fin & type agent
           else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut == "" && $request->date_fin != "" && $request->agent == "tous" && $request->type_agent != "tous")
           {



              $liste_absences = DB::table("agents")
              ->join("type_agents", "type_agents.id", "=", "agents.type")
              ->join("depots", "depots.id", "=", "agents.depot")
              ->join("absences", "absences.id_agent", "=", "agents.id")
              ->join("type_absences", "type_absences.id", "=", "absences.id_type")
              ->where("type_absences.id", $request->absence)
              ->where("depots.id", $request->depot)
              ->where('absences.date_fin', $request->date_fin)
              ->where('type_agents.id', $request->type_agent)
              ->where("agents.actif", 1)
              ->where("absences.actif", 1)
              ->select(
                  "absences.id as id",
                  "type_agents.type_agent as type_agent",
                  "depots.depot as depot",
                  "agents.nom as nom",
                  "agents.prenom as prenom",
                  "type_absences.type_absence as type_absence",
                  "absences.date_debut as date_debut",
                  "absences.date_fin as date_fin",
                  "agents.photo as photo",

                      )->orderBy('agents.nom', 'ASC')->get() ;
           }



            //Absence & Depot & date fin & type agent & agent
            else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut == "" && $request->date_fin != "" && $request->agent != "tous" && $request->type_agent != "tous")
            {

               $liste_absences = DB::table("agents")
               ->join("type_agents", "type_agents.id", "=", "agents.type")
               ->join("depots", "depots.id", "=", "agents.depot")
               ->join("absences", "absences.id_agent", "=", "agents.id")
               ->join("type_absences", "type_absences.id", "=", "absences.id_type")
               ->where("type_absences.id", $request->absence)
               ->where("depots.id", $request->depot)
               ->where('absences.date_fin', $request->date_fin)
               ->where('type_agents.id', $request->type_agent)
               ->where('agents.id', $request->agent)
               ->where("agents.actif", 1)
               ->where("absences.actif", 1)
               ->select(
                   "absences.id as id",
                   "type_agents.type_agent as type_agent",
                   "depots.depot as depot",
                   "agents.nom as nom",
                   "agents.prenom as prenom",
                   "type_absences.type_absence as type_absence",
                   "absences.date_debut as date_debut",
                   "absences.date_fin as date_fin",
                   "agents.photo as photo",

                       )->orderBy('agents.nom', 'ASC')->get() ;
            }






          //Absence & Depot & date debut & type agent
          else if($request->absence != "tous" && $request->depot != "tous" && $request->date_debut != "" && $request->date_fin != "" && $request->agent == "tous" && $request->type_agent != "tous")
          {



             $liste_absences = DB::table("agents")
             ->join("type_agents", "type_agents.id", "=", "agents.type")
             ->join("depots", "depots.id", "=", "agents.depot")
             ->join("absences", "absences.id_agent", "=", "agents.id")
             ->join("type_absences", "type_absences.id", "=", "absences.id_type")
             ->where("type_absences.id", $request->absence)
             ->where("depots.id", $request->depot)
             ->where('absences.date_debut', '>=', $request->date_debut)
             ->where('absences.date_fin', '>=', $request->date_fin)
             ->where('type_agents.id', $request->type_agent)
             ->where("agents.actif", 1)
             ->where("absences.actif", 1)
             ->select(
                 "absences.id as id",
                 "type_agents.type_agent as type_agent",
                 "depots.depot as depot",
                 "agents.nom as nom",
                 "agents.prenom as prenom",
                 "type_absences.type_absence as type_absence",
                 "absences.date_debut as date_debut",
                 "absences.date_fin as date_fin",
                 "agents.photo as photo",

                     )->orderBy('agents.nom', 'ASC')->get() ;
          }
















            foreach($liste_absences as $absence)
            {

                $photo = "assets/media/svg/avatars/001-boy.svg";

                if($absence->photo != "")
                    {
                        $photo = "../storage/images/agent/$absence->photo";
                    }

                $resultat.='
                        <tr id="tr_absence'.$absence->id.'">
                            <td class="pr-0">
                                <div class="symbol symbol-50 symbol-light mt-1">
                                    <span class="symbol-label">
                                        <img src="'.$photo.'" class="h-75 align-self-end" alt="" id="td_photo_agent_absence'.$absence->id.'" width="100%"/>
                                    </span>
                                </div>
                            </td>
                            <td class="pl-0">
                                <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg" id="td_nom_absence'. $absence->id .'"> &ensp;&ensp;'.strtoupper($absence->nom).'</a>
                                <span class="text-muted font-weight-bold text-muted d-block" id="td_prenom_absence'. $absence->id .'"> &ensp;&ensp;'.ucfirst($absence->prenom).'</span>
                            </td>
                            <td >
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg" id="td_type_agent_absence'. $absence->id .'">
                                    '.ucfirst($absence->type_agent).'
                                </span>

                            </td>
                            <td >
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg" id="td_depot_agent_absence'. $absence->id .'">
                                    '.ucfirst($absence->depot).'
                                </span>
                            </td>
                            <td>
                                <span class="text-dark-75 font-weight-bolder d-block font-size-lg" id="td_type_absence'. $absence->id .'">
                                    '.ucfirst($absence->type_absence).'
                                </span>
                            </td>
                            <td class="pl-0">
                                    <a href="#" class="text-dark-75 font-weight-bolder text-hover-primary mb-1 font-size-lg" id="td_date_debut_absence'. $absence->id .'">&ensp;&ensp;'. date("d/m/Y", strtotime($absence->date_debut,)) .'</a><span class="text-dark-75 font-weight-bolder  d-block" id="td_date_fin_absence'. $absence->id .'">&ensp;&ensp;'. date("d/m/Y", strtotime($absence->date_fin,)) .'</span></td>
                            <td class="pr-0 text-right">
                                <i class="fas fa-pencil-alt btn-form-edite-absence icon-lg text-warning" data-id="'.$absence->id.'">&ensp;</i>
                                <i class="fa fa-trash  btn-delete-absence  icon-lg text-primary" data-id="'.$absence->id.'"></i>
                            </td>
                        </tr>
                ';
            }








            $reponse_server = array(

                "resultat" => $resultat,
                "nombre_absence" => count($liste_absences),

            );

        return response()->json($reponse_server) ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $request)
    {

        $agent = DB::table('absences')
        ->where('id', $request->id)
        ->update(['actif' => 0]);


        return response()->json($request->id) ;

    }
}
