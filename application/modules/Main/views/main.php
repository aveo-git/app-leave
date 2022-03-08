<?php
   $user = $this->session->userdata('user');
?>

<div class="segment">
   <br>
   <h6 class="py-2">Veuillez remplir les formulaires ci-dessous :</h6>
   <form id="form-addleave">
      <div class="row">
         <input type="hidden" value="<?= $user['id_user'] ?>" name="id_user">
         <input type="hidden" value="<?= $user['u_dispo'] ?>" name="u_dispo">
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-nom">Nom</label>
               <input type="text" class="form-control" id="lv-nom" value="<?= $user['u_nom'] ?>" name="u_nom" required>
            </div>
         </div>
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-prenom">Prénom</label>
               <input type="text" class="form-control" id="lv-prenom" value="<?= $user['u_prenom'] ?>" name="u_prenom" required>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-reference">Réference *</label>
               <input type="text" class="form-control" id="lv-reference" value="<?= $user['u_reference'] ?>" name="u_reference" required>
            </div>
         </div>
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-service">Service</label>
               <input type="text" class="form-control" id="lv-service" value="<?= $user['u_service'] ?>" name="u_service" required>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-responsable">Résponsable</label>
               <input type="text" class="form-control" id="lv-responsable" value="Patrick Hervier" name="u_responsable" required>
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
                     <input type="radio" class="form-check-input" value="Congé" name="l_type" id="lv-conge" checked>
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
                        <option value="08:00">08:00</option>
                        <option value="12:00">12:00</option>
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
                        <option value="12:00">12:00</option>
                        <option value="17:00" selected>17:00</option>
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
               <div class="totals" style="background-color: #fff8ef"><?= $user['u_dispo'] ?></div>
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
   // insert_all_data();

   $('#form-addleave').on('submit', function(e) {
      e.preventDefault();
      let data = $(this).serializeArray();
      console.dir(data);

      let d1 = {
         "date": $('#lv-dateDepart').val(),
         "option": $('#lv-dateDepart-option').val()
      }
      let d2 = {
         "date": $('#lv-dateFin').val(),
         "option": $('#lv-dateFin-option').val()
      }

      console.dir(get_jourPris(d1, d2));
      $.ajax({
         url: "<?= site_url('/main/add_leave') ?>",
         method: "POST",
         data: data,
         success: function(data) {
            // location.reload();
         }
      })
   })

   let get_jourPris = (d1, d2) => {
      if(d1.option == "08:00" && d2.option == "17:00") return add_zero(get_diff_date(d2.date, d1.date) + 1);
      if(d1.option == "12:00" && d2.option == "12:00") return add_zero(get_diff_date(d2.date, d1.date));
      if(d1.option != "08:00" || d2.option != "17:00") return add_zero(get_diff_date(d2.date, d1.date) + 1 - (1/2));
   }

   let get_diff_date = (d2, d1) => {
      let date1 = new Date(d1);
      let date2 = new Date(d2);
      return (date2.getTime() - date1.getTime()) / (1000 * 3600 *24);
   }

   let add_zero = (n) => {
      return (n < 10 && n >= 1) ? "0"+n : n;
   }

</script>