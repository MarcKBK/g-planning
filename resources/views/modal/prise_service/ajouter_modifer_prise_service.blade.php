<div class="modal fade modal_add_edite_prise_service" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title mt-0" id="titre_modal_add_edite_prise_service"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="" id="form_add_edite_prise_service" class="">
                    @csrf
                    <div class="row">

                        <input type="hidden" name="id_prise_service" id="input_id_prise_service" value="">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <select name="agent" id="input_agent_prise_service" class="form-control">
                                            <optgroup label="Selectionner un Agent">
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
                                        <select name="gare" id="input_gare_prise_service" class="form-control">
                                            <optgroup label="Selectionner une Gare">
                                                <option value=""></option>
                                                @foreach ($gares as  $gare)
                                                    <option value="{{ $gare->id }}"> {{ ucfirst($gare->gare) }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <div class="input-group-append bg-custom b-0 "><span class="input-group-text"><i class="fas fa-house-damage"></i></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        

                       
                        <div class="col-lg-12">
                            <label for="input_date_heure_prise_service">Date & Heure Prise de Service</label>
                            <input type="datetime-local" name="date_heure" id="input_date_heure_prise_service" class="form-control">
                        </div>

                        <div class="col-lg-12  mt-2" id="modal_reponse_server_prise_service">

                            <div  id ="alert_reponse_server_prise_service" class="alert">
                                <span id="reponse_server_prise_service"> </span>
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
