<div class="modal fade modal_add_edite_absence" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title mt-0" id="titre_modal_add_edite_absence"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="" id="form_add_edite_absence" class="">
                    @csrf
                    <div class="row">

                        <input type="hidden" name="id_absence" id="input_id_absence" value="">

                        <div class="col-lg-12">
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <select name="agent" id="input_agent_absence" class="form-control">
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

                                        <select name="absence" id="input_type_absence" class="form-control">
                                            <optgroup label="Selectionner un Type  d'Absence">
                                                <option value=""></option>
                                                @foreach ($type_absences as  $type_absence)
                                                    <option value="{{ $type_absence->id }}"> {{ ucfirst($type_absence->type_absence) }} </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <div class="input-group-append bg-custom b-0 "><span class="input-group-text"><i class="fas fa-radiation"></i></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <label for="input_date_debut_absence">Date Début</label>
                            <input type="date" name="date_debut" id="input_date_debut_absence" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <label for="input_date_fin_absence">Date Début</label>
                            <input type="date" name="date_fin" id="input_date_fin_absence" class="form-control">
                        </div>

                        <div class="col-lg-12 " id="modal_reponse_server_absence">

                            <div  id ="alert_reponse_server_absence" class="alert">
                                <span id="reponse_server_absence"> </span>
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
