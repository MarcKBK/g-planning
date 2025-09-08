<div class="modal fade modal_add_edite_planning" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title mt-0" id="titre_modal_add_edite_planning"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <form action="" id="form_add_edite_planning" class="">
                    @csrf
                    <div class="row">

                        <input type="hidden" name="id_planning" id="input_id_planning" value="">


                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-lg-12 mt-2"> 
                                    <h5 class="text-success"><i class="fas fa-users text-success"></i> Equipe ( Agents ) </h5>
                                    <hr class="text-success">
                                </div>

                                <div class="col-lg-12 mt-1">
                                    <div class="form-group">
                                        <div>
                                            <div class="input-group">
                                                <select name="agent" id="input_agent_planning" class="form-control">
                                                    <optgroup label="Selectionner un Agent">
                                                        <option value=""></option>
                                                       
                                                    </optgroup>
                                                </select>
                                                <div class="input-group-append bg-custom b-0  text-success"><span class="input-group-text "><i class="fa fa-save"></i></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12"> 

                                    <table class="table ">
                                        <thead>
                                            <tr class="">
                                                <th style="">Nom & Prénom</th>
                                                <th style="">Type D'Agent</th>
                                                <th style=""> </th>
                                            </tr>
                                        </thead>
                                        <tbody class="tbody_liste_plannings">
                                            
                                            <tr>
                                                <td>Gneno Nicolas</td>
                                                <td>Conducteur</td>
                                                <td><i class="fa fa-trash  btn-delete-agent  icon-lg text-primary"></i></td>
                                            </tr>

                                            <tr>
                                                <td>Imama Mathias</td>
                                                <td>Aide Conducteur</td>
                                                <td><i class="fa fa-trash  btn-delete-agent  icon-lg text-primary"></i></td>
                                            </tr>

                                        </tbody>
                                    </table>
                                

                                    <hr class="mt-2">
                                </div>




                            </div>

                        </div>


                        <div class="col-lg-12">
                            <div class="row">

                                <div class="col-lg-12 mt-4"> 
                                    <h5 class="text-success"><i class="fas fa-route text-success"></i> Trajet  </h5>
                                    <hr class="text-success">
                                </div>

                                <div class="col-lg-12 mt-1">
                                    <div class="form-group">
                                        <div>
                                            <div class="input-group">
                                                <select name="agent" id="input_agent_planning" class="form-control">
                                                    <optgroup label="Selectionner un Véhicule">
                                                        <option value=""></option>
                                                       
                                                    </optgroup>
                                                </select>
                                                <div class="input-group-append bg-custom b-0  text-success"><span class="input-group-text "><i class="fas fa-bus"></i></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 mt-1">
                                    <div class="form-group">
                                        <div>
                                            <div class="input-group">
                                                <select name="agent" id="input_agent_planning" class="form-control">
                                                    <optgroup label="Selectionner une Gare">
                                                        <option value=""></option>
                                                       
                                                    </optgroup>
                                                </select>
                                                <div class="input-group-append bg-custom b-0  text-success"><span class="input-group-text "><i class="fa fa-save"></i></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </hr>

                             <div class="col-lg-12"> 

                                <table class="table ">
                                    <thead>
                                        <tr class="">
                                            <th style="">Gare</th>
                                            <th style="">Gare</th>
                                            <th style="">Durée </th>
                                            <th style="">Priorité </th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody_liste_plannings">
                                        
                                        <tr>
                                            <td>Owendo</td>
                                            <td>Ntoum</td>
                                            <td>1h15</td>
                                            <td>Oui</td>
                                            <td><i class="fa fa-trash  btn-delete-agent  icon-lg text-primary"></i></td>
                                        </tr>
                                        
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="bg-dark text-white">Estimation Durée</td>
                                            <td  class="bg-dark text-white">1h15</td>
                                            
                                        </tr>

                                    </tbody>
                                </table>
                            

                                <hr class="mt-2">
                            </div>

                                
                            
               
                            </div>
                            

                        </div>

                        

                        

                        <div class="col-lg-12 mb-4">
                            <label for="input_date_debut_planning">Date et Heures du Départ</label>
                            <input type="dateTime" name="date_debut" id="input_date_debut_planning" class="form-control">
                        </div>
                        
                        <div class="col-lg-12 " id="modal_reponse_server_planning">

                            <div  id ="alert_reponse_server_planning" class="alert">
                                <span id="reponse_server_planning"> </span>
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
