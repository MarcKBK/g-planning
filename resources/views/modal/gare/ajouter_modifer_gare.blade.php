<div class="modal fade modal_add_edite_gare" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title mt-0" id="titre_modal_add_edite_gare"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="" id="form_add_edite_gare" class="">
                    @csrf
                    <div class="row">

                        <input type="hidden" name="id_gare" id="input_id_gare" value="">

                        <div class="col-lg-12">
                            <input type="text" name="gare" id="input_nom_gare" placeholder="Nom de la Gare" class="form-control">
                        </div>

                        <div class="col-lg-12 mt-2">
                            <input type="text" name="voie" id="input_voie_gare" placeholder="Nombre de Voie" class="form-control">
                        </div>

                        <div class="col-lg-12 mt-2">
                            <input type="text" name="longitude" id="input_longitude_gare" placeholder="Longitude" class="form-control">
                        </div>

                        <div class="col-lg-12 mt-2">
                            <input type="text" name="latitude" id="input_latitude_gare" placeholder="Latitude" class="form-control">
                        </div>

                        <div class="col-lg-12 mt-2" id="modal_reponse_server_gare">

                            <div  id ="alert_reponse_server_gare" class="alert">
                                <span id="reponse_server_gare"> </span>
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
