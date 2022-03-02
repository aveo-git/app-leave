<?php
   if($active['ldap'] == '' && $active['ad'] == '' && $active['userad'] == '' && $active['list'] == '') {
      $active = array(
         'ldap' => "active",
         'ad' => "",
         'userad' => "",
         'list' => "",
      );
   }
?>
<div class="progress">
    <div style="text-align: center">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="color: #FFFFFF;"></i>
        <div style="color: #FFF;font-size: 20px;padding: 15px 0 0 0;">Envoi de mail en cours ...</div>
    </div>
</div>
<div class="row">
   <div class="col">
      <div class="rh-content">
         <h1 class="rh-title">Paramètre</h1><br>
         <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
               <a class="btn btn-default <?= $active['ldap'] ?>" data-action="ldap" id="pills-ldap-tab" data-toggle="pill" href="#pills-ldap" role="tab" aria-controls="pills-ldap" aria-selected="true">LDAP et Autre</a>
            </li>
            <li class="nav-item">
               <a class="btn btn-default <?= $active['ad'] ?>" data-action="ad" id="pills-ad-tab" data-toggle="pill" href="#pills-ad" role="tab" aria-controls="pills-ad" aria-selected="false">Importer AD</a>
            </li>
            <li class="nav-item">
               <a class="btn btn-default <?= $active['userad'] ?>" data-action="userad" id="pills-userad-tab" data-toggle="pill" href="#pills-userad" role="tab" aria-controls="pills-userad" aria-selected="false">Utilisateurs importés sur AD</a>
            </li>
            <li class="nav-item">
               <a class="btn btn-default <?= $active['list'] ?>" data-action="list" id="pills-list-tab" data-toggle="pill" href="#pills-list" role="tab" aria-controls="pills-list" aria-selected="false">Autre liste</a>
            </li>
         </ul>
         <hr>
         <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show <?= $active['ldap'] ?>" id="pills-ldap" role="tabpanel" aria-labelledby="pills-ldap-tab">
               <div class="row">
                  <div class="col-lg-6 col-md-12 col-12">
                     <h2 class="rh-subtitle">LDAP</h2>
                     <form id="params-form">
                        <?php foreach($params as $item){ ?>
                           <div class="form-group">
                              <label for="rh-<?= $item->param_code ?>"><?= $item->param_lib ?> <ion-icon class="icon_edit" data-toggle="modal" data-target="#edit_params" data-code="<?= $item->param_code ?>" data-lib="<?= $item->param_lib ?>" data-value="<?= $item->param_value ?>" name="create-outline"></ion-icon></label>
                              <input type="text" class="form-control" disabled id="rh-<?= $item->param_code ?>" name="<?= $item->param_lib ?>" value="<?= $item->param_value ?>" aria-describedby="rh-<?= $item->param_code ?>" required>
                           </div>
                        <?php } ?>
                     </form>
                  </div>
                  <div class="col-lg-6 col-md-12 col-12">
                     <h2 class="rh-subtitle">AJOUT NOUVEAU LDAP</h2>
                     <form id="newparams-form">
                        <div class="row">
                           <div class="form-group col">
                              <label for="rh-code">Params code</label>
                              <input type="text" class="form-control" id="rh-code" name="param_code" aria-describedby="rh-code" required>
                           </div>
                           <div class="form-group col">
                              <label for="rh-lib">Params lib</label>
                              <input type="text" class="form-control" id="rh-lib" name="param_lib" aria-describedby="rh-lib" required>
                           </div>
                           <div class="form-group col">
                              <label for="rh-value">Params value</label>
                              <input type="text" class="form-control" id="rh-value" name="param_value" aria-describedby="rh-value" required>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-secondary">Envoyer</button>
                     </form>
                     <hr>
                     <h2 class="rh-subtitle">AJOUT NOUVEAU MAIL DE DIFFUSION</h2>
                     <form id="maildiffusion-form">
                        <div class="row">
                           <div class="form-group col">
                              <label for="rh-label">Libellé</label>
                              <input type="text" class="form-control" id="rh-label" name="md_label" aria-describedby="rh-label" required>
                           </div>
                           <div class="form-group col">
                              <label for="rh-description">Description</label>
                              <input type="text" class="form-control" id="rh-description" name="md_description" aria-describedby="rh-description">
                           </div>
                           <div class="form-group col">
                              <label for="rh-typeImport">Type import</label>
                              <input type="text" class="form-control" id="rh-typeImport" name="md_typeImport" aria-describedby="rh-typeImport" value="app">
                           </div>
                        </div>
                        <button type="submit" class="btn btn-secondary">Envoyer</button>
                     </form>
                     <hr>
                     <h2 class="rh-subtitle">AJOUT NOUVEAU DOMAINE</h2>
                     <form id="domaine-form">
                        <div class="row">
                           <div class="form-group col">
                              <label for="rh-label">Libellé</label>
                              <input type="text" class="form-control" id="rh-label" name="d_label" aria-describedby="rh-label" required>
                           </div>
                           <div class="form-group col">
                              <label for="rh-description">Description</label>
                              <input type="text" class="form-control" id="rh-description" name="d_description" aria-describedby="rh-description" required>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-secondary">Envoyer</button>
                     </form>
                     <hr>
                     <h2 class="rh-subtitle">AJOUT D'UN NOUVEAU SERVICE</h2>
                     <form action="" id="form_service">
                        <div class="form-group">
                           <label for="rh-label">Nom de service</label>
                           <input type="text" class="form-control" id="rh-label" name="sc_label" aria-describedby="rh-label" required="required">
                        </div>
                        <div class="form-group">
                           <label for="rh-mail">Adresse mail du responsable</label>
                           <input type="mail" class="form-control" id="rh-mail" name="sc_mail" aria-describedby="rh-mail" required="required">
                        </div>
                        <div class="form-group">
                           <label for="rh-system">Rattacher au systeme</label>
                           <select class="form-control" id="rh-system" name="sc_idSysteme" aria-describedby="rh-system" required="required">
                              <?php foreach($system as $item){ ?>
                                 <option value="<?= $item->id_systeme ?>"><?= $item->sy_nom ?></option>
                              <?php } ?>
                           </select>
                        </div>
                        <button type="submit" class="btn btn-secondary">Envoyer</button>
                     </form>
                     <hr>
                     <h2 class="rh-subtitle">AJOUT D'UN NOUVEAU LOGICIEL</h2>
                     <form action="" id="form_soft">
                        <div class="row">
                           <div class="form-group col">
                              <label for="rh-soft">Nom du logiciel</label>
                              <input type="text" class="form-control" id="rh-soft" name="l_label" aria-describedby="rh-soft" required>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-secondary">Envoyer</button>
                     </form>
                  </div>
               </div>
            </div>
            <div class="tab-pane fade show <?= $active['ad'] ?>" id="pills-ad" role="tabpanel" aria-labelledby="pills-ad-tab">
               <form id="adtest-form">
                  <button type="submit" class="btn btn-secondary">IMPORTER AD</button>
                  <button type="button" class="btn btn-danger" data-toggle='modal' data-target="#delete_all_userad">SUPPRIMER LES COMPTES AD</button>
               </form>
            </div>
            <div class="tab-pane fade show <?= $active['userad'] ?>" id="pills-userad" role="tabpanel" aria-labelledby="pills-userad-tab">
               <div class="">
                  <div class="box-body table-responsive">
                     <!-- USER LIST -->
                     <table id="userad_data" class="table table-striped table-bordered compact dataTable no-footer" role="grid" aria-describedby="datatable_info" style="width: 100%">
                           <thead>
                              <tr role="row">
                                 <th>Nom d'utilisateur</th>
                                 <th>Prénom</th>
                                 <th>Nom</th>
                                 <th style="width: 10%">Email</th>
                                 <th>Description</th>
                                 <th>Statut RH</th>
                                 <th>Type Auth</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                     </table>
                     <!-- /USER LIST -->
                  </div>
                  <div class="box-footer"></div><!-- /.box-footer -->
               </div>
            </div>
            <div  class="tab-pane fade show <?= $active['list'] ?>" id="pills-list" role="tabpanel" aria-labelledby="pills-list-tab">
               <div class="row">
                  <div class="col">
                     <h2 class="rh-subtitle">MODIFIER MAIL DE DIFFUSION</h2>
                     <form>
                        <div class="row">
                           <div class="form-group col">
                              <label for="rh-md">Choisissez un mail</label>
                              <select class="form-control" id="rh-md-u" name="id_mailDiffusion" aria-describedby="rh-md" required="required">
                                 <?php foreach($md as $item){ ?>
                                    <option value="<?= $item->id_mailDiffusion ?>" data-lib="<?= $item->md_label ?>" data-type="<?= $item->md_typeImport ?>"><?= $item->md_description ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                        </div>
                     </form>
                     <form id="maildiffusion-form-u">
                        <div class="row">
                           <div class="form-group col">
                              <label for="rh-label">Libellé</label>
                              <input type="text" class="form-control" id="rh-l-md-u" name="md_label" aria-describedby="rh-label" required>
                           </div>
                           <div class="form-group col">
                              <label for="rh-description">Description</label>
                              <input type="text" class="form-control" id="rh-d-md-u" name="md_description" aria-describedby="rh-description" required>
                           </div>
                           <div class="form-group col">
                              <label for="rh-typeImport">Type import</label>
                              <input type="text" class="form-control" id="rh-tI-md-u" name="md_typeImport" aria-describedby="rh-typeImport" required>
                           </div>
                           <input type="hidden" name="id_mailDiffusion" id="rh-id_mailDiffusion-u">
                        </div>
                        <button type="submit" class="btn btn-secondary">Modifier</button>
                        <button type="button" class="btn btn-danger" id="maildiffusion-btn-delete">Supprimer</button>
                     </form>
                  </div>
                  <div class="col">
                     <h2 class="rh-subtitle">MODIFIER UN DOMAINE</h2>
                     <form>
                        <div class="row">
                           <div class="form-group col">
                              <label for="rh-md">Choisissez un domaine</label>
                              <select class="form-control" id="rh-domaine-u" name="id_domaine" aria-describedby="rh-domaine" required="required">
                                 <?php foreach($domains as $item){ ?>
                                    <option value="<?= $item->id_domaine ?>" data-desc="<?= $item->d_description ?>"><?= $item->d_label ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                        </div>
                     </form>
                     <form id="domaine-form-u">
                        <div class="row">
                           <div class="form-group col">
                              <label for="rh-label">Libellé</label>
                              <input type="text" class="form-control" id="rh-l-d-u" name="d_label" aria-describedby="rh-label" required>
                           </div>
                           <div class="form-group col">
                              <label for="rh-description">Description</label>
                              <input type="text" class="form-control" id="rh-d-d-u" name="d_description" aria-describedby="rh-description" required>
                           </div>
                        </div>
                        <input type="hidden" name="id_domaine" id="rh-id_domaine-u">
                        <button type="submit" class="btn btn-secondary">Modifier</button>
                        <button type="button" class="btn btn-danger" id="domaine-btn-delete">Supprimer</button>
                     </form>
                  </div>
               </div>
               <br>
               <div class="row">
                  <div class="col">
                     <h2 class="rh-subtitle">MODIFIER UNE SERVICE</h2>
                     <form>
                        <div class="row">
                           <div class="form-group col">
                              <label for="rh-service">Choisissez une service</label>
                              <select class="form-control" id="rh-service-u" name="id_service" aria-describedby="rh-service" required="required">
                                 <?php foreach($services as $item){ ?>
                                    <option value="<?= $item->id_service ?>" data-mail="<?= $item->sc_mail ?>" data-valeur="<?= $item->sc_label ?>"><?= $item->sc_label." (".$item->sc_mail.")" ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                        </div>
                     </form>
                     <form id="form_service-u">
                        <div class="row">
                           <div class="col">
                              <div class="form-group">
                                 <label for="rh-label">Nom de service</label>
                                 <input type="text" class="form-control" id="rh-l-s-u" name="sc_label" aria-describedby="rh-label" required="required">
                              </div>
                           </div>
                           <div class="col">
                              <div class="form-group">
                                 <label for="rh-mail">Adresse mail du responsable</label>
                                 <input type="mail" class="form-control" id="rh-m-s-u" name="sc_mail" aria-describedby="rh-mail" required="required">
                              </div>
                           </div>
                        </div>
                        <input type="hidden" name="id_service" id="rh-id_service-u">
                        <!-- <div class="form-group">
                           <label for="rh-system">Rattacher au systeme</label>
                           <select class="form-control" id="rh-s-s-u" name="sc_idSysteme" aria-describedby="rh-system" required="required">
                              ?php foreach($system as $item){ ?>
                                 <option value="?= $item->id_systeme ?>">?= $item->sy_nom ?></option>
                              ?php } ?
                           </select>
                        </div> -->
                        <button type="submit" class="btn btn-secondary">Modifier</button>
                        <button type="button" class="btn btn-danger" id="service-btn-delete">Supprimer</button>
                     </form>
                  </div>
                  <div class="col">
                     <h2 class="rh-subtitle">MODIFIER UN LOGICIEL</h2>
                     <form action="">
                        <div class="row">
                           <div class="form-group col">
                              <label for="rh-logiciel">Choisissez un logiciel</label>
                              <select class="form-control" id="rh-logiciel-u" name="id_mailDiffusion" aria-describedby="rh-logiciel" required="required">
                                 <?php foreach($logiciels as $item){ ?>
                                    <option value="<?= $item->id_logiciel ?>"><?= $item->l_label ?></option>
                                 <?php } ?>
                              </select>
                           </div>
                        </div>
                     </form>
                     <form action="" id="form_soft-u">
                        <div class="row">
                           <div class="form-group col">
                              <label for="rh-soft">Nom du logiciel</label>
                              <input type="text" class="form-control" id="rh-s-l-u" name="l_label" aria-describedby="rh-soft" required>
                           </div>
                        </div>
                        <input type="hidden" name="id_logiciel" id="rh-id_logiciel-u">
                        <button type="submit" class="btn btn-secondary">Modifier</button>
                        <button type="button" class="btn btn-danger" id="logiciel-btn-delete">Supprimer</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


<!-- Modal pour Toggle statut d'un collaborateur -->
<div class="modal fade" id="toggle_compte_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="modal_toggle_compte_label" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
      <div class="modal-header">
            <h5 class="modal-title" id="modal_toggle_compte_label">Modification</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
      </div>
      <div class="modal-body">
            <p>Vous-êtes sur de vouloir modifier le statut du collaborateur?</p>
            <p id="alert_email">
               <span class="message">NB : L'utilisateur doit avoir au moins un adresse email.</span>
            </p>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
            <button type="button" class="btn btn-primary" id="confirm_toggle_compte">Oui</button>
      </div>
      </div>
   </div>
</div>

<!-- Modal pour mofication LDAP -->
<div class="modal fade" id="edit_params" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="params_serviceLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="params_serviceLabel">Modification de : <small id="title-params">Domaine</small></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form id="updateparams-form">
            <div class="row">
               <div class="form-group col">
                  <label for="rh-code">Params code</label>
                  <input type="text" class="form-control" id="rh-code" name="param_code" aria-describedby="rh-code" required>
               </div>
               <div class="form-group col">
                  <label for="rh-lib">Params lib</label>
                  <input type="text" class="form-control" id="rh-lib" name="param_lib" aria-describedby="rh-lib" required>
               </div>
               <div class="form-group col">
                  <label for="rh-value">Params value</label>
                  <input type="text" class="form-control" id="rh-value" name="param_value" aria-describedby="rh-value" required>
               </div>
            </div>
            <input type="hidden" data-code="" id="code_params" name="code_params">
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary" id="update_params">Sauver</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal pour Vider la table AD -->
<div class="modal fade" id="delete_all_userad" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="deleteAllUserad" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteAllUserad">Suppression</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Vous-êtes sur de vouloir supprimer tous les utilisateurs enregistrés? <br>
            <u>NB</u> : Sauf votre compte. <br>
            <u>Attention</u> : Si vous-êtes un admin, les comptes sont tous éffacés.
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
            <button type="button" class="btn btn-primary" id="delete_all_userad_confirm">Oui</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal pour Supprimer un utilisateur -->
<div class="modal fade" id="delete_userad_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="deleteUserad" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteUserad">Suppression</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Vous-êtes sur de vouloir supprimer l'utilisateur?
            <form action="" id="delete_userad_form">
                <input type="hidden" name="id_userad" id="input_id_userad" data-value="">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
            <button type="button" class="btn btn-primary" id="delete_userad_confirm">Oui</button>
        </div>
        </div>
    </div>
</div>

<!-- Modal pour mofication utilisateur -->
<div class="modal fade" id="edit_userad" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="userad_serviceLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userad_serviceLabel">Modification de : <small id="title-userad"></small></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <form id="updateuserad-form">
            <input type="hidden" data-code="" id="id_userad" name="id_userad">
            <div class="row">
               <div class="form-group col">
                  <label for="ua-username">Nom d'utilisateur</label>
                  <input type="text" class="form-control" id="ua-username" name="ua_username" aria-describedby="ua-username" required>
               </div>
            </div>
            <div class="row">
               <div class="form-group col">
                  <label for="ua-nom">Nom</label>
                  <input type="text" class="form-control" id="ua-nom" name="ua_nom" aria-describedby="ua-nom" required>
               </div>
               <div class="form-group col">
                  <label for="ua-prenom">Prénom</label>
                  <input type="text" class="form-control" id="ua-prenom" name="ua_prenom" aria-describedby="ua-prenom" required>
               </div>
            </div>
            <div class="row">
               <div class="form-group col">
                  <label for="ua-email">Email</label>
                  <input type="text" class="form-control" id="ua-email" name="ua_email" aria-describedby="ua-email" required>
               </div>
               <div class="form-group col">
                  <label for="ua-description">Description</label>
                  <input type="text" class="form-control" id="ua-description" name="ua_description" aria-describedby="ua-description" required>
               </div>
            </div>
            <!-- <div class="row">
               <div class="form-group col form-check" style="padding-left: 2.25rem">
                  <input type="checkbox" class="form-check-input" name="ua_active" id="ua-active">
                  <label class="form-check-label" for="ua-active">Activé</label>
               </div>
            </div> -->
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary" id="update_userad">Sauver</button>
      </div>
    </div>
  </div>
</div>

<script>
   // acvtive toggle button
   $('.btn-default').on('click', function() {
      $.ajax({
         url: '<?= site_url('/listCollab/set_session_active') ?>',
         method: "POST",
         data: [{ name: "active", value: $(this).data('action')}],
         success: function() {

         }
      })
   })

   // Formulaire d'insertion de nouveau parametre
   $('#newparams-form').on('submit', function() {
      let data = $(this).serializeArray();
      $.ajax({
         url: "<?= site_url('params/insert_param') ?>",
         method: "POST",
         data: data,
         success: function(msg) {
            alert("Ajouté")
         }
      })
   })

   $('.icon_edit').on('click', function() {
      $('#title-params').html($(this).data('code'))
      $('#updateparams-form #rh-code').val($(this).data('code'))
      $('#updateparams-form #rh-lib').val($(this).data('lib'))
      $('#updateparams-form #rh-value').val($(this).data('value'))
      $('#code_params').val($(this).data('code'));
   })
   
   // Modification parametre
   $('#update_params').on('click', function() {
      let data = $('#updateparams-form').serializeArray();
      $.ajax({
         url: "<?= site_url('params/update_params') ?>",
         method: "POST",
         data: data,
         success: function(msg) {
            location.reload();
         }
      })
   })

   // Ajouter un domaine
   $('#domaine-form, #domaine-form-u').on('submit', function(e) {
      e.preventDefault();
      let data = $(this).serializeArray();
      $.ajax({
         url: "<?= site_url('params/insert_domaine') ?>",
         method: "POST",
         data: data,
         success: function(msg) {
            location.reload();
         }
      })
   })
   // Modifier un domaine
   $('#rh-domaine-u').change(function() {
      $('#rh-domaine-u option:selected').each(function() {
         $('#rh-l-d-u').val($(this).html());
         $('#rh-d-d-u').val($(this).data('desc'));
         $('#rh-id_domaine-u').val($(this).val());
      })
   })
   // Supprimer un domaine
   $('#domaine-btn-delete').on('click', function(e) {
      e.preventDefault();
      let data = $('#domaine-form-u').serializeArray();
      $.ajax({
         url: "<?= site_url('params/delete_domaine') ?>",
         method: "POST",
         data: data,
         success: function(msg) {
            location.reload();
         }
      })
   })

   // Ajout d'un nouveau Service
   $('#form_service, #form_service-u').on('submit', function(e) {
      e.preventDefault();
      let data = $(this).serializeArray();
      $.ajax({
         url: "<?= site_url('params/insert_service') ?>",
         method: "POST",
         data: data,
         success: function(data) {
            location.reload();
         }
      })
   })
   // Modifier une service
   $('#rh-service-u').change(function() {
      $('#rh-service-u option:selected').each(function() {
         $('#rh-l-s-u').val($(this).data('valeur'));
         $('#rh-m-s-u').val($(this).data('mail'));
         $('#rh-id_service-u').val($(this).val());
      })
   })
   // Supprimer une service
   $('#service-btn-delete').on('click', function(e) {
      e.preventDefault();
      let data = $('#form_service-u').serializeArray();
      $.ajax({
         url: "<?= site_url('params/delete_service') ?>",
         method: "POST",
         data: data,
         success: function(msg) {
            location.reload();
         }
      })
   })

   $('#adtest-form').on('submit', function(e) {
      e.preventDefault();
      let data = $(this).serializeArray();
      $.ajax({
         url: "<?= site_url('params/import_AD') ?>",
         method: "POST",
         data: data,
         beforeSend: function() {
            $(".progress").addClass('active');
         },
         success: function(msg) {
            $(".progress").removeClass('active');
            location.reload();
         }
      })
   })

   $('#delete_all_userad_confirm').on('click', function(e) {
      e.preventDefault();
      $.ajax({
         url: "<?= site_url('params/delete_all_userad') ?>",
         method: "POST",
         data: null,
         beforeSend: function() {
            $(".progress").addClass('active');
         },
         success: function(msg) {
            $(".progress").removeClass('active');
            location.reload();
         }
      });
   })

   // Sauver un nouveau logiciel
   $('#form_soft, #form_soft-u').on('submit', function(e) {
      e.preventDefault();
      let data = $(this).serializeArray();
      $.ajax({
         url: "<?= site_url('params/insert_soft') ?>",
         method: "POST",
         data: data,
         success: function(data) {
            location.reload();
         }
      })
   })
   // Modifier un logiciel
   $('#rh-logiciel-u').change(function() {
      $('#rh-logiciel-u option:selected').each(function() {
         $('#rh-s-l-u').val($(this).html());
         $('#rh-id_logiciel-u').val($(this).val());
      })
   })
   // Supprimer un logiciel
   $('#logiciel-btn-delete').on('click', function(e) {
      e.preventDefault();
      let data = $('#form_soft-u').serializeArray();
      $.ajax({
         url: "<?= site_url('params/delete_logiciel') ?>",
         method: "POST",
         data: data,
         success: function(msg) {
            location.reload();
         }
      })
   })

   // Ajouter un mail de diffusion
   $('#maildiffusion-form, #maildiffusion-form-u').on('submit', function(e) {
      e.preventDefault();
      let data = $(this).serializeArray();
      $.ajax({
         url: "<?= site_url('params/insert_maildiffusion') ?>",
         method: "POST",
         data: data,
         success: function(msg) {
            location.reload();
         }
      })
   })
   // Modifier un mail de diffusion
   $('#rh-md-u').change(function() {
      $('#rh-md-u option:selected').each(function() {
         $('#rh-l-md-u').val($(this).data('lib'));
         $('#rh-id_mailDiffusion-u').val($(this).val());
         $('#rh-tI-md-u').val($(this).data('type'));
         $('#rh-d-md-u').val($(this).html());
      })
   })
   // Supprimer un mail de diffusion
   $('#maildiffusion-btn-delete').on('click', function(e) {
      e.preventDefault();
      let data = $('#maildiffusion-form-u').serializeArray();
      $.ajax({
         url: "<?= site_url('params/delete_maildiffusion') ?>",
         method: "POST",
         data: data,
         success: function(msg) {
            location.reload();
         }
      })
   })

   let active_userad = function(status) {
      let toogleButton = (status == '1') ? "<ion-icon class='disabled' name='toggle' size='large' style='color: #02C1CE;'></ion-icon>" : "<ion-icon class='disabled' name='toggle-outline' size='large' style='color : #dfdfdf; transform: rotate(180deg);'></ion-icon>";

      return `
         <div class="toogle_compte" data-toggle='modal' data-target='#toggle_compte_modal' style="cursor: pointer" title="Changer le statut de l'utilisateur">
               `+ toogleButton +`
         </div>
      `;
   }

   let action_userad = function(id) {
      return `
         <div>
            <span class="rh-action-button edit" data-toggle='modal' data-target='#edit_userad' data-value="`+id+`" title="Modifier un utilisateur"><ion-icon class="disabled" title="Modifier" name="create-outline"></ion-icon></span>
            <span class="rh-action-button trash" data-toggle='modal' data-target='#delete_userad_modal' data-value="`+id+`" title="Supprimer un utilisateur"><ion-icon class="disabled" name="trash-outline"></ion-icon></span>
         </div>
      `;
   }

   let table_userad = $('#userad_data').DataTable({
      "ajax": '<?= site_url('params/list_userad') ?>',
      "columns": [
         {"data": 'ua_username'},
         {"data": 'ua_prenom'},
         {"data": 'ua_nom'},
         {"data": 'ua_email'},
         {"data": 'ua_description'},
         {"data": null,
            render: function(item) {
               return active_userad(item.ua_active);
            }
         }, 
         {"data": 'ua_typeAuth'},
         {"data": null,
            render: function(item) {
               return action_userad(item.id_userad);
            }
         },
      ],
      "language": {
         "emptyTable": "Aucun Résultat",
         "infoEmpty": "Aucun enregistrement disponible",
         "zeroRecords": "Aucun Résultat",
         "infoFiltered": "(filtré à partir du total : _MAX_ entrée(s))",
         "lengthMenu": "Afficher : _MENU_",
         "info": "Page _PAGE_ sur _PAGES_",
         'search': "Recherche : ",
         "paginate": {
            "first":      "Premier",
            "last":       "Dernier",
            "next":       "Suivant",
            "previous":   "Précedent"
         },
      },
      "dom": "<'row w-100 m-0 p-2'<'col text-left'l><'col text-center'p><'col text-right'f>>",
      "bFilter": true,
      "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Tous']],
   });

   $('#userad_data tbody').on('click', 'div.toogle_compte', function() {
      let tr = $(this).parents('tr');
      let userad = table_userad.row(tr).data();
      data = {
         "id_userad": userad.id_userad,
         "ua_active": userad.ua_active
      }
      if(userad.ua_email == null) {
         $('#alert_email').show();
         $('#confirm_toggle_compte').prop('disabled', true)
      } else {
         $('#alert_email').hide();
         $('#confirm_toggle_compte').prop('disabled', false)
      }
      $('#confirm_toggle_compte').on('click', function() {
         $.ajax({
               url: "<?= site_url('params/toggle_compte_userad') ?>",
               method: 'POST',
               data: data,
               beforeSend: function() {
                  $(".progress").addClass('active');
               },
               success: function() {
                  $(".progress").removeClass('active');
                  location.reload();
               }
         });
      })
   })
   $('#userad_data tbody').on('click', 'span', function(e) {
      e.preventDefault();
      let tr = $(this).parents('tr');
      let userad = table_userad.row(tr).data();
      console.log(userad);
      $('#title-userad').html(userad.ua_prenom+" "+userad.ua_nom);
      $('#id_userad').html(userad.id_userad);

      $('#ua-username').val(userad.ua_username);
      $('#ua-nom').val(userad.ua_nom);
      $('#ua-prenom').val(userad.ua_prenom);
      $('#ua-email').val(userad.ua_email);
      $('#ua-description').val(userad.ua_description);
      userad.ua_active == 1 ? $('#ua-active').prop("checked", true) : $('#ua-active').prop("checked", false);

      $('#update_userad').on('click', function() {
         let data = $('#updateuserad-form').serializeArray();
         data.push({name: "id_userad", value: userad.id_userad});
         data.push({name: "ua_username", value: userad.ua_username});
         $.ajax({
               url: "<?= site_url('params/update_userad') ?>",
               method: 'POST',
               data: data,
               success: function() {
                  location.reload();
               }
         });
      })
      $('#delete_userad_confirm').on('click', function() {
         $.ajax({
               url: "<?= site_url('params/delete_userad') ?>",
               method: 'POST',
               data: [{name: 'id_userad', value: userad.id_userad}],
               success: function() {
                  location.reload();
               }
         });
      })
   })
</script>