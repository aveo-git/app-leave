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
                url: "<?= base_url().'index.php/' ?>"+url,
                method: "POST",
                data: data,
                success: function(msg) {
                    location.reload();
                }
            })
        }
    </script>

    <?php

            function get_entire_date($date) {
                $mois = array("", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
                $d = explode("-", $date);
                $date_arrived = $d[2]." ".$mois[intval($d[1])];
                return $date_arrived;
            }

        $calendar = $this->session->userdata('calendar');
        // var_dump($calendar);
        $user = $this->session->userdata('user');
    ?>

    <?php if($isNeedNav): ?>
        <?php
            $active_h = "";
            $active_l = "";
            $active_list = "";
            $active_users = "";
            $active_params = "";
            if(isset($model) != NULL) {
                switch ($model) {
                    case 'home':
                        $active_h = "active";
                        break;
                    case 'leaves':
                        $active_l = "active";
                        break;
                    case 'list':
                        $active_list = "active";
                        break;
                    case 'users':
                        $active_users = "active";
                        break;
                    case 'params':
                        $active_params = "active";
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
        ?>

        <?php if($this->session->flashdata('alert')) { ?>
            <div class="alert alert-success small" style="position: fixed; bottom: 30px; right: 30px; width: 500px; z-index: 9999">
                <span class="message"><?= $this->session->flashdata('alert'); ?></span>
                <button type="button" class="rh-close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 22px;position: relative;bottom: 3px;">&times;</span>
                </button>
            </div>
        <?php } ?>

        <div style="margin: 2rem">
            <div class="row justify-content-center w-75 m-auto">
                <div class="col">
                    <div class="segment" style="display: flex; justify-content: space-between; padding: 0px 40px">
                        <div style="display: flex">
                            <!-- If admin -->
                            <?php if($user['u_profilId'] != '1'): ?>
                                <div class="item <?= $active_h ?>">
                                    <a href="<?= site_url('/main') ?>">
                                        <ion-icon name="home-sharp"></ion-icon>
                                    </a>
                                </div>
                                <div class="item <?= $active_l ?>">
                                    <a href="<?= site_url('/leaves') ?>">
                                        <ion-icon name="newspaper"></ion-icon>
                                    </a>
                                </div>
                            <!-- Sinon -->
                            <?php else: ?>
                                <div class="item <?= $active_list ?>">
                                    <a href="<?= site_url('/list') ?>">
                                        <ion-icon name="newspaper"></ion-icon>
                                    </a>
                                    <div class="badge_notif"></div>
                                </div>
                                <div class="item <?= $active_users ?>">
                                    <a href="<?= site_url('/users') ?>">
                                        <ion-icon name="people"></ion-icon>
                                    </a>
                                </div>
                                <div class="item <?= $active_params ?>">
                                    <a href="<?= site_url('/params') ?>">
                                        <ion-icon name="construct-outline"></ion-icon>
                                    </a>
                                </div>
                            <?php endif ?>
                        </div>
                        <div style="display: flex">
                            <?php if($user['u_profilId'] != '1'): ?>
                                <div class="item">
                                    <a href="<?= site_url('/profil') ?>">
                                        <ion-icon name="person-circle"></ion-icon>
                                    </a>
                                </div>
                                <div class="item">
                                    <div href="" id="button_logout_confirm">
                                        <ion-icon style="color: #ee5644" name="log-out-outline"></ion-icon>
                                    </div>
                                </div>
                            <?php else: ?>
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
            <div class="row justify-content-center w-75 m-auto">
                <div class="col-lg-9">
                    <?= $content; ?>
                </div>
                <div class="col-lg-3">
                    <div class="segment">
                        <div id="color-calendar"></div>
                    </div>
                    <div class="segment" style="padding: 10px 15px">
                        <h6 class="py-1">Jours fériés de l'année :</h6>
                        <div>
                            <?php foreach($calendar as $c): ?>
                            <div class="calendar-item border" data-id="<?= $c->id_calendar ?>">
                                <?= get_entire_date($c->c_debut)." : ".$c->c_description ?>
                                <?php $c_json = json_encode((array) $c); ?>
                                <span class="float-right">
                                    <span class="lv-action-button edit" 
                                        data-toggle="modal"
                                        data-target="#edit_calendar_modal"

                                        data-value="<?= $c->id_calendar ?>"
                                        data-debut="<?= $c->c_debut ?>"
                                        data-fin="<?= $c->c_fin ?>"
                                        data-description="<?= $c->c_description ?>"
                                        data-flag="<?= $c->c_flag ?>"

                                        title="Modifier"><ion-icon class="disabled" title="Modifier" name="create-outline"></ion-icon></span>
                                    <span class="lv-action-button trash"
                                        data-toggle="modal"
                                        data-target="#delete_calendar_modal"
                                        data-value="<?= $c->id_calendar ?>"
                                        data-value="<?= $c->id_calendar ?>" title="Supprimer"><ion-icon class="disabled" name="trash-outline"></ion-icon></span>
                                </span>
                            </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
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
            new Calendar({
                id: '#color-calendar',
                customWeekdayValues: ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"]
            })

            $('#button_logout_confirm').on('click', function() {
                ajax_func(null, 'security/authenticate/logout');
            })
            $('.alert.alert-success.small').fadeOut(10000);

            $('.lv-action-button').on('click', function() {
                if($(this).hasClass('edit')) {
                    $('#editcalendar-form #id_calendar').val($(this).data('value'));
                    $('#editcalendar-form #c-debut').val($(this).data('debut'));
                    $('#editcalendar-form #c-fin').val($(this).data('fin'));
                    $('#editcalendar-form #c-description').val($(this).data('description'));
                    $('#editcalendar-form #c-flag').val($(this).data('flag'));
                }
                if($(this).hasClass('trash')) {
                    let data = [{name: "id_calendar", value: $(this).data('value')}]
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