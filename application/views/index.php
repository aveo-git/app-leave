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
                        <h1>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse facere libero fugit ad sapiente aliquid hic numquam vel molestiae</h1>
                    </div>
                    <div class="segment">
                        <h2>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Et tempora repellendus qui</h2>
                    </div>
                </div>
            </div>
        </div>
        <?php else: ?>
            <?= isset($content) ? $content : '' ?>
        <?php endif ?>
</body>
</html>