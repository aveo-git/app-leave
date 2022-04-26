<div class="segment" style="min-height: 75vh">
    <h6 class="py-2 border-bottom text-uppercase">Liste de tout les congés (Par utilisateur)</h6>
    <form action="">
        <select class="form-control" id="lv-selectuser" name="id_user" aria-describedby="lv-selectuser" required="required">
            <option value="all" selected>Tous...</option>
            <?php foreach($users as $u): ?>
                <option value="<?= $u->l_idUser ?>"><?= $u->username ?></option>
            <?php endforeach ?>
        </select>
    </form>
    <br>
    <!-- USER LIST -->
    <table id="leaves_data" class="table table-striped table-bordered compact dataTable no-footer" role="grid" aria-describedby="datatable_info" style="width: 100%">
        <thead>
            <tr role="row">
                <th>Type</th>
                <th>Nom et Prénom</th>
                <th>Debut</th>
                <th>Fin</th>
                <th>Responsable</th>
                <th># Pris</th>
                <th># Restant</th>
                <th># Dispo</th>
                <th>Statut</th>
            </tr>
        </thead>
    </table>
    <!-- /USER LIST -->
</div>

<script>

    $('#lv-selectuser').on('change', function(e){
        $('#leaves_data').DataTable().destroy();
        e.preventDefault();
        $.ajax({
            url: "<?= site_url('users/select_leaves') ?>",
            type: "POST",
            data: {idUser: $(this).val()},
            dataType: "json",
            success: function(data) {
                $('#leaves_data').DataTable({
                    "data": data,
                    "columns": [
                        {"data": 'l_type'},
                        {"data": 'l_idUser'},
                        {"data": null,
                            render: function(item) {
                                return item.l_dateDepart;
                            } 
                        },
                        {"data": null,
                            render: function(item) {
                                return item.l_dateFin;
                            } 
                        },
                        {"data": 'l_responsable'},
                        {"data": 'l_nbJpris'},
                        {"data": 'l_nbJrest'},
                        {"data": 'l_nbJdispo'},
                        {"data": null,
                            render: function(item) {
                                return item.l_statut === '1' ? 'Validé' : 'Refusé';
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
            }
        })
    })

    let table_leaves = $('#leaves_data').DataTable({
        "ajax": '<?= site_url('users/list_leaves') ?>',
        "columns": [
            {"data": 'l_type'},
            {"data": 'l_idUser'},
            {"data": null,
                render: function(item) {
                    return item.l_dateDepart;
                } 
            },
            {"data": null,
                render: function(item) {
                    return item.l_dateFin;
                } 
            },
            {"data": 'l_responsable'},
            {"data": 'l_nbJpris'},
            {"data": 'l_nbJrest'},
            {"data": 'l_nbJdispo'},
            {"data": null,
                render: function(item) {
                    return item.l_statut === '1' ? 'Validé' : 'Refusé';
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
</script>