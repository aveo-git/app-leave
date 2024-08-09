<?php
$user = $this->session->userdata('user');
$disabled = '';

?>
<?php
if ($user['u_email'] == null) {
   $disabled = 'disabled';
?>
   <div class="alert alert-danger">Assurez-vous que votre adresse email n'est pas vide. Si c'est le cas, modifiez-le <a href="<?= site_url() . '/profil' ?>">ici</a>.</div>
<?php }

$disabled_sell = ($user['u_dispo'] < $user['solde']);

?>
<div class="progress">
   <div style="text-align: center">
      <i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="color: #FFFFFF;"></i>
      <div style="color: #FFF;font-size: 20px;padding: 15px 0 0 0;">Envoi de mail en cours ...</div>
   </div>
</div>
<div class="segment">
   <div class="sell-leaves"><button type="button" class="btn btn-secondary" id="sellLeaves_button" data-toggle="modal" data-target="#sellLeaves_modal" title="Souhaiteriez-vous de compenser votre congé en équivalent sur salaire ?">Convertir</button></div>
   <br>
   <h6 class="py-2">Veuillez remplir les formulaires ci-dessous :</h6>
   <form id="form-addleave">
      <div class="row">
         <input type="hidden" value="<?= $user['id_user'] ?>" name="id_user">
         <input type="hidden" value="<?= $user['u_dispo'] ?>" name="u_dispo">
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-nom">Nom</label>
               <input type="text" class="form-control" id="lv-nom" value="<?= $user['u_nom'] ?>" name="u_nom" required disabled>
            </div>
         </div>
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-prenom">Prénom</label>
               <input type="text" class="form-control" id="lv-prenom" value="<?= $user['u_prenom'] ?>" disabled name="u_prenom" required>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-reference">Réference (facultatif)</label>
               <input type="text" class="form-control" id="lv-reference" value="<?= $user['u_reference'] ?>" name="u_reference">
            </div>
         </div>
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-service">Service</label>
               <input type="text" class="form-control" id="lv-service" value="<?= $user['u_service'] ?>" name="u_service" required disabled>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <div class="form-group">
               <label class="" for="lv-responsable">Résponsable</label>
               <input type="text" class="form-control" id="lv-responsable" value="<?= $resp->u_prenom . " " . $resp->u_nom ?>" name="u_responsable" required disabled>
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
                  <div class="form-check">
                     <input type="radio" class="form-check-input" value="Congé sans solde" name="l_type" id="lv-sanssolde">
                     <label class="form-check-label" for="lv-sanssolde">Congé sans solde</label>
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
                  <div class="form-check">
                     <input type="radio" class="form-check-input" value="Autorisation d'absence" name="l_type" id="lv-autorisation">
                     <label class="form-check-label" for="lv-autorisation">Autorisation d'absence</label>
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
               <div class="d-flex" style="justify-content: normal">
                  <div>
                     <input type="date" class="form-control" id="lv-dateDepart" name="l_dateDepart" style="width: 240px" required>
                  </div>
                  <div>
                     <select class="form-control" id="lv-dateDepart-option" name="l_dateDepart-option" aria-describedby="lv-dateDepart-option" style="width: 150px; margin-left: 15px" required="required">
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
               <div class="d-flex" style="justify-content: normal">
                  <div>
                     <input type="date" class="form-control" id="lv-dateFin" name="l_dateFin" style="width: 240px" required>
                  </div>
                  <div>
                     <select class="form-control" id="lv-dateFin-option" name="l_dateFin-option" aria-describedby="lv-dateFin-option" style="width: 150px; margin-left: 15px" required="required">
                        <option value="12:00">12:00</option>
                        <option value="17:00" selected>17:00</option>
                     </select>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="row alert_date_negative">
         <div class="col">
            <div class="alert alert-danger message"></div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12 lv-droits d-flex">
            <div>
               Droits disponibles
               <div class="totals" style="background-color: #fff8ef"><?= $dispo ?></div>
            </div>
            <div>
               Nombre de jours pris
               <div class="totals" id="nb_Jpris">--</div>
            </div>
            <div>
               Droits restants
               <div class="totals" id="nb_Jrestant">--</div>
            </div>
         </div>
      </div><br>
      <div class="row">
         <div class="col-lg-12">
            <div class="alert alert-primary">
               Vous devez soumettre vos demandes de congé (à l'exception des congés maladies) deux jours avant leur date effective. Les
               congés pour raison exceptionnelle doivent être accompagnés d'un justificatif (médical, mariage, naissance, décès, ...).
            </div>
         </div>
      </div>

      <br>
      <button type="button" class="btn btn-secondary cancel_btn">Effacer</button>
      <button type="submit" class="btn btn-primary send_leave" <?= $disabled ?>>Envoyer</button>
   </form>
   <br>
</div>

<!-- Modal pour Valorisation congé -->
<div class="modal fade" id="sellLeaves_modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="report" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-md" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="report">Valoriser mes congés</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body" style="padding: 25px">
            <!-- LEAVES LIST -->
            <form id="sell_leave">
               <input type="hidden" value="sell" name="u_descr">
               <input type="hidden" value="Congé compensé" name="l_type">
               <input type="hidden" value="<?= $user['id_user'] ?>" name="id_user">
               <input type="hidden" value="<?= $user['u_dispo'] ?>" name="u_dispo">
               <input type="hidden" value="<?= $resp->u_prenom . " " . $resp->u_nom ?>" name="u_responsable">
               <div class="form-group">
                  <label class="" for="lv-sell">Veuillez ajouter le nombre de congé :</label>
                  <input type="number" class="form-control" id="lv-sell" name="nbJpris" step="0.5" min="<?= $user['solde'] ?>" value="<?= $user['u_dispo'] ?>" required <?= $disabled_sell ? 'disabled' : '' ?>>
                  <?php if ($disabled_sell) : ?>
                     <small style="color: #ffa929"><i class="fa fa-warning"></i> Votre solde est insuffisant. (<?= $user['solde'] ?> jours au minimum)</small>
                  <?php endif ?>
               </div>
               <div class="alert alert-primary">
                  Remarque : <br>
                  - Il ne serait plus possible de revenir en arrière si vous n'avez plus de solde pour n'importe quel type de congé. <br>
                  - Solde minimal : <?= $user['solde'] ?> jours
               </div>
               <button type="submit" class="btn btn-primary" <?= $disabled_sell ? 'disabled' : '' ?>>Envoyer</button>
            </form>
            <!-- /LEAVES LIST -->
         </div>
         <div class="modal-footer">
         </div>
      </div>
   </div>
</div>

<script>
   $('.alert_date_negative').hide();
   $('.send_leave').prop('disabled', true);
   $('#lv-dateFin').prop('disabled', true);
   const dispo = <?= $dispo ?>

   $('#form-addleave').on('submit', function(e) {
      e.preventDefault();
      let data = $(this).serializeArray();
      let d1 = {
         "date": new Date($('#lv-dateDepart').val()),
         "option": $('#lv-dateDepart-option').val()
      }
      let d2 = {
         "date": new Date($('#lv-dateFin').val()),
         "option": $('#lv-dateFin-option').val()
      }
      data.push({
         name: 'nbJpris',
         value: get_jourPris(d1, d2)
      });
      // console.log(data)
      ajax_func_validate(data, 'main/add_leave');
   })

   $('#lv-dateDepart').on('change', function() {
      $('#lv-dateFin').attr({"min": $('#lv-dateDepart').val()})
      $('#lv-dateFin').prop('disabled', $('#lv-dateDepart').val() === "");
   })

   $('#lv-dateFin').on('change', function() {
      let d1, d2 = null;
      if ($('#lv-dateDepart').val() != "" && $('#lv-dateFin').val() != "") {
         let d1 = {
            "date": new Date($('#lv-dateDepart').val()),
            "option": $('#lv-dateDepart-option').val()
         }
         let d2 = {
            "date": new Date($('#lv-dateFin').val()),
            "option": $('#lv-dateFin-option').val()
         }
         let jPris = get_jourPris(d1, d2);
         if (dispo < jPris) {
            $('.send_leave').prop('disabled', true);
            $('.alert_date_negative .message').html("Vous n'avez plus assez de date disponible.");
            $('.alert_date_negative').show().fadeOut(7000);
         } else {
            if (jPris < 0) {
               $('.send_leave').prop('disabled', true);
               $('.alert_date_negative .message').html('Date invalide, vérifier votre date.')
               $('.alert_date_negative').show().fadeOut(7000);
            } else {
               $('.send_leave').prop('disabled', false);
               $('#nb_Jpris').html(add_zero(jPris));
               $('#nb_Jrestant').html(add_zero($('#lv-autorisation').is(":checked") ? dispo : dispo - jPris));
            }
         }
      }
   })

   $('.cancel_btn').on('click',function(){
      $('#lv-dateFin').val("")
      $('#lv-dateDepart').val("")
      $('#nb_Jpris').html("--");
      $('#nb_Jrestant').html("--");
      $('.send_leave').prop('disabled', true);
   })

   $('#sell_leave').on('submit', function(e) {
      e.preventDefault();
      let solde = '<?= $user['u_dispo'] ?>';
      let data = $(this).serializeArray();
      if ($(this).serializeArray()[0].value >= '<?= $user['solde'] ?>') {
         ajax_func_validate(data, 'main/add_leave');
      }
   })

   let get_jourPris = (d1, d2) => {
      let diff = 0;
      if (d1.date > d2.date) return -1;
      if (d1.option == "08:00" && d2.option == "17:00") diff = get_diff_date(d2.date, d1.date) + 1;
      if (d1.option == "12:00" && d2.option == "12:00") diff = get_diff_date(d2.date, d1.date);
      if (d1.option != "08:00" || d2.option != "17:00") diff = get_diff_date(d2.date, d1.date) + 1 - (1 / 2);

      return diff - sundayAndHolidayExisting(d1.date, d2.date) + hasFriday(d1.date, d2.date);
   }

   let get_diff_date = (d2, d1) => {
      return (d2.getTime() - d1.getTime()) / (1000 * 3600 * 24);
   }

   // Jour ferié + dimanche
   let sundayAndHolidayExisting = (d1, d2) => {
      let count = 0;
      let all_holiday = _.map(<?= json_encode((array) $publicholiday); ?>, (n) => {
         return new Date(n.c_debut);
      })
      for (let i = d1; i <= d2; i.setDate(i.getDate() + 1)) {
         if (i.getDay() == 0) {
            count++;
         }
         if (all_holiday.find(e => _.isEqual(e, i)) !== undefined) count++;
      }
      return count;
   }

   let hasFriday = (d1, d2) => {
      let count = 0;
      if (d1.getDay() == 5 && d2.getDay() == 5 || d2.getDay() == 5) {
         count++;
      }
      return count;
   }

   let add_zero = (n) => {
      return (n < 10 && n >= 1) ? "0" + n : n;
   }
</script>