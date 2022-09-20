<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= $style ?>
    <?= $script ?>
    <title>Application Congé - <?= $title ?></title>
</head>

<body>
    <script>
        let ajax_func = (data, url) => {
            $.ajax({
                url: "<?= base_url() . 'index.php/' ?>" + url,
                method: "POST",
                data: data,
                success: function(msg) {
                    location.reload();
                }
            })
        }
        let ajax_func_validate = (data, url) => {
            $.ajax({
                url: "<?= base_url() . 'index.php/' ?>" + url,
                method: "POST",
                data: data,
                beforeSend: function() {
                    $(".progress").addClass('active');
                },
                success: function() {
                    $(".progress").removeClass('active');
                    location.reload();
                }
            })
        }
    </script>

    <?php

    function get_entire_date($date)
    {
        $mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
        $d = explode("-", $date);
        $date_arrived = $d[2] . " " . $mois[intval($d[1])];
        return array(
            'date_arrived' => $date_arrived,
            'date_full' => $date_arrived . ' ' . $d[0]
        );
    }

    $calendar = $this->session->userdata('calendar');
    $cloture = $this->session->userdata('cloture');
    $notif = $this->session->userdata('notif');
    $user = $this->session->userdata('user');
    ?>

    <?php if ($isNeedNav) : ?>

        <?php if ($this->session->flashdata('alert')) { ?>
            <div class="alert alert-success small" style="position: fixed; bottom: 30px; right: 30px; width: 500px; z-index: 9999">
                <span class="message"><?= $this->session->flashdata('alert'); ?></span>
            </div>
        <?php } ?>

        <div style="margin: 2rem">
            <div class="row justify-content-center m-auto" style="max-width: 1400px">
                <div class="col">
                    <div class="segment" style="display: flex; justify-content: space-between; padding: 0px 40px">
                        <div style="display: flex">
                            <!-- If admin -->
                            <?php if ($user['u_profilId'] != '3') : ?>
                                <div class="item <?= basename($_SERVER['REQUEST_URI']) == 'main' ? 'active' : '' ?>">
                                    <a href="<?= site_url('/main') ?>">
                                        <ion-icon name="home-sharp"></ion-icon>
                                    </a>
                                </div>
                                <div class="item <?= basename($_SERVER['REQUEST_URI']) == 'leaves' ? 'active' : '' ?>">
                                    <a href="<?= site_url('/leaves') ?>">
                                        <ion-icon name="newspaper"></ion-icon>
                                    </a>
                                </div>
                                <!-- Sinon -->
                            <?php else : ?>
                                <div class="item <?= basename($_SERVER['REQUEST_URI']) == 'list' ? 'active' : '' ?>">
                                    <a href="<?= site_url('/list') ?>">
                                        <ion-icon name="newspaper"></ion-icon>
                                    </a>
                                    <?php if ($notif != 0) : ?>
                                        <div class="badge_notif"></div>
                                    <?php endif ?>
                                </div>
                                <div class="item <?= basename($_SERVER['REQUEST_URI']) == 'users' ? 'active' : '' ?>">
                                    <a href="<?= site_url('/users') ?>">
                                        <ion-icon name="people"></ion-icon>
                                    </a>
                                </div>
                                <div class="item <?= basename($_SERVER['REQUEST_URI']) == 'params' ? 'active' : '' ?>">
                                    <a href="<?= site_url('/params') ?>">
                                        <ion-icon name="construct-outline"></ion-icon>
                                    </a>
                                </div>
                            <?php endif ?>
                        </div>
                        <div style="display: flex">
                            <?php if ($user['u_profilId'] != '3') : ?>
                                <div class="item <?= basename($_SERVER['REQUEST_URI']) == 'profil' ? 'active' : '' ?>">
                                    <a href="<?= site_url('/profil') ?>">
                                        <ion-icon name="person-circle"></ion-icon>
                                    </a>
                                </div>
                                <div class="item">
                                    <div href="" id="button_logout_confirm">
                                        <ion-icon style="color: #ee5644" name="log-out-outline"></ion-icon>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="item">
                                    <div href="" id="button_logout_confirm">
                                        <ion-icon style="color: #ee5644" name="log-out-outline"></ion-icon>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center m-auto" style="max-width: 1400px">
                <div class="col-lg-9">
                    <?= $content; ?>
                </div>
                <div class="col-lg-3">
                    <div class="segment" style="padding: 10px 15px">
                        <div id="color-calendar"></div>
                    </div>
                    <div class="segment" style="padding: 10px 15px">
                        <h6 class="py-1">Jours fériés de l'année :</h6>
                        <div>
                            <?php foreach ($calendar as $c) : ?>
                                <div class="calendar-item border" data-id="<?= $c->id_calendar ?>">
                                    <?= get_entire_date($c->c_debut)['date_arrived'] . " : " . $c->c_description ?>
                                    <?php $c_json = json_encode((array) $c); ?>
                                    <?php if ($user['u_profilId'] == '3') : ?>
                                        <span class="float-right">
                                            <span class="lv-action-button edit" data-toggle="modal" data-target="#edit_calendar_modal" data-value="<?= $c->id_calendar ?>" data-debut="<?= $c->c_debut ?>" data-fin="<?= $c->c_fin ?>" data-description="<?= $c->c_description ?>" data-flag="<?= $c->c_flag ?>" title="Modifier">
                                                <ion-icon class="disabled" title="Modifier" name="create-outline"></ion-icon>
                                            </span>
                                            <span class="lv-action-button trash" data-value="<?= $c->id_calendar ?>" data-value="<?= $c->id_calendar ?>" title="Supprimer">
                                                <ion-icon class="disabled" name="trash-outline"></ion-icon>
                                            </span>
                                        </span>
                                    <?php endif ?>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <div class="segment" style="padding: 10px 15px">
                        <h6 class="py-1">Clôture d'agence</h6>
                        <?php foreach ($cloture as $c) : ?>
                            <div class="calendar-item border">
                                De <span style="color: #ee5644; font-weight: 600"><?= get_entire_date($c->c_debut)['date_full'] ?></span> au <span style="color: #ee5644; font-weight: 600"><?= get_entire_date($c->c_fin)['date_full'] ?></span>
                                <?php if ($user['u_profilId'] == '3') : ?>
                                    <span class="lv-action-button trash" data-value="<?= $c->id_calendar ?>" data-value="<?= $c->id_calendar ?>" title="Supprimer">
                                        <ion-icon class="disabled" name="trash-outline"></ion-icon>
                                    </span>
                                <?php endif ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <?= isset($content) ? $content : '' ?>
    <?php endif ?>

    <!-- Modals -->

    <!-- Modal pour modifier un collaborateur -->
    <div class="modal fade" id="edit_calendar_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="editCalendar" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCalendar">Modifier : </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editcalendar-form">
                    <input type="hidden" name="id_calendar" id="id_calendar">
                    <input type="hidden" name="c_flag" id="c-flag">
                    <div class="modal-body py-1">
                        <div class="lv-content">
                            <div class="row">
                                <div class="form-group col">
                                    <label class="" for="c-debut">Debut</label>
                                    <input type="date" class="form-control" id="c-debut" value="" name="c_debut" required>
                                </div>
                                <div class="form-group col">
                                    <label class="" for="c-fin">Fin *</label>
                                    <input type="date" class="form-control" id="c-fin" value="" name="c_fin">
                                    <small>* Facultatif s'il n'y a qu'un seul jour</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col">
                                    <label class="" for="c-description">Description :</label>
                                    <textarea name="c_description" id="c-description" class="form-control" cols="10" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a href="#" type="button" class="btn btn-secondary close" data-dismiss="modal">Annuler</a>
                        <button type="submit" class="btn btn-primary">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Fin modals -->

    <script>
        let calendar = <?= (json_encode((array) $calendar)); ?>;
        let cloture = <?= (json_encode((array) $cloture)); ?>;
        let myEvents = []
        calendar.forEach(c => {
            myEvents.push({
                start: c.c_debut,
                end: c.c_debut,
                name: c.c_description
            });
        })
        cloture.forEach(c => {
            let v = new Date(c.c_fin);
            for (let d = new Date(c.c_debut); d <= v; d.setDate(d.getDate() + 1)) {
                myEvents.push({
                    start: d.toISOString(),
                    end: d.toISOString(),
                    name: c.c_description
                });
            }
        })

        new Calendar({
            id: '#color-calendar',
            customWeekdayValues: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
            eventsData: myEvents
        })

        $('#button_logout_confirm').on('click', function() {
            ajax_func(null, 'security/authenticate/logout');
        })
        $('.alert.alert-success.small').fadeOut(10000);

        $('.lv-action-button').on('click', function() {
            if ($(this).hasClass('edit')) {
                $('#editcalendar-form #id_calendar').val($(this).data('value'));
                $('#editcalendar-form #c-debut').val($(this).data('debut'));
                $('#editcalendar-form #c-fin').val($(this).data('fin'));
                $('#editcalendar-form #c-description').val($(this).data('description'));
                $('#editcalendar-form #c-flag').val($(this).data('flag'));
            }
            if ($(this).hasClass('trash')) {
                let data = [{
                    name: "id_calendar",
                    value: $(this).data('value')
                }]
                ajax_func(data, 'params/remove_calendar');
            }
        })

        $('#editcalendar-form').on('submit', function(e) {
            e.preventDefault();
            let data = $(this).serializeArray();
            ajax_func(data, 'params/add_calendar')
        })
    </script>
</body>

</html>