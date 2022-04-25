
<?php $test = false ?>
<div class="content">
    <?php if($test): ?>
    <div class="d-flex xy-center" style="height: 60vh">
        <div class="text-center">
            <div><img src="<?= base_url().'/assets/images/empty-data.PNG' ?>" alt=""></div>
            <div>Pas de données. <br> Veuillez importer ou ajouter.</div>
        </div>
    </div>
    <?php else: ?>
        <div>
            <!-- USER LIST -->
            <table id="userad_data" class="table table-striped table-bordered compact dataTable no-footer" role="grid" aria-describedby="datatable_info" style="width: 100%">
                <thead>
                    <tr role="row">
                        <th style="width: 4%; text-align: center"><input type="checkbox" name="" id=""></th>
                        <th>Pseudo</th>
                        <th>Nom et Prénom</th>
                        <th>Service</th>
                        <th>Dispo</th>
                        <th class="text-center">Statut</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
            </table>
            <!-- /USER LIST -->
        </div>
    <?php endif ?>
</div>
<div>
    <hr>
    <button type="submit" class="btn btn-secondary" id="importAd-button">Importer</button>
    <button type="button" class="btn btn-danger" id="deleteAll-button" data-toggle='modal' data-target='#delete_user_modal'>Supprimer</button>
    <button type="button" class="btn btn-secondary float-right" id="add_user" data-toggle='modal' data-target='#edit_user_modal'>Ajouter</button>
    <br><br>
</div>

<!-- Les modals ------------------------------------------------------------------------------------------------------------------------------------------------------->

<!-- Modal pour modifier un collaborateur -->
<div class="modal fade" id="edit_user_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="editUser" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editUser"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
        <form id="edituser-form">
            <div class="modal-body py-1">
                <div class="lv-content">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="lv-id_user" value="" name="id_user" aria-describedby="lv-id_user">
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="lv-pseudo">Pseudo</label>
                            <input type="text" class="form-control" id="lv-pseudo" value="" name="u_pseudo" aria-describedby="lv-pseudo" required="required">
                        </div>
                        <div class="form-group col">
                            <label for="lv-email">Adresse électronique</label>
                            <input type="text" class="form-control" id="lv-email" value="" name="u_email" aria-describedby="lv-email" required="required">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="lv-prenom">Prénom</label>
                            <input type="text" class="form-control" id="lv-prenom" value="" name="u_prenom" aria-describedby="lv-prenom" required="required">
                        </div>
                        <div class="form-group col">
                            <label for="lv-nom">Nom</label>
                            <input type="text" class="form-control" id="lv-nom" value="" name="u_nom" aria-describedby="lv-nom" required="required">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="lv-service">Service</label>
                            <select class="form-control" id="lv-service" name="id_service" aria-describedby="lv-service" required="required">
                                <?php foreach($services as $s): ?>
                                    <option value="<?= $s->s_label ?>" data-label="<?= $s->id_service ?>"><?= $s->s_label ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label for="lv-reference">Référence (facultatif)</label>
                            <input type="text" class="form-control" id="lv-reference" value="" name="u_reference" aria-describedby="lv-reference">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label for="lv-dispo">Droit de départ (Droit disponible)</label>
                            <input type="number" class="form-control" id="lv-dispo" value="" name="u_dispo" aria-describedby="lv-dispo" required="required">
                        </div>
                        <div class="form-group col">
                            <label for="lv-dispoYear">Droit fin d'année</label>
                            <input type="number" class="form-control" id="lv-dispoYear" value="" name="u_dispoYear" aria-describedby="lv-dispoYear">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" type="button" class="btn btn-secondary close" data-dismiss="modal">Annuler</a>
                <button type="submit" class="btn btn-primary" id="save_user">Sauver</button>
            </div>
        </form>
    </div>
  </div>
</div>

<!-- Modal pour Supprimer un utilisateur -->
<div class="modal fade" id="delete_user_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="deleteUser" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteUser">Suppression</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <span id="alert-content">Vous-êtes sur de vouloir supprimer l'utilisateur?</span>
            <form action="" id="delete_user_form">
                <input type="hidden" name="id_user" id="input_id_user" data-value="">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Retour</button>
            <button type="button" class="btn btn-primary" id="delete_user_confirm">Valider</button>
        </div>
        </div>
    </div>
</div>


<!-- Fin modal ----------------------------------------------------- -->

<script>

    let active_user = function(status) {
        let toogleButton = (status == '1') ? "<ion-icon class='disabled' name='toggle' size='large' style='color: #02C1CE;'></ion-icon>" : "<ion-icon class='disabled' name='toggle-outline' size='large' style='color : #dfdfdf; transform: rotate(180deg);'></ion-icon>";

        return `
            <div class="toogle_compte text-center" data-toggle='modal' data-target='#toggle_compte_modal' style="cursor: pointer" title="Changer le statut de l'utilisateur">
                `+ toogleButton +`
            </div>
        `;
    }
    let action_userad = function(id) {
        return `
            <div class="text-center">
                <span class="lv-action-button edit" data-toggle='modal' data-target='#edit_user_modal' data-value="`+id+`" title="Modifier l'utilisateur"><ion-icon class="disabled" title="Modifier" name="create-outline"></ion-icon></span>
                <span class="lv-action-button trash" data-toggle='modal' data-target='#delete_user_modal' data-value="`+id+`" title="Supprimer l'utilisateur"><ion-icon class="disabled" name="trash-outline"></ion-icon></span>
            </div>
        `;
    }

    let table_userad = $('#userad_data').DataTable({
        "ajax": '<?= site_url('params/list_user') ?>',
        "columns": [
            {"data": null,
                render: function(item) {
                    return '<input type="checkbox" name="'+item.id_user+'" id="'+item.u_pseudo+'" />'
                }
            },
            {"data": 'u_pseudo'},
            {"data": null,
                render: function(item) {
                    return "<img src=<?= base_url().'/assets/images/' ?>"+item.u_avatar+" width='15%' />"+" "+item.u_prenom+" "+item.u_nom;
                } 
            },
            {"data": 'u_idService'},
            {"data": 'u_dispo'},
            {"data": null,
                render: function(item) {
                    return active_user(item.u_status);
                }
            }, 
            {"data": null,
                render: function(item) {
                    return action_userad(item.id_user);
                }
            },
        ],
        "language": {
                "emptyTable": "Aucun Résultat",
                "infoEmpty": "Aucun enregistrement disponible",
                "zeroRecords": "Aucun Résultat",
                "infoFiltered": "",
                "lengthMenu": "Afficher : _MENU_",
                "info": "_END_ sur _MAX_ entrée(s)",
                'search': "Recherche : ",
                "paginate": {
                    "first":      "Premier",
                    "last":       "Dernier",
                    "next":       "Suivant",
                    "previous":   "Précedent"
                },
            },
        "dom": "<'d-flex by-center w-100 py-3'<i><'text-right'f>>t<'d-flex by-center w-100 py-3'<'col text-left'l><'col text-right'p>>",
        // "dom": 'dli',
        "bFilter": true,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Tous']],
    });

    $('#userad_data tbody').on('click', 'span', function() {
        let tr = $(this).parents('tr');
        let user = table_userad.row(tr).data();
        if($(this).hasClass('edit')) {
            $('#editUser').html('Modifier : '+user.u_prenom+' '+user.u_nom);
            $('#edituser-form #lv-id_user').val(user.id_user);
            $('#edituser-form #lv-u_idService').val(user.u_idService);
            $('#edituser-form #lv-pseudo').val(user.u_pseudo);
            $('#edituser-form #lv-email').val(user.u_email);
            $('#edituser-form #lv-prenom').val(user.u_prenom);
            $('#edituser-form #lv-nom').val(user.u_nom);
            $('#edituser-form #lv-service option[value="'+user.u_idService+'"]').attr('selected', 'selected');
            $('#edituser-form #lv-dispo').val(user.u_dispo);
            $('#edituser-form #lv-dispoYear').val(user.u_dispoYear);
        }
        if($(this).hasClass('trash')) {
            $('#input_id_user').val(user.id_user);
        }
    })

    $('#userad_data tbody').on('click', 'div.toogle_compte', function() {
        let tr = $(this).parents('tr');
        let user = table_userad.row(tr).data();
        let data = []
        data.push({name: 'id_user', value: user.id_user});
        data.push({name: 'u_status', value: !parseInt(user.u_status, 10)});
        ajax_func(data, 'params/toggle_status')
    })

    $('#delete_user_confirm').on('click', function(e) {
        e.preventDefault();
        ajax_func($('#delete_user_form').serializeArray(), "params/delete_user");
    })

    $('#edituser-form').on('submit', function(e) {
        e.preventDefault();
        let data = $(this).serializeArray();
        data.push({name: 'u_idService', value: $('#lv-service option:selected').data('label')})
        ajax_func(data, 'params/update_user');
    })

    $('#add_user').on('click', function(e) {
        e.preventDefault();
        $('#editUser').html('Ajouter un nouveau utilisateur');
    })
    $('#deleteAll-button').on('click', function(e) {
        e.preventDefault();
        $('#alert-content').html('Vous êtes sûr de vouloir supprimer les utilisateurs sélectionnés?');
        let data = $('#userad_data tbody td.sorting_1 input:checked');
        let ids = [];
        if(data.length < 1) {
            $('#alert-content').html('Aucun utilisateur sélectionner. Choisissez au moins un.');
            $('#delete_user_confirm').prop('disabled', true)
        } else {
            $('#delete_user_confirm').prop('disabled', false)
            for(let i = 0; i < data.length; i++) {
                ids.push(data[i].name)
            }
            $('#input_id_user').val(ids)
        }
    })



    $('#importAd-button').on('click', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('params/import_AD') ?>",
            method: "POST",
            data: null,
            beforeSend: function() {
                $(".progress").addClass('active');
            },
            success: function(msg) {
                $(".progress").removeClass('active');
                location.reload();
            }
        })
    })
</script>