<div class="segment leaves" style="height: 80vh">
    <div class="d-flex by-center" style="border-bottom: 1px solid rgba(0, 0, 0, 0.1)">
        <h6 class="py-2">Liste des congés planifiés</h6>
    </div>
    <br>
    <?php if (count($leaves) != 0) : ?>
        <div>
            <div class="d-flex by-center pb-1">
                <div>
                    <span style="padding: 0 20px; width: 140px; display: inline-block">Mois</span>
                    <span style="padding: 0 20px; width: 160px; display: inline-block">Nb de jours pris</span>
                </div>
            </div>
        </div>
        <div id="accordion">
        </div>
    <?php else : ?>
        <div class="empty-data">
            <div class="text-center">
                <div><img src="<?= base_url() . '/assets/images/empty-data.PNG' ?>" alt=""></div>
                <div>Aucun congé.</div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal pour Supprimer un congé -->
<div class="modal fade" id="delete_planned_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="deleteUser" aria-hidden="true">
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


<script>
    let leaves = <?= json_encode((array) $leaves) ?>;
    let isAdmin = <?= json_encode($isAdmin) ?>;
    let months = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
    let formDate = function(date) {
        return with_zero(new Date(date).getDate()) + ' ' + months[new Date(date).getMonth()] + ' à ' + with_zero(new Date(date).getHours()) + ':' + with_zero(new Date(date).getMinutes());
    }
    let with_zero = (n) => {
        return n < 10 && n >= 1 || n == 0 ? ("0" + n) : n;
    }

    // Formaliser les congés
    function retrieve_leave(l) {
        let count = 0;
        let data = {
            month: months[new Date(l[0].l_dateDepart).getMonth()],
            leaves: [],
        };
        l.forEach(element => {
            data.leaves.push({
                id: element.id_leave,
                debut: formDate(element.l_dateDepart),
                fin: formDate(element.l_dateFin),
                type: element.l_type,
                dispo: element.l_nbJdispo,
                pris: with_zero(element.l_nbJpris),
                rest: element.l_nbJrest,
                statut: element.l_statut,
                user: element.u_prenom + " " + element.u_nom
            })
            if (element.l_statut != "2")
                count += parseFloat(element.l_nbJpris, 10);
        });
        data.total = with_zero(count);
        return data;
    }

    // Lister par mois les congés
    let temp = [];

    function tsy_haiko(l) {
        if (l.length != 0) {
            let l_temp = _.filter(l, function(d) {
                return (new Date(d.l_dateDepart).getMonth() + 1) === new Date(l[0].l_dateDepart).getMonth() + 1;
            });
            temp.push(retrieve_leave(l_temp));
            tsy_haiko(_.difference(l, l_temp))
        }
    }
    tsy_haiko(leaves)

    // // Ajout des congés dans le dom
    // console.dir(leaves);
    temp.forEach((item, index) => {
        let str = '';
        let show = (temp.length == (index + 1)) ? ' show' : '';

        item.leaves.forEach(l => {
            let icon = '';
            switch (l.statut) {
                case '1':
                    icon = ' <span class="btn-valide">validé</span>';
                    break;
                case '2':
                    icon = ' <span class="btn-refused" style="background-color: #ffb2ba; padding: 1px 5px; border-radius: 5px">refusé</span>';
                    break;
                default:
                    icon = ' <span class="btn-refused" style="background-color: #f5e86f; padding: 1px 5px; border-radius: 5px">En attente ...</span>';
                    break;
            }

            str += `<li>
                        `+ (isAdmin ? l.user + " => " : "") +  l.debut + ` - ` + l.fin + ` : ` + l.type + ` | 
                        Jour pris : <span style="color: #ee5644">` + l.pris + `</span> | &nbsp;&nbsp;
                        ` + icon + ` ${isAdmin ? `<span style='float:right' class="btn-delete-planned" data-toggle='modal' data-target='#delete_planned_modal' data-value="`+l.id+`" title="Supprimer le congé"><ion-icon class="disabled" name="trash-outline"></ion-icon></span>` : ""}
                    </li>`
        });
        $('#accordion').append(`
            <div class="card">
                <div class="card-header" id="heading` + index + `">
                    <div class="d-flex by-center">
                        <div>
                            <span class="aitem">` + item.month + `</span>
                            <span class="aitem">` + item.total + `</span>
                        </div>
                        <div class="">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse` + index + `" aria-expanded="true" aria-controls="collapseOne">
                                    <ion-icon name="chevron-back-circle"></ion-icon>
                                </button>
                            </h5>
                        </div>
                    </div>
                </div>
    
                <div id="collapse` + index + `" class="collapse` + show + `" aria-labelledby="heading` + index + `" data-parent="#accordion">
                    <div class="card-body">
                        <ul style="margin-left: -15px">
                            ` + str + `
                        </ul>
                    </div>
                </div>
            </div>
        `)
    });


    $(".btn-delete-planned").on('click',function(){
        const id = $(this).data().value
        $('#input_id_user').val(id)
    })

    $('#delete_leave_confirm').on('click', function(e) {
        e.preventDefault();
        ajax_func($('#delete_user_form').serializeArray(), "users/delete_leaves");
    })


    $('.button-date').on('click', function() {
        let date = '<?= $year ?>';
        let data = $(this).data('action') === 'next' ? [{
            name: 'year',
            value: parseInt(date, 10) + 1
        }] : [{
            name: 'year',
            value: parseInt(date, 10) - 1
        }];
        ajax_func(data, 'leaves/set_date');
    })
</script>