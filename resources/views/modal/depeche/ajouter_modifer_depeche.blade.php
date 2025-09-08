<div class="modal fade modal_add_edite_depeche" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title mt-0" id="titre_modal_add_edite_depeche"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="" id="form_add_edite_depeche" class="">
                    @csrf
                    <div class="row">

                        <input type="hidden" name="id_depeche" id="input_id_depeche" value="">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <select name="gare" id="input_gare_depeche" class="form-control">
                                            <optgroup label="Selectionner une Gare">
                                                <option value=""></option>
                                                @foreach ($liste_gares as  $gare)
                                                    <option value="{{ $gare->id }}"> {{ ucfirst($gare->gare) }} </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <div class="input-group-append bg-custom b-0 "><span class="input-group-text"><i class="fas fa-house-damage"></i></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <select name="type" id="input_type_depeche" class="form-control">
                                            <optgroup label="Selectionner un Type de Dépêche">
                                                <option value=""></option>
                                                @foreach ($type_depeches as  $type_depeche)
                                                    <option value="{{ $type_depeche->id }}"> {{ ucfirst($type_depeche->type_depeche) }} </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <div class="input-group-append bg-custom b-0 "><span class="input-group-text"><i class="fas fa-briefcase-medical "></i></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <select name="vehicule" id="input_vehicule_depeche" class="form-control">
                                            <optgroup label="Selectionner un Véhicule">
                                                <option value=""></option>
                                                @foreach ($liste_vehicules as  $vehicule)
                                                    <option value="{{ $vehicule->id }}"> {{ ucfirst($vehicule->vehicule) }} </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <div class="input-group-append bg-custom b-0 "><span class="input-group-text"><i class="fas fa-bus"></i></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <select name="agent_depot" id="input_agent_depot_depeche" class="form-control">
                                            <optgroup label="L'agent qui a Déposé le Véhicule">
                                                <option value=""></option>
                                                @foreach ($agents as  $agent)
                                                    <option value="{{ $agent->id }}"> {{ ucfirst($agent->nom) }} {{ ucfirst($agent->prenom) }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <div class="input-group-append bg-custom b-0 "><span class="input-group-text"><i class="fas fa-users"></i></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <select name="agent_reception" id="input_agent_reception_depeche" class="form-control">
                                            <optgroup label="L'agent qui a Réceptionné le Véhicule">
                                                <option value=""></option>
                                                @foreach ($agents as  $agent)
                                                    <option value="{{ $agent->id }}"> {{ ucfirst($agent->nom) }} {{ ucfirst($agent->prenom) }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <div class="input-group-append bg-custom b-0 "><span class="input-group-text"><i class="fas fa-users"></i></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 mb-4">
                            <label for="input_date_entree_depeche">Date d'Entrée</label>
                            <input type="date" name="date_entree" id="input_date_entree_depeche" class="form-control">
                        </div>

                        <div class="col-lg-6 mb-4">
                            <label for="input_date_prevue_sortie_depeche">Date Prévue de Sortie</label>
                            <input type="date" name="date_prevue" id="input_date_prevue_sortie_depeche" class="form-control">
                        </div>

                        <div class="col-lg-12 mt-2" id="modal_reponse_server_depeche">

                            <div  id ="alert_reponse_server_depeche" class="alert">
                                <span id="reponse_server_depeche"> </span>
                            </div>

                        </div>

                        <div class="col-lg-12 mt-3">
                            <button type="submit" class="btn  btn-block btn-success"> <i class="fa fa-save"></i> Enregistrer</button>
                        </div>

                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
