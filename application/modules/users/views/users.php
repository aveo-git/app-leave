<div class="segment" style="min-height: 75vh">
    <h6 class="py-2 border-bottom text-uppercase d-flex align-items-center justify-content-between">
        <div>Liste de tout les congés (Par utilisateur)</div>
        <div><button class="btn btn-secondary" id="report_button" data-toggle="modal" data-target="#report_modal">RAPPORT</button></div>
    </h6>
    <form action="">
        <select class="form-control" id="lv-selectuser" name="id_user" aria-describedby="lv-selectuser" required="required">
            <option value="all" selected>Tous...</option>
            <?php foreach ($users as $u) : ?>
                <option value="<?= $u->l_idUser ?>"><?= $u->username ?></option>
            <?php endforeach ?>
        </select>
    </form>
    <br>
    <!-- LEAVES LIST -->
    <table id="leaves_data" class="table table-striped table-bordered compact dataTable no-footer" role="grid" aria-describedby="datatable_info" style="width: 100%">
        <thead>
            <tr role="row">
                <th></th>
                <th>Type</th>
                <th>Nom et Prénom</th>
                <th>Debut</th>
                <th>Fin</th>
                <th>Responsable</th>
                <th># Pris</th>
                <th># Restant</th>
                <th># Dispo</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
    <!-- /LEAVES LIST -->
    <hr>
    <div>
        <button type="button" class="btn btn-danger" id="deletealluser-button" data-toggle='modal' data-target='#delete_leave_modal'>Supprimer</button>
    </div>
    <br>
</div>

<!-- Les modals ------------------------------------------------------------------------------------------------------------------------------------------------------->

<!-- Modal pour Supprimer un congé -->
<div class="modal fade" id="delete_leave_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="deleteUser" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUser">Suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="alert-content">Vous-êtes sur de vouloir supprimer le congé?</span>
                <form action="" id="delete_user_form">
                    <input type="hidden" name="id_user" id="input_id_user" data-value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Retour</button>
                <button type="button" class="btn btn-primary" id="delete_leave_confirm">Valider</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour Imprimer un congé -->
<div class="modal fade" id="print_leave_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="deleteUser" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 827px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printLeave">Imprimer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="print_content" style="height: 85vh; padding: 10px 50px">
                <div>
                    <img src="<?= base_url() . '/assets/images/logo-aveolys.png' ?>" style="width: 150px" alt="">
                </div>
                <h1>Demande de congé</h1>
                <div class="motif">Motif</div>
                <div class="item">
                    <span>Nom de l'employé : </span><span class="value">Rasolonirina Dimby</span>
                </div>
                <div class="item">
                    <span>Référence : </span><span class="value">09-1255-AVEO</span>
                    <span>Service : </span><span class="value">Dev Web et Graphiste</span>
                </div>
                <div class="item">
                    <span>Type de congé : </span><span class="value">Congé</span>
                </div>
                <div class="item">
                    <span>Date du : </span><span class="value">02 Juillet 2022 à 08h00</span>
                    <span>Au : </span><span class="value">02 Juillet 2022 à 17h00</span>
                </div>
                <div class="item">
                    <span>Droits disponibles : </span><span class="value">43</span>
                    <span>Nombre de jour pris : </span><span class="value">04</span>
                    <span>Droits restant : </span><span class="value">39</span>
                </div>
                <div class="item">
                    Vous devez soumettre vos demandes de congé (à l'exception des congés maladies) deux jours avant leur date effective. Les
                    congés pour raison exceptionnelle doivent être accompagnés d'un justificatif (médical, mariage, naissance, décès, ...).
                </div>
                <hr>
                <div style="display: flex;">
                    <div style="width: 80%">Signature de l'employé</div>
                    <div>Date</div>
                </div>
                <div style="display: flex;">
                    <div style="width: 75%"></div>
                    <div>12 Juillet 2022</div>
                </div>
                <br><br>
                <div class="motif">Décision du responsable</div>
                <div class="item"><span style="background-color: #bdffc0; padding: 1px 5px; border-radius: 5px">Accordé</span></div>
                <div class="item">Commentaires : </div>
                <br><br>
                <hr>
                <div style="display: flex;">
                    <div style="width: 80%">Signature de l'employé</div>
                    <div>Date</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Retour</button>
                <button type="button" class="btn btn-primary" onclick="generatePDF()">Imprimer</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal pour Supprimer un utilisateur -->
<div class="modal fade" id="report_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="report" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="report">Rapport mensuel : <small id="month_report"></small></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- LEAVES LIST -->
                <table id="report_data" class="table table-striped table-bordered compact dataTable no-footer" role="grid" aria-describedby="datatable_info" style="width: 100%">
                    <thead>
                        <tr role="row">
                            <th>Nom et Prénom</th>
                            <th># Pris du mois</th>
                            <th># Restant</th>
                        </tr>
                    </thead>
                </table>
                <!-- /LEAVES LIST -->
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- Fin modal ----------------------------------------------------- -->

<script>
    let months = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
    let action_userad = function(id) {
        return `
            <div class="text-center">
                <span class="lv-action-button print" data-toggle='modal' data-target='#print_leave_modal' data-value="` + id + `" title="Imprimer le congé"><ion-icon name="print-outline"></ion-icon></span>
            </div>
        `;
    }

    $('#report_button').on('click', function(e) {
        $('#report_data').DataTable().destroy();
        let date_now = new Date();
        $('#month_report').html(months[date_now.getMonth()]);
        e.preventDefault();
        $.ajax({
            url: '<?= site_url('users/report_leaves') ?>',
            type: "POST",
            data: null,
            dataType: "json",
            success: function(data) {
                $('#report_data').DataTable({
                    "data": data,
                    "columns": [{
                            "data": null,
                            render: function(item) {
                                return item.u_prenom + " " + item.u_nom;
                            }
                        },
                        {
                            "data": 'nbPris'
                        },
                        {
                            "data": null,
                            render: function(item) {
                                if (item.leave_ant != null) {
                                    text = `dont ${item.leave_ant} jour(s) validé(s) le mois prochain`;
                                    return item.u_dispo + " <span title='" + text + "' style='cursor: pointer'><ion-icon name='alert-circle-outline'  class='disabled'></ion-icon></span>"
                                }
                                return item.u_dispo
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
                            "first": "Premier",
                            "last": "Dernier",
                            "next": "Suivant",
                            "previous": "Précedent"
                        },
                    },
                    "dom": "",
                    // "dom": 'dli',
                    "bFilter": true,
                });
            }
        })
    })

    $('#lv-selectuser').on('change', function(e) {
        $('#leaves_data').DataTable().destroy();
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('users/select_leaves') ?>",
            type: "POST",
            data: {
                idUser: $(this).val()
            },
            dataType: "json",
            success: function(data) {
                $('#leaves_data').DataTable({
                    "data": data,
                    "columns": [{
                            "data": null,
                            render: function(item) {
                                return '<input type="checkbox" name="' + item.id_leave + '" id="' + item.id_leave + '" />'
                            }
                        },
                        {
                            "data": 'l_type'
                        },
                        {
                            "data": 'l_idUser'
                        },
                        {
                            "data": null,
                            render: function(item) {
                                return item.l_dateDepart;
                            }
                        },
                        {
                            "data": null,
                            render: function(item) {
                                return item.l_dateFin;
                            }
                        },
                        {
                            "data": 'l_responsable'
                        },
                        {
                            "data": 'l_nbJpris'
                        },
                        {
                            "data": 'l_nbJrest'
                        },
                        {
                            "data": 'l_nbJdispo'
                        },
                        {
                            "data": null,
                            render: function(item) {
                                return item.l_statut === '1' ? '<span style="background-color: #bdffc0; padding: 1px 5px; border-radius: 5px">Validé</span>' : '<span style="background-color: #ffb2ba; padding: 1px 5px; border-radius: 5px">Refusé</span>';
                            }
                        },
                        {
                            "data": null,
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
                            "first": "Premier",
                            "last": "Dernier",
                            "next": "Suivant",
                            "previous": "Précedent"
                        },
                    },
                    "dom": "<'d-flex by-center w-100 py-3'<i><'text-right'f>>t<'d-flex by-center w-100 py-3'<'col text-left'l><'col text-right'p>>",
                    // "dom": 'dli',
                    "bFilter": true,
                    "lengthMenu": [
                        [10, 25, 50, 100, -1],
                        [10, 25, 50, 100, 'Tous']
                    ],
                });
            }
        })
    })

    let table_leaves = $('#leaves_data').DataTable({
        "ajax": '<?= site_url('users/list_leaves') ?>',
        "columns": [{
                "data": null,
                render: function(item) {
                    return '<input type="checkbox" name="' + item.id_leave + '" id="' + item.id_leave + '" />'
                }
            },
            {
                "data": 'l_type'
            },
            {
                "data": 'l_idUser'
            },
            {
                "data": null,
                render: function(item) {
                    return item.l_dateDepart;
                }
            },
            {
                "data": null,
                render: function(item) {
                    return item.l_dateFin;
                }
            },
            {
                "data": 'l_responsable'
            },
            {
                "data": 'l_nbJpris'
            },
            {
                "data": 'l_nbJrest'
            },
            {
                "data": 'l_nbJdispo'
            },
            {
                "data": null,
                render: function(item) {
                    return item.l_statut === '1' ? '<span style="background-color: #bdffc0; padding: 1px 5px; border-radius: 5px">Validé</span>' : '<span style="background-color: #ffb2ba; padding: 1px 5px; border-radius: 5px">Refusé</span>';
                }
            },
            {
                "data": null,
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
                "first": "Premier",
                "last": "Dernier",
                "next": "Suivant",
                "previous": "Précedent"
            },
        },
        "dom": "<'d-flex by-center w-100 py-3'<i><'text-right'f>>t<'d-flex by-center w-100 py-3'<'col text-left'l><'col text-right'p>>",
        // "dom": 'dli',
        "bFilter": true,
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'Tous']
        ],
    });

    $('#leaves_data tbody').on('click', 'span', function() {
        let tr = $(this).parents('tr');
        let leave = table_leaves.row(tr).data();
        if ($(this).hasClass('print')) {

        }
    })

    $('#delete_leave_confirm').on('click', function(e) {
        e.preventDefault();
        ajax_func($('#delete_user_form').serializeArray(), "users/delete_leaves");
    })

    $('#deletealluser-button').on('click', function(e) {
        e.preventDefault();
        $('#alert-content').html('Vous êtes sûr de vouloir supprimer les congés sélectionnés?');
        let data = $('#leaves_data tbody td.sorting_1 input:checked');
        let ids = [];
        if (data.length < 1) {
            $('#alert-content').html('Aucun congé sélectionner. Choisissez au moins un.');
            $('#delete_leave_confirm').prop('disabled', true)
        } else {
            $('#delete_leave_confirm').prop('disabled', false)
            for (let i = 0; i < data.length; i++) {
                ids.push(data[i].name)
            }
            $('#input_id_user').val(ids)
        }
    });

    async function generatePDF() {
        let downloading = document.getElementById('print_content');
        let doc = new jsPDF({
            orientation: 'p',
            unit: 'pt',
            format: 'a4',
            putOnlyUsedFonts: true,
            precision: 10
        });
        await html2canvas(downloading, {
            width: 830
        }).then((canvas) => {
            doc.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, 600, 700);
        })
        doc.save('conge.pdf');
    }
</script>