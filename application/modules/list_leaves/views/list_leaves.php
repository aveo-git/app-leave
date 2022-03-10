<div class="segment" style="min-height: 65vh;"><br>
    <div class="d-flex">
        <div style="margin-right: 15px; max-width: 400px;width: 400px">
            <h6 class="py-2">Liste des congés en attente</h6>
            <div class="segment shadow-sm leave-item d-flex by-center active">
                <div class="d-flex">
                    <div>
                        <img src="<?= base_url().'/assets/images/avatar.png' ?>" alt="profil-user" class="rounded-circle profil sm">
                    </div>
                    <div style="padding: 0 15px">
                        <div class="leave-item-name">Dimby RASOLONIRINA</div>
                        <div class="leave-item-sending">- Envoyé le 08/02/2022</div>
                    </div>
                </div>
                <div><ion-icon name="chevron-forward-circle"></ion-icon></div>
            </div>
            <div class="segment shadow-sm leave-item d-flex by-center">
                <div class="d-flex">
                    <div>
                        <img src="<?= base_url().'/assets/images/avatar.png' ?>" alt="profil-user" class="rounded-circle profil sm">
                    </div>
                    <div style="padding: 0 15px">
                        <div class="leave-item-name">Mandrindra ANDRIANJARASOA</div>
                        <div class="leave-item-sending">- Envoyé le 08/02/2022</div>
                    </div>
                </div>
                <div><ion-icon name="chevron-forward-circle"></ion-icon></div>
            </div>
        </div>
        <div class="border-left d-flex justify-content-center w-100" style="padding-left: 10px; border-radius: 0px">
            <div class="p-2" style="width: 90%">
                <div class="text-center"><img src="<?= base_url().'/assets/images/avatar.png' ?>" alt="profil-user" class="rounded-circle profil sm"></div>
                <div class="text-center leave-item-sending p-2">Envoyé le 08/02/2022 à 17:20</div>
                <br>
                <form action="">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-nom">Nom</label>
                                <input type="text" class="form-control" id="lv-nom" name="u_nom" value="RASOLONIRINA" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-prenom">Prénom</label>
                                <input type="text" class="form-control" id="lv-prenom" value="Dimby" name="u_prenom" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-reference">Réference</label>
                                <input type="text" class="form-control" id="lv-reference" value="001-AVEO-2019" name="u_reference" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-service">Service</label>
                                <input type="text" class="form-control" id="lv-service" value="Dev Web et Graphiste" name="u_service" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-type">Type de congé</label>
                                <input type="text" class="form-control" id="lv-type" value="Congé" name="l_type" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-dateDepart">Le :</label>
                                <input type="text" class="form-control" id="lv-dateDepart" value="12/02/2022 à 08:00" name="l_dateDepart" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-dateFin">Jusqu'au :</label>
                                <input type="text" class="form-control" id="lv-dateFin" value="12/02/2022 à 17:00" name="l_dateFin" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-dispo">Disponible</label>
                                <input type="text" class="form-control" id="lv-dispo" value="23" name="l_nbJdispo" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-pris">Jour(s) pris</label>
                                <input type="text" class="form-control" id="lv-pris" value="1" name="l_nbJpris" disabled>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="" for="lv-rest">Jour(s) restant</label>
                                <input type="text" class="form-control" id="lv-rest" value="22" name="l_nbJrest" disabled>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Valider</button>
                        <button type="button" class="btn btn-secondary">Refuser</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>