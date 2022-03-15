
<?= $test = false ?>
<div class="content">
    <?php if($test): ?>
    <div class="d-flex xy-center" style="height: 60vh">
        <div>Empty data</div>
    </div>
    <?php else: ?>
        <div>Eto</div>
    <?php endif ?>
</div>
<div>
    <hr>
    <button type="submit" class="btn btn-primary">Importer</button>
    <button type="button" class="btn btn-secondary">Vider la table</button>
    <button type="button" class="btn btn-secondary float-right">Ajouter un utilisateur</button>
    <br><br>
</div>