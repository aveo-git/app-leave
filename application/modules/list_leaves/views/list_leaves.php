<?php
    function set_date($d) {
        $date_arr = explode(' ', $d);
        $heure_arr = explode(':', $date_arr[1]);
        return $date_arr[0]." à ".$heure_arr[0].":".$heure_arr[1];
    }
    $waiting = count($leaves);
?>

<div class="segment"><br>
    <div class="d-flex">
        <div class="border-right" style="padding-right: 25px; max-width: 290px;width: 290px; min-height: 70vh">
            <h6 class="py-2">Liste des congés en attente</h6>
            <?php if($waiting == 0): ?>
            <div class="text-left">
                <div class="d-flex align-items-center"><ion-icon name="reader-outline" size="small"></ion-icon> &nbsp; Pas de congé en attente.</div>
            </div>
            <?php else: ?>
            <?php foreach($leaves as $l): ?>
            <div class="segment shadow-sm leave-item d-flex by-center waiting-item" data-value='<?= htmlspecialchars(json_encode((array) $l), ENT_QUOTES, 'UTF-8') ?>'>
                <div class="d-flex">
                    <div>
                        <img src="<?= base_url().'/assets/images/'.$l->l_idUser->u_avatar ?>" alt="profil-user" class="rounded-circle profil sm">
                    </div>
                    <div style="padding: 0 15px">
                        <div class="leave-item-name"><?= $l->l_idUser->u_prenom." ".$l->l_idUser->u_nom ?></div>
                        <div class="leave-item-sending">- Envoyé le <?= set_date($l->l_dateAjout) ?></div>
                    </div>
                </div>
                <div><ion-icon name="chevron-forward-circle"></ion-icon></div>
            </div>
            <?php endforeach ?>
            <?php endif ?>
        </div>
        <div class="w-100 d-flex" style="border-radius: 0px; padding-left: 10px; flex-direction: column; justify-content: center">
            <div class="waiting-none">
                <div class="text-center">
                    <div><img src="<?= base_url().'/assets/images/empty-data.PNG' ?>" alt=""></div>
                    <div>Veuillez selectionnez un congé.</div>
                </div>
            </div>
            <div class="waiting-all">
                <div class="text-center"><img src="" alt="profil-user" class="rounded-circle profil sm"></div>
                <div class="text-center leave-item-sending p-2">Envoyé le <span id="date-send"></span></div>
                <br>
                <form id="waiting-form">
                    <input type="hidden" name="id_leave" id="id-leave">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-prenom">Prénom</label>
                                <input type="text" class="form-control" id="lv-prenom" value="Dimby" name="u_prenom" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-nom">Nom</label>
                                <input type="text" class="form-control" id="lv-nom" name="u_nom" value="RASOLONIRINA" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-reference">Réference</label>
                                <input type="text" class="form-control" id="lv-reference" value="001-AVEO-2019" name="u_reference" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-service">Service</label>
                                <input type="text" class="form-control" id="lv-service" value="Dev Web et Graphiste" name="u_service" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-type">Type de congé</label>
                                <input type="text" class="form-control" id="lv-type" value="Congé" name="l_type" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-dateDepart">Le :</label>
                                <input type="text" class="form-control" id="lv-dateDepart" value="12/02/2022 à 08:00" name="l_dateDepart" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-dateFin">Jusqu'au :</label>
                                <input type="text" class="form-control" id="lv-dateFin" value="12/02/2022 à 17:00" name="l_dateFin" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-dispo">Disponible</label>
                                <input type="text" class="form-control" id="lv-dispo" value="23" name="l_nbJdispo" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-pris">Jour(s) pris</label>
                                <input type="text" class="form-control" id="lv-pris" value="1" name="l_nbJpris" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-rest">Jour(s) restant</label>
                                <input type="text" class="form-control" id="lv-rest" value="22" name="l_nbJrest" disabled>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" id="valide-leave">Valider</button>
                        <button type="button" class="btn btn-secondary" id="refuse-leave">Refuser</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>
</div>

<script>

    let set_date = (date) => {
        return date.slice(0, 16).replace(' ', ' à ')
    }

    if(!$('.waiting-item').hasClass('active')) {
        $('.waiting-none').show();
        $('.waiting-all').hide();
    }
    $('.waiting-item').on('click', function() {
        $('.waiting-item').removeClass('active')
        $(this).addClass('active');
        $('.waiting-none').hide();
        $('.waiting-all').show();

        let data = $(this).data('value')
        // console.dir(data);
        $('#waiting-form #id-leave').val(data.id_leave)
        $('#waiting-form #lv-nom').val(data.l_idUser.u_nom)
        $('#waiting-form #lv-prenom').val(data.l_idUser.u_prenom)
        $('#waiting-form #lv-reference').val(data.l_idUser.u_reference)
        $('#waiting-form #lv-service').val(data.l_idUser.u_idService.s_label)
        $('#waiting-form #lv-type').val(data.l_type)
        $('#date-send').html(set_date(data.l_dateAjout))
        $('#waiting-form #lv-dateDepart').val(set_date(data.l_dateDepart))
        $('#waiting-form #lv-dateFin').val(set_date(data.l_dateFin))
        $('#waiting-form #lv-dispo').val(set_date(data.l_nbJdispo))
        $('#waiting-form #lv-pris').val(set_date(data.l_nbJpris))
        $('#waiting-form #lv-rest').val(set_date(data.l_nbJrest))
        $('.waiting-all img').attr('src', '<?= base_url().'/assets/images/' ?>'+data.l_idUser.u_avatar)
    })

    $('#valide-leave').on('click', function() {
        let data = [
            {name: 'id_leave', value: $('#waiting-form #id-leave').val()},
            {name: 'l_statut', value: 1}
        ]
        ajax_func(data, 'list_leaves/valid_conge');
    })

    $('#refuse-leave').on('click', function() {
        let data = [
            {name: 'id_leave', value: $('#waiting-form #id-leave').val()},
            {name: 'l_statut', value: 2}
        ]
        ajax_func(data, 'list_leaves/valid_conge');
    })
</script>