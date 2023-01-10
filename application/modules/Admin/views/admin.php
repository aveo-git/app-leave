<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container {
        display: flex;
        height: 100vh;
        justify-content: center;
        align-items: center;
    }

    .content {
        width: 500px;
    }
</style>
<div class="container">
    <div class="content">
        <h4>Votre clé arrive à sa péremption. <br> <small>Si vous voulez activer l'application, veuillez nous contacter sur <a href="mailto:aveolys@aveolys.com">aveolys@aveolys.com</a> </small> </h4>
        <div class="form">
            <div class="title-form">Si vous possedez une clé, veuillez l'inserer en dessous :</div>
            <form class="form-validation">
                <div class="form-field">
                    <input type="text">
                </div>
                <button type="submit">Activer</button>
            </form>
        </div>
    </div>
</div>
<?php
switch ($keyStatus) {
    case '0':
        echo 'Key not actif';
        break;
    case '1':
        echo 'Key actif';
        break;
    default:
        echo 'undefined';
}
?>

<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script>
    $('.form-validation').on('submit', function(e) {
        e.preventDefault()
        console.log('Mety ve zany ohh')
    })
</script>