<?php $saved = $this->session->flashdata('saved') ?>

<div class="d-flex justify-content-center align-items-center vw-100 vh-100">
    <div class="w-50">
    <?php if($saved){ ?>
    <div class="alert alert-success" role="alert">
        nouvelle clé enregistrée
    </div>
    <?php } ?>
    <form class="bg-white p-4" action="certificate/setkey" method='POST'>
        <p>ajouter une nouvelle clé</p>
        <div class="mb-3">
        <input type="text" placeholder="nouveau clé" name="key" class="form-control">
        </div>
        <div class="text-end">
        <button class="btn btn-primary">enregistrer</button>
        </div>
    </form>
    </div>
</div>