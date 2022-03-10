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

    <?php
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
                    <div class="segment">
                        <h6 class="py-2">Jours fériés de l'année :</h6>
                        <ul>
                            <li>Mardi 01 Janvier : Jour de l'an</li>
                            <li>Lundi 10 Juin : Jour férié 1</li>
                            <li>Mardi 26 Juin : Fête de l'independance</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
            <?= isset($content) ? $content : '' ?>
        <?php endif ?>
        <script>
            new Calendar({
                id: '#color-calendar',
                customWeekdayValues: ["Lun", "Mar", "Mer", "Jeu", "Ven", "Sam", "Dim"]
            })
            $('#button_logout_confirm').on('click', function() {
                $.ajax({
                    url: "<?= site_url('/security/authenticate/logout') ?>",
                    method: "POST",
                    data: null,
                    success: function(msg) {
                        location.reload();
                    }
                })
            })
            $('.alert.alert-success.small').fadeOut(10000);
        </script>
</body>
</html>