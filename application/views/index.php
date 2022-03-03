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
        <div style="margin: 2rem">
            <div class="row justify-content-center w-75 m-auto">
                <div class="col">
                    <div class="segment" style="display: flex; justify-content: space-between; padding: 0px 40px">
                        <div style="display: flex">
                            <div class="item active">
                            <ion-icon name="home-sharp"></ion-icon>
                            </div>
                            <div class="item">
                            <ion-icon name="newspaper"></ion-icon>
                            </div>
                        </div>
                        <div style="display: flex">
                            <div class="item">
                            <ion-icon name="information-circle"></ion-icon>
                            </div>
                            <div class="item">
                            <ion-icon name="person-circle"></ion-icon>
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
                            <li>01 Janvier : Jour de l'an</li>
                            <li>10 Juin : Jour férié 1</li>
                            <li>11 Juin : Jour férié 2</li>
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
        </script>
</body>
</html>