<?php
   $user = $this->session->userdata('user');
?>

<div class="segment"> <br><br>
    <div class="text-center">
        <img src="<?= base_url().'/assets/images/'.$user['u_avatar'] ?>" alt="profil-user" id="user-avatar" class="rounded-circle profil">
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <form id="profil-form">
                <div class="form-group">
                    <label class="" for="lv-nom">Profil image</label>
                    <input type="file" class="form-control" id="lv-avatar" name="u_avatar">
                </div>
                <div class="form-group">
                    <label class="" for="lv-nom">Nom</label>
                    <input type="text" class="form-control" id="lv-nom" value="<?= $user['u_nom'] ?>" name="u_nom" required>
                </div>
                <div class="form-group">
                    <label class="" for="lv-prenom">Prénom</label>
                    <input type="text" class="form-control" id="lv-prenom" value="<?= $user['u_prenom'] ?>" name="u_prenom" required>
                </div>
                <div class="form-group">
                    <label class="" for="lv-email">Email</label>
                    <input type="email" class="form-control" id="lv-email" value="<?= $user['u_email'] ?>" name="u_email" required>
                </div>
                <div class="form-group">
                    <label class="" for="lv-reference">Réference</label>
                    <input type="text" class="form-control" id="lv-reference" value="<?= $user['u_reference'] ?>" name="u_reference">
                </div>
                <div class="form-group">
                    <label class="" for="lv-service">Service</label>
                    <select class="form-control" id="lv-service" name="u_service" aria-describedby="lv-service" required="required">
                        <?php foreach($services as $s): ?>
                        <option value="<?= $s->id_service ?>" <?= $user['u_service'] == $s->s_label ? 'selected' : '' ?>><?= $s->s_label ?></option>
                        <?php endforeach ?>
                     </select>
                </div>
                <hr>
                <br>
                <div class="text-center">
                    <button type="button" class="btn btn-secondary">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
            <br><br>
            <?php if($user['u_profilId'] == 2): ?>
            <div>
                <?php if($this->session->flashdata('error')) { ?>
                    <div class="alert alert-warning small"><?= $this->session->flashdata('error'); ?></div>
                <?php } ?>
                <form id="password-form">
                    <div class="form-group">
                        <label class="" for="lv-ancient">Ancien mot de passe</label>
                        <input type="password" class="form-control" id="lv-ancient" name="u_password">
                    </div>
                    <div class="form-group">
                        <label class="" for="lv-new">Nouveau mot de passe</label>
                        <input type="password" class="form-control" id="lv-new" name="u_new_password" required>
                    </div>
                    <div class="form-group">
                        <label class="" for="lv-confirmation">Confirmation</label>
                        <input type="password" class="form-control" id="lv-confirmation" name="u_confirmation" required>
                    </div>
                    <br>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary">Annuler</button>
                        <button type="submit" class="btn btn-primary">Changer</button>
                    </div>
                </form>
                <br><br>
            </div>
            <?php endif ?>
        </div>
    </div>
</div>

<script>
    $('#profil-form').on('submit', function(e) {
        e.preventDefault()
        let form_data = new FormData();
        let image = $('#lv-avatar')[0].files[0] ? $('#lv-avatar')[0].files[0].name : ''
        let image_ext = image.split('.').pop().toLowerCase();
        if(jQuery.inArray(image_ext, ['jpeg', 'jpg', 'gif', 'png', '']) == -1) {
            alert('Extension de l\'image est invalide. (Seulement : png, jpeg, jpg, gif)');
        } else {
            form_data.append('file', $('#lv-avatar')[0].files[0]);
            form_data.append('id_user', "<?= $user['id_user'] ?>");
            form_data.append('u_pseudo', "<?= $user['u_pseudo'] ?>");
            form_data.append('u_nom', $('#lv-nom').val());
            form_data.append('u_prenom', $('#lv-prenom').val());
            form_data.append('u_email', $('#lv-email').val());
            form_data.append('u_reference', $('#lv-reference').val());
            form_data.append('u_service', $('#lv-service').val());
            $.ajax({
                url: "<?= site_url('profil/update_profil') ?>",
                method: "POST",
                data: form_data,
                contentType : false,
                cache: false,
                processData: false,
                success: function() {
                    location.reload();
                }
            })
        }
    })

    $('#password-form').on('submit', function(e) {
        e.preventDefault();
        let data = $(this).serializeArray();
        ajax_func(data, 'profil/set_password');
    })
</script>