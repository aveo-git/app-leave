<div class="segment" style="min-height: 75vh">
    <h5>Liste des congés</h5>
    <div class="row justify-content-between">
        <select class="form-control col-md-6" id="lv-selectuser" name="id_user" aria-describedby="lv-selectuser" required="required">
            <option value="" selected>Tous...</option>
            <?php foreach ($users as $u) : ?>
                <option value="<?= $u->id_user ?>"><?= $u->username ?></option>
            <?php endforeach ?>
        </select>
        <input class="form-control col-md-4" type="month" id="month">
    </div>
    <br>
    <!-- LEAVES LIST -->
    <table id="leaves_data" class="table table-striped table-bordered compact dataTable no-footer" role="grid" aria-describedby="datatable_info" style="width: 100%">
        <thead>
            <tr role="row">
                <th></th>
                <th>Date</th>
                <th>Nom et Prénom</th>
                <th># Dispo</th>
                <th># Pris</th>
                <th># Restant</th>
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

    let formDate = function(date) {
        return with_zero(new Date(date).getDate()) + ' ' + months[new Date(date).getMonth()] + ' à ' + with_zero(new Date(date).getHours()) + ':' + with_zero(new Date(date).getMinutes());
    }
    let with_zero = (n) => {
        return n < 10 && n >= 1 || n == 0 ? ("0" + n) : n;
    }

    // reload on filter
    $('#lv-selectuser').on('change', function(e) {
        table_leaves.ajax.reload()
    })

    $('#month').on('change', function(e) {
        table_leaves.ajax.reload()
    })

    // list leave 
    let table_leaves = $('#leaves_data').DataTable({
        "ajax": {
            'url':'<?= site_url('history') ?>',
            'type': 'POST',
            'data':function(d){
                d.user = $('#lv-selectuser').val()
                const dt = new Date($('#month').val())
                const date = new Date(dt.getFullYear(),dt.getMonth() - 1,1);
                d.date = $('#month').val() === "" ? "" : date.getFullYear() + "-" + (date.getMonth() + 1)
            }
                
        },
        'columnDefs': [
            {
                "targets": [3,4,5],
                "className": "text-center",
            },
        ],
        "columns": [
            {
                className: 'details-control',
                orderable: false,
                data: null,
                defaultContent: '+'
            },
            {
                "data": null,
                render: function(item) {
                    const d = new Date(item.date)
                    const date = new Date(d.getFullYear(),d.getMonth() + 1,1);
                    return  months[date.getMonth()] + ", "+ date.getFullYear();
                }
            },
            {
                "data": null,
                render: function(item) {
                    return item.u_prenom + " " + item.u_nom;
                }
            },
            {
                "data": "nb",
                "center":true
            },
            {
                "data": null,
                render: function(item) {
                    return item.pris || "0";
                }
            },
            {
                "data": null,
                render: function(item) {
                    return item.nb - item.pris;
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
        "bFilter": true,
        "lengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'Tous']
        ],
    });

    // expande to show leave details
    $('#leaves_data tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table_leaves.row(tr);
        if (row.child.isShown()) {
            row.child.hide();
            tr[0].children[0].innerHTML = "+"
            tr.removeClass('shown');
        } else {
            tr[0].children[0].innerHTML = "-"
            var user = row.data();
            const isAnterior = new Date(user.date).getMonth() < (new Date().getMonth() - 1);
            var leaves = user.leaves.map(function(leave) {
                return `<tr>
                            <td class="select_leave"><input type="checkbox" ${isAnterior ? "disabled":""} name="${ leave.id_leave}" id="${leave.id_leave}" /></td>
                            <td>${leave.l_type}</td>
                            <td>${formDate(leave.l_dateAjout)}</td>
                            <td>${formDate(leave.l_dateDepart)}</td>
                            <td>${formDate(leave.l_dateFin)}</td>
                            <td>${leave.l_responsable}</td>
                            <td class="text-center">${leave.l_nbJpris}</td>
                            <td>${leave.l_statut === '1' ? '<span style="background-color: #bdffc0; padding: 1px 5px; border-radius: 5px">Validé</span>' : '<span style="background-color: #ffb2ba; padding: 1px 5px; border-radius: 5px">Refusé</span>'}</td>
                        </tr>`;
            }).join('');
            if(leaves.length > 0){
                row.child(`<table cellpadding="5" cellspacing="0" border="0" style="width:100%;background-color:ghostwhite">
                        <tr>
                            <th></th>
                            <th>Type</th>
                            <th>Crée en</th>
                            <th>Debut</th>
                            <th>Fin</th>
                            <th>Responsable</th>
                            <th># Pris</th>
                            <th>Statut</th>
                        </tr>
                        <tbody>
                        ${leaves}
                        </tbody>
                       </table>`).show();
            }else{
                row.child(`<p class="text-center">Aucune donnée disponible.</p>`).show();
            }
            
            tr.addClass('shown');
        }
    });

    $('#delete_leave_confirm').on('click', function(e) {
        e.preventDefault();
        ajax_func($('#delete_user_form').serializeArray(), "users/delete_leaves");
    })

    // delete leave
    $('#deletealluser-button').on('click', function(e) {
        e.preventDefault();
        $('#alert-content').html('Vous êtes sûr de vouloir supprimer les congés sélectionnés?');
        let data = $('.select_leave input:checked');
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