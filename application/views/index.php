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
    <?php if($isNeedNav): ?>
        <?php
            $active_h = "";
            $active_l = "";
            if(isset($model) != NULL) {
                switch ($model) {
                    case 'home':
                        $active_h = "active";
                        break;
                    case 'leaves':
                        $active_l = "active";
                        break;
                    
                    default:
                        # code...
                        break;
                }
            }
        ?>

        <div style="margin: 2rem">
            <div class="row justify-content-center w-75 m-auto">
                <div class="col">
                    <div class="segment" style="display: flex; justify-content: space-between; padding: 0px 40px">
                        <div style="display: flex">
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
                        </div>
                        <div style="display: flex">
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center w-75 m-auto">
                <div class="col-lg-8">
                    <?= $content; ?>
                </div>
                <div class="col-lg-4">
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
        </script>
</body>
</html>