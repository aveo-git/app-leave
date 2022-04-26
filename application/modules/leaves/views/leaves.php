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
    <?php if(count($leaves) != 0): ?>
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
    <?php else: ?>
        <div class="empty-data">
            <div class="text-center">
                <div><img src="<?= base_url().'/assets/images/empty-data.PNG' ?>" alt=""></div>
                <div>Aucun congé.</div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    let leaves = <?= json_encode((array) $leaves) ?>;
    let months = ['Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Decembre'];
    let formDate = function(date) {
        return with_zero(new Date(date).getDate())+' '+months[new Date(date).getMonth()]+' à '+with_zero(new Date(date).getHours())+':'+with_zero(new Date(date).getMinutes());
    }
    let with_zero = (n) => {
        return n < 10 ? ("0"+n) : n;
    }
    console.dir(leaves);

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
            count += parseInt(element.l_nbJpris, 10);
        });
        data.total = with_zero(count);
        return data;
    }

    // Lister par mois les congés
    let temp = [];
    function tsy_haiko(l) {
        if(l.length != 0) {
            let l_temp = _.filter(l, function(d) {
                    return (new Date(d.l_dateAjout).getMonth()+1) === new Date(l[0].l_dateAjout).getMonth()+1;
                });
            temp.push(retrieve_leave(l_temp));
            tsy_haiko(_.difference(l, l_temp))
        }
    }
    tsy_haiko(leaves)

    // Ajout des congés dans le dom
    temp.forEach((item, index) => {
        let str = '';
        let show = (temp.length == (index+1)) ? ' show' : '';

        item.leaves.forEach(l => {
            let icon = l.statut == '1' ? '<ion-icon name="checkmark-circle"></ion-icon>' : '<ion-icon name="close-circle"></ion-icon>';
            str += `<li>
                        `+l.debut+` - `+l.fin+` : `+l.type+` | 
                        Droits disponibles : `+l.dispo+` | 
                        Jour pris : <span style="color: #ee5644">`+l.pris+`</span> | 
                        Droit restant : `+l.rest+` 
                        `+icon+`
                    </li>`
        });
        $('#accordion').append(`
            <div class="card">
                <div class="card-header" id="heading`+index+`">
                    <div class="d-flex by-center">
                        <div>
                            <span class="mounth">`+item.month+`</span>
                            <span class="value">`+item.total+`</span>
                        </div>
                        <div class="">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapse`+index+`" aria-expanded="true" aria-controls="collapseOne">
                                    <ion-icon name="chevron-back-circle"></ion-icon>
                                </button>
                            </h5>
                        </div>
                    </div>
                </div>
    
                <div id="collapse`+index+`" class="collapse`+show+`" aria-labelledby="heading`+index+`" data-parent="#accordion">
                    <div class="card-body">
                        <ul style="margin-left: -15px">
                            `+str+`
                        </ul>
                    </div>
                </div>
            </div>
        `)
    });

    $('.button-date').on('click', function() {
        let date = '<?= $year ?>';
        let data = $(this).data('action') === 'next' ? [{name: 'year', value: parseInt(date, 10)+1}] : [{name: 'year', value: parseInt(date, 10)-1}];
        ajax_func(data, 'leaves/set_date');
    })

</script>