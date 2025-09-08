<div class="modal fade bs-example-modal-sm modal_supprimer_gare" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <input type="hidden" id="token" name="csrf-token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <h6 class="text-center text-danger">Confirmer la suppression</h6>
                    </div>

                    <div class="col-sm-6 text-right">
                       <button class="btn btn-default" data-dismiss="modal" aria-hidden="true"> <i class="fa fa-hand-paper-o"></i> Annuler </button>
                    </div>

                    <div class="col-sm-6">
                        <button class="btn btn-danger btn-confirme-delete-gare"> <i class="fa fa-trash"></i> Supprimer </button>
                    </div>

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

