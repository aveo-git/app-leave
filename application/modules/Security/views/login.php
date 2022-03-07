<div class="lv-login">
    <div>
        <div class="segment login">
            Connexion
        </div>
        <div class="segment login">
            <p>
                <form action="" id="form-login">
                    <div class="form-group">
                        <label class="" for="lv-username">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="lv-username" name="u_pseudo" aria-describedby="lv-username" required>
                    </div>
                    <div class="form-group">
                        <label class="" for="lv-mdp">Mot de passe</label>
                        <input type="password" class="form-control" id="lv-mdp" name="u_mdp" required>
                    </div>
                    <div class="form-group">
                        <span style="font-size: 12px">Mot de passe oublié ? Veuillez contacter votre administrateur.</span>
                    </div>
                    <button type="submit" class="btn btn-primary">Connecter</button>
                </form>
                <?php if($this->session->flashdata('error')) { ?>
                    <div class="alert alert-warning small"><?= $this->session->flashdata('error'); ?></div>
                <?php } ?>
            </p>
        </div>
    </div>
</div>

<script>
    $('#form-login').on('submit', function(e) {
        e.preventDefault();
        let data = $(this).serializeArray();
        $.ajax({
            url: "<?= site_url('security/authenticate/authenticate') ?>",
            method: "POST",
            data: data,
            success: function (msg) {
                location.reload();
            }
        });
    })
</script>