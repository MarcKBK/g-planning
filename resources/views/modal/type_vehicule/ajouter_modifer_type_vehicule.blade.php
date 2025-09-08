<div class="modal fade modal_add_edite_type_vehicule" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title mt-0" id="titre_modal_add_edite_type_vehicule"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="" id="form_add_edite_type_vehicule" class="">
                    @csrf
                    <div class="row">

                        <input type="hidden" name="id_type_vehicule" id="input_id_type_vehicule" value="">

                        <div class="col-lg-12">
                            <input type="text" name="type_vehicule" id="input_nom_type_vehicule" placeholder="Nom du Type du Véhicule" class="form-control">
                        </div>

                        <div class="col-lg-12 mt-2" id="modal_reponse_server_type_vehicule">

                            <div  id ="alert_reponse_server_type_vehicule" class="alert">
                                <span id="reponse_server_type_vehicule"> </span>
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
