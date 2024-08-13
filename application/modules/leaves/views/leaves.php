<?php
$year_now = date('Y');
$disabled = $year_now == $year ? " disabled-button" : "";
?>
<div class="segment leaves" style="height: 80vh">
    <div class="d-flex by-center" style="border-bottom: 1px solid rgba(0, 0, 0, 0.1)">
        <h6 class="py-2">Liste des congés pris</h6>
        <h6 class="py-2 year">
            <ion-icon class="button-date" data-action="prev" name="arrow-back-circle"></ion-icon>
            <button class="btn btn-default"><?= $year ?></button>
            <ion-icon class="button-date <?= $disabled ?>" data-action="next" name="arrow-forward-circle"></ion-icon>
        </h6>
    </div>
    <br>
    <?php if (count($leaves) != 0) : ?>
        <div>
            <div class="d-flex by-center pb-1">
                <div>
                    <span style="padding: 0 20px; width: 140px; display: inline-block">Mois</span>
                    <span style="padding: 0 20px; width: 160px; display: inline-block">Nb de jours pris</span>
                    <span style="padding: 0 20px; width: 160px; display: inline-block">Solde</span>
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

<script>
    let leaves = <?= json_encode((array) $leaves) ?>;
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
                debut: formDate(element.l_dateDepart),
                fin: formDate(element.l_dateFin),
                type: element.l_type,
                dispo: element.l_nbJdispo,
                pris: with_zero(element.l_nbJpris),
                rest: element.l_nbJrest,
                statut: element.l_statut
            })
            if (element.l_statut != "2")
                count += parseFloat(element.l_nbJpris, 10);
        });
        data.total = with_zero(count);
        return data;
    }

    // // Ajout des congés dans le dom
    leaves.forEach((item, index) => {
        let str = '';
        let show = (item.leaves.length == (index + 1)) ? ' show' : '';
        const d = new Date(item.date)
        const date = new Date(d.getFullYear(),d.getMonth() + 1,1);
        item.leaves.forEach(l => {
            let icon = '';
            switch (l.l_statut) {
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
                        ` + formDate(l.l_dateDepart) + ` - ` + formDate(l.l_dateFin) + ` : ` + l.l_type + ` | 
                        Jour pris : <span style="color: #ee5644">` + l.l_nbJpris + `</span> | &nbsp;&nbsp;
                        ` + icon + `
                    </li>`
        });
        $('#accordion').append(`
            <div class="card">
                <div class="card-header" id="heading` + index + `">
                    <div class="d-flex by-center">
                        <div>
                            <span class="aitem">` + months[date.getMonth()] + `</span>
                            <span class="aitem">` + item.pris + `</span>
                            <span class="aitem">` + (item.nb - parseInt(item.pris)) + `</span>
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