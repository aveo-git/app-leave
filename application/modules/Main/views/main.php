<div class="segment">
   <br>
   <h6 class="py-2">Veuillez remplir les formulaires ci-dessous :</h6>
   <form id="form-addleave">
      <div class="row">
         <input type="hidden" value="1" name="id_user">
         <input type="hidden" value="24" name="u_dispo">
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-nom">Nom</label>
               <input type="text" class="form-control" id="lv-nom" name="u_nom" required>
            </div>
         </div>
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-prenom">Prénom</label>
               <input type="text" class="form-control" id="lv-prenom" name="u_prenom" required>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-reference">Réference *</label>
               <input type="text" class="form-control" id="lv-reference" name="u_reference" required>
            </div>
         </div>
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-service">Service</label>
               <input type="text" class="form-control" id="lv-service" name="u_service" required>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-responsable">Résponsable</label>
               <input type="text" class="form-control" id="lv-responsable" name="u_responsable" required>
            </div>
         </div>
         <div class="col">
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12">
            <label class="" for="lv-responsable">Type de congé</label>
         </div>
         <div class="col-lg-12">
            <div class="row m-0">
               <div class="col">
                  <div class="form-check">
                     <input type="radio" class="form-check-input" value="Maladie" name="l_type" id="lv-maladie">
                     <label class="form-check-label" for="lv-maladie">Maladie</label>
                  </div>
                  <div class="form-check">
                     <input type="radio" class="form-check-input" value="Obligations militaires" name="l_type" id="lv-militaire">
                     <label class="form-check-label" for="lv-militaire">Obligations militaires</label>
                  </div>
               </div>
               <div class="col">
                  <div class="form-check">
                     <input type="radio" class="form-check-input" value="Congé" name="l_type" id="lv-conge">
                     <label class="form-check-label" for="lv-conge">Congé</label>
                  </div>
                  <div class="form-check">
                     <input type="radio" class="form-check-input" value="Activités judiciaires" name="l_type" id="lv-judiciaire">
                     <label class="form-check-label" for="lv-judiciaire">Activités judiciaires</label>
                  </div>
               </div>
               <div class="col">
                  <div class="form-check">
                     <input type="radio" class="form-check-input" value="Décès" name="l_type" id="lv-deces">
                     <label class="form-check-label" for="lv-deces">Décès</label>
                  </div>
                  <div class="form-check">
                     <input type="radio" class="form-check-input" value="Congé parental" name="l_type" id="lv-parental">
                     <label class="form-check-label" for="lv-parental">Congé parental</label>
                  </div>
               </div>
               <div class="col">
                  <div class="form-check">
                     <input type="radio" class="form-check-input" value="Congé sans solde" name="l_type" id="lv-sanssolde">
                     <label class="form-check-label" for="lv-sanssolde">Congé sans solde</label>
                  </div>
                  <div class="form-check">
                     <input type="radio" class="form-check-input" value="Autre" name="l_type" id="lv-autre">
                     <label class="form-check-label" for="lv-autre">Autre</label>
                  </div>
               </div>
            </div>
         </div>
      </div><br>
      <div class="row">
         <div class="col">
            <div class="form-group">
               <label for="lv-responsable">Date du :</label>
               <div class="d-flex" style="justify-content: space-between">
                  <div>
                     <input type="date" class="form-control" id="lv-dateDepart" name="l_dateDepart" style="width: 240px" required>
                  </div>
                  <div>
                     <select class="form-control" id="lv-dateDepart-option" name="l_dateDepart-option" aria-describedby="lv-dateDepart-option" style="width: 150px" required="required">
                        <option value="0">Matin</option>
                        <option value="1">Après midi</option>
                     </select>
                  </div>
               </div>
            </div>
         </div>
         <div class="col">
            <div class="form-group">
               <label for="lv-responsable">Jusqu'au :</label>
               <div class="d-flex" style="justify-content: space-between">
                  <div>
                     <input type="date" class="form-control" id="lv-dateFin" name="l_dateFin" style="width: 240px" required>
                  </div>
                  <div>
                     <select class="form-control" id="lv-dateFin-option" name="l_dateFin-option" aria-describedby="lv-dateFin-option" style="width: 150px" required="required">
                        <option value="0">Matin</option>
                        <option value="1" selected>Après midi</option>
                     </select>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12 lv-droits d-flex">
            <div>
               Droits disponibles
               <div class="totals" style="background-color: #fff8ef">10</div>
            </div>
            <div>
               Nombre de jours pris
               <div class="totals">05</div>
            </div>
            <div>
               Droits restants
               <div class="totals">05</div>
            </div>
         </div>
      </div><br>
      <div class="row">
         <div class="col-lg-12">
            <div class="alert alert-primary">
            Vous devez soumettre vos demandes des congé (à l'exception des congés maladies) deux jours avant leur date effective. Les
            congés pour raison exceptionnelle doivent être accompagnés d'un justificatif (médical, mariage, naissance, décès, ...).
            </div>
         </div>
      </div>

      <br>
      <div>* Facultatif</div>
      <button type="submit" class="btn btn-primary">Valider</button>
      <button type="button" class="btn btn-secondary">Effacer</button>
   </form>
   <br>
</div>

<script>
   let insert_all_data = () => {
      $('#lv-nom').val('RASOLONIRINA');
      $('#lv-prenom').val('Dimby');
      $('#lv-reference').val('001-AVEO-2019');
      $('#lv-service').val('Dev Web et Graphiste');
      $('#lv-responsable').val('Patrick Hervier');
      $('#lv-conge').prop('checked', true);
   }
   insert_all_data();

   $('#form-addleave').on('submit', function(e) {
      e.preventDefault();
      let data = $(this).serializeArray();
      console.log(data);
   })
</script>