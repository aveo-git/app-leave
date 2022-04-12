<div class="segment leaves">
    <div class="d-flex by-center">
        <h6 class="py-2">Liste des congés pris</h6>
        <h6 class="py-2 year">
            <ion-icon name="arrow-back-circle"></ion-icon>    
            <span>2022</span>
            <ion-icon name="arrow-forward-circle"></ion-icon>
        </h6>
    </div>
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
            month: months[new Date(l[0].l_dateAjout).getMonth()+1],
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
    console.dir(temp);

    // Ajout des congés dans le dom
    temp.forEach((item, index) => {
        let str = '';
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
    
                <div id="collapse`+index+`" class="collapse" aria-labelledby="heading`+index+`" data-parent="#accordion">
                    <div class="card-body">
                        <ul style="margin-left: -15px">
                            `+str+`
                        </ul>
                    </div>
                </div>
            </div>
        `)
    });

</script>