<div class="modal fade modal_add_edite_agent" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title mt-0" id="titre_modal_add_edite_agent"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="" id="form_add_edite_agent" class="" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <input type="hidden" name="id_agent" id="input_id_agent" value="">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <select name="type_agent" id="input_type_agent" class="form-control">
                                            <optgroup label="Selectionner un Type d'Agent">
                                                <option value=""></option>
                                                @foreach ($type_agents as  $type_agent)
                                                    <option value="{{ $type_agent->id }}"> {{ ucfirst($type_agent->type_agent) }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="fas fa-radiation"></i></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="row">

                                    <div class="col-lg-7">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input type="text" name="nom" id="input_nom_agent" placeholder="Nom de l'Agent" class="form-control">
                                            </div>
                                            <div class="col-lg-12 mt-6">
                                                <input type="text" name="prenom" id="input_prenom_agent" placeholder="Prénom de l'Agent" class="form-control">
                                            </div>

                                            <div class="col-lg-12 mt-6">
                                                <input type="text" name="matricule" id="input_matricule_agent" placeholder="N° Matricule de l'Agent" class="form-control">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-5">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="cadre_photo_agent">
                                                    <img  src="assets/images/photo.png" alt="" width="100%" height="100%" id="cadre_photo_agent">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 mt-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupFileAddon01"><i class="fa fa-image"></i></span>
                                                    </div>
                                                    <div class="custom-file">
                                                    <input type="file" name="photo" class="custom-file-input" id="input_photo_agent"
                                                        aria-describedby="inputGroupFileAddon01">
                                                    <label class="custom-file-label" for="input_photo">Photo</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <div class="form-group">
                                <div>
                                    <div class="input-group">
                                        <select name="depot" id="input_depot_agent" class="form-control">
                                            <optgroup label="Selectionner un Dépot">
                                                <option value=""></option>
                                                @foreach ($depots as  $depot)
                                                   <option value="{{ $depot->id }}"> {{ ucfirst($depot->depot) }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <div class="input-group-append bg-custom b-0"><span class="input-group-text"><i class="fas fa-radiation"></i></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12" id="modal_reponse_server_agent">

                            <div  id ="alert_reponse_server_agent" class="alert">
                                <span id="reponse_server_agent"> </span>
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
