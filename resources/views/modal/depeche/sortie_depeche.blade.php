<div class="modal fade modal_sortie_depeche" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title mt-0" id="">Sortie de la Dépêche </h6>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="" id="sortie_depeche" class="">
                    @csrf
                    <div class="row">

                        <input type="hidden" name="id_depeche" id="input_id_sortie_depeche" value="">


                        <div class="col-lg-12">
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <select name="vehicule" id="input_vehicule_sortie_depeche" class="form-control" disabled>
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
                                        <select name="agent_sortie" id="input_agent_sortie_depeche" class="form-control">
                                            <optgroup label="L'agent qui a fait Sortie Véhicule">
                                                <option value="" selected></option>
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
                                        <select name="agent_reception" id="input_agent_reception_sortie_depeche" class="form-control">
                                            <optgroup label="L'agent qui a Réceptionné le Véhicule">
                                                <option value="" selected></option>
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

                        <div class="col-lg-12 mb-4">
                            <label for="input_date_sortie_depeche">Date  de Sortie</label>
                            <input type="date" name="date_sortie" id="input_date_sortie_depeche" class="form-control">
                        </div>



                        <div class="col-lg-12 mt-2" id="modal_reponse_server_sortie_depeche">

                            <div  id ="alert_reponse_server_sortie_depeche" class="alert">
                                <span id="reponse_server_sortie_depeche"> </span>
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
