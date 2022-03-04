<div class="segment"> <br><br>
    <div class="text-center"><img src="<?= base_url().'/assets/images/avatar.png' ?>" alt="profil-user" class="rounded-circle profil"></div>
    <br>
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <form action="">
                <div class="form-group">
                    <label class="" for="lv-nom">Nom</label>
                    <input type="text" class="form-control" id="lv-nom" value="RASOLONIRINA" name="u_nom" required>
                </div>
                <div class="form-group">
                    <label class="" for="lv-prenom">Prénom</label>
                    <input type="text" class="form-control" id="lv-prenom" value="Dimby" name="u_prenom" required>
                </div>
                <div class="form-group">
                    <label class="" for="lv-reference">Réference</label>
                    <input type="text" class="form-control" id="lv-reference" value="001-Aveo-2019" name="u_reference" required>
                </div>
                <div class="form-group">
                    <label class="" for="lv-service">Service</label>
                    <select class="form-control" id="lv-service" name="u_service" aria-describedby="lv-service" required="required">
                        <option data-value="0">Dev web et Graphiste</option>
                        <option data-value="1">RH</option>
                        <option data-value="1">Admin Sys</option>
                        <option data-value="1">Support Helpdesk</option>
                        <option data-value="1">Commercial</option>
                     </select>
                </div>
                <br>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Valider</button>
                    <button type="button" class="btn btn-secondary">Annuler</button>
                </div>
            </form>
            <br><br>
        </div>
    </div>
</div>