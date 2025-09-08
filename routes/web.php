<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\controllerGare;
use App\Http\Controllers\controllerDepot;
use App\Http\Controllers\controllerVehicule;
use App\Http\Controllers\controllerAgent;
use App\Http\Controllers\controllerTypeAgent;
use App\Http\Controllers\controllerTypeAbsence;
use App\Http\Controllers\controllerParametre;
use App\Http\Controllers\controllerTypeVehicule;
use App\Http\Controllers\controllerAbsence;
use App\Http\Controllers\controllerDepeche;
use App\Http\Controllers\controllerTypeDepeche;
use App\Http\Controllers\controllerPriseService;
use App\Http\Controllers\controllerPlanning;



Route::get('/accueil', function () {
    return view('pages/accueil');
});

Route::get('/', function () {
    return view('pages/login');
});

Route::get('gare', function () {
    return view('pages/gare');
});




//--------------- Parametre ---------------------------
Route::get('/parametre',[controllerParametre::class, 'index']);
//-------------------------------------------------------------

//--------------- Gare ---------------------------
Route::post('/add_gare',[controllerGare::class, 'store']);
Route::post('/delete_gare',[controllerGare::class, 'destroy']);
Route::post('/show_gare',[controllerGare::class, 'show']);
Route::post('/edite_gare',[controllerGare::class, 'update']);
Route::post('/search_gare',[controllerGare::class, 'search']);
//-------------------------------------------------------------
//--------------- Depot --------------------------------------
Route::post('/add_depot',[controllerDepot::class, 'store']);
Route::post('/delete_depot',[controllerDepot::class, 'destroy']);
Route::post('/show_depot',[controllerDepot::class, 'show']);
Route::post('/edite_depot',[controllerDepot::class, 'update']);
Route::post('/search_depot',[controllerDepot::class, 'search']);
//-------------------------------------------------------------
//--------------- Véhicule ---------------------------
Route::get('/vehicule',[controllerVehicule::class, 'index']);
Route::post('/add_vehicule',[controllerVehicule::class, 'store']);
Route::post('/delete_vehicule',[controllerVehicule::class, 'destroy']);
Route::post('/show_vehicule',[controllerVehicule::class, 'show']);
Route::post('/edite_vehicule',[controllerVehicule::class, 'update']);
Route::post('/search_vehicule',[controllerVehicule::class, 'search']);
//-------------------------------------------------------------
//-------------------------------------------------------------

//--------------- Tyep Véhicule ---------------------------
Route::post('/add_type_vehicule',[controllerTypeVehicule::class, 'store']);
Route::post('/delete_type_vehicule',[controllerTypeVehicule::class, 'destroy']);
Route::post('/show_type_vehicule',[controllerTypeVehicule::class, 'show']);
Route::post('/edite_type_vehicule',[controllerTypeVehicule::class, 'update']);
Route::post('/search_type_vehicule',[controllerTypeVehicule::class, 'search']);
//-------------------------------------------------------------

//--------------- Tyep Agent ---------------------------
Route::post('/add_type_agent',[controllerTypeAgent::class, 'store']);
Route::post('/delete_type_agent',[controllerTypeAgent::class, 'destroy']);
Route::post('/show_type_agent',[controllerTypeAgent::class, 'show']);
Route::post('/edite_type_agent',[controllerTypeAgent::class, 'update']);
Route::post('/search_type_agent',[controllerTypeAgent::class, 'search']);
//-------------------------------------------------------------
//----------------------------- Agent ---------------------------------
Route::get('/agent',[controllerAgent::class, 'index']);
Route::post('/add_agent',[controllerAgent::class, 'store']);
Route::post('/delete_agent',[controllerAgent::class, 'destroy']);
Route::post('/show_agent',[controllerAgent::class, 'show']);
Route::post('/edite_agent',[controllerAgent::class, 'update']);
Route::post('/search_agent',[controllerAgent::class, 'search']);
//-------------------------------------------------------------
//--------------- Tyep d'Absence ---------------------------
Route::post('/add_type_absence',[controllerTypeAbsence::class, 'store']);
Route::post('/delete_type_absence',[controllerTypeAbsence::class, 'destroy']);
Route::post('/show_type_absence',[controllerTypeAbsence::class, 'show']);
Route::post('/edite_type_absence',[controllerTypeAbsence::class, 'update']);
Route::post('/search_type_absence',[controllerTypeAbsence::class, 'search']);
//-------------------------------------------------------------

//----------------------------- absence ---------------------------------
Route::get('/absence',[controllerabsence::class, 'index']);
Route::post('/add_absence',[controllerabsence::class, 'store']);
Route::post('/delete_absence',[controllerabsence::class, 'destroy']);
Route::post('/show_absence',[controllerabsence::class, 'show']);
Route::post('/edite_absence',[controllerabsence::class, 'update']);
Route::post('/search_absence',[controllerabsence::class, 'search']);
//-------------------------------------------------------------


//--------------- DePeche ---------------------------
Route::get('/depeche',[controllerDepeche::class, 'index']);
Route::post('/add_depeche',[controllerDepeche::class, 'store']);
Route::post('/delete_depeche',[controllerDepeche::class, 'destroy']);
Route::post('/show_depeche',[controllerDepeche::class, 'show']);
Route::post('/edite_depeche',[controllerDepeche::class, 'update']);
Route::post('/sortie_depeche',[controllerDepeche::class, 'sortie']);
Route::post('/search_depeche',[controllerDepeche::class, 'search']);

//--------------- Tyep de dePeche ---------------------------
Route::post('/add_type_depeche',[controllerTypeDepeche::class, 'store']);
Route::post('/delete_type_depeche',[controllerTypeDepeche::class, 'destroy']);
Route::post('/show_type_depeche',[controllerTypeDepeche::class, 'show']);
Route::post('/edite_type_depeche',[controllerTypeDepeche::class, 'update']);
Route::post('/search_type_depeche',[controllerTypeDepeche::class, 'search']);

//----------------------------------------------------------------------------------
//--------------- Prise Service --------------------------------------
Route::get('/prise_service',[controllerPriseService::class, 'index']);
Route::post('/add_prise_service',[controllerPriseService::class, 'store']);
Route::post('/delete_prise_service',[controllerPriseService::class, 'destroy']);
Route::post('/show_prise_service',[controllerPriseService::class, 'show']);
Route::post('/edite_prise_service',[controllerPriseService::class, 'update']);
Route::post('/search_prise_service',[controllerPriseService::class, 'search']);
//-------------------------------------------------------------


//--------------- Planning --------------------------------------
Route::get('/planning',[controllerPlanning::class, 'index']);
Route::post('/add_planning',[controllerPlanning::class, 'store']);
Route::post('/delete_planning',[controllerPlanning::class, 'destroy']);
Route::post('/show_planning',[controllerPlanning::class, 'show']);
Route::post('/edite_planning',[controllerPlanning::class, 'update']);
Route::post('/search_planning',[controllerPlanning::class, 'search']);
//-------------------------------------------------------------