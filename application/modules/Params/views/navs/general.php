<h6 class="py-2 border-bottom text-uppercase">Parametre LDAP</h6>
<form id="params-form">
  <div class="row">
    <?php foreach ($params_ldap as $p) :
      $inputType = $p->param_code == 'PWD_AD' ? 'password' : 'text';
    ?>
      <div class="col-lg-4">
        <div class="form-group">
          <label for="lv-<?= $p->param_code ?>"><?= $p->param_lib ?> <ion-icon class="icon_edit" data-toggle="modal" data-target="#edit_params" data-code="<?= $p->param_code ?>" data-lib="<?= $p->param_lib ?>" data-value="<?= $p->param_value ?>" name="create-outline"></ion-icon></label>
          <input type=<?= $inputType ?> class="form-control" value="<?= $p->param_value ?>" id="lv-<?= $p->param_code ?>" disabled>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</form>
<br>
<h6 class="py-2 border-bottom text-uppercase">Parametre méssagerie</h6>
<form id="params-form">
  <div class="row">
    <?php foreach ($params_email as $p) :
      $inputType = $p->param_code == 'email_password' ? 'password' : 'text';
    ?>
      <div class="col-lg-6">
        <div class="form-group">
          <label for="lv-<?= $p->param_code ?>"><?= $p->param_lib ?> <ion-icon class="icon_edit" data-toggle="modal" data-target="#edit_params" data-code="<?= $p->param_code ?>" data-lib="<?= $p->param_lib ?>" data-value="<?= $p->param_value ?>" name="create-outline"></ion-icon></label>
          <input type=<?= $inputType ?> class="form-control" value="<?= $p->param_value ?>" id="lv-<?= $p->param_code ?>" disabled>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</form>
<br>
<div class="row">
  <div class="col">
    <button type="button" class="btn btn-secondary" id="test_messagerie" title="Tester si les parametres de messagerie sont correctes">Tester</button>
  </div>
</div>
<br>
<h6 class="py-2 border-bottom text-uppercase">Parametre de solde</h6>
<form id="params-form">
  <div class="row">
    <?php foreach ($params_sell as $p) :
    ?>
      <div class="col-lg-6">
        <div class="form-group">
          <label for="lv-<?= $p->param_code ?>"><?= $p->param_lib ?> <ion-icon class="icon_edit" data-toggle="modal" data-target="#edit_params" data-code="<?= $p->param_code ?>" data-lib="<?= $p->param_lib ?>" data-value="<?= $p->param_value ?>" name="create-outline"></ion-icon></label>
          <input type='text' class="form-control" value="<?= $p->param_value ?>" id="lv-<?= $p->param_code ?>" disabled>
        </div>
      </div>
    <?php endforeach ?>
  </div>
</form>
<br>
<div class="row">
  <div class="col-lg-5">
    <h6 class="py-2 border-bottom text-uppercase">Ajouter un service</h6>
    <form id="service-form">
      <div class="form-group ">
        <label for="lv-service_add">Nom du service</label>
        <input type="text" class="form-control" id="lv-service_add" name="s_label" aria-describedby="lv-service_add" required>
      </div>
      <div class="form-group">
        <label for="lv-desc">Description</label>
        <input type="text" class="form-control" id="lv-desc" name="s_description" aria-describedby="lv-desc" required>
      </div>
      <button type="submit" class="btn btn-secondary">Ajouter</button>
    </form>
  </div>
  <div class="col-lg-7">
    <h6 class="py-2 border-bottom text-uppercase">Modifier un service</h6>
    <form id="">
      <div class="row">
        <div class="form-group col">
          <label for="lv-service-u">Nom du service</label>
          <select class="form-control" id="lv-service-u" name="s_label" aria-describedby="lv-service-u" required="required">
            <?php foreach ($services as $item) { ?>
              <option value="<?= $item->id_service ?>" data-desc="<?= $item->s_description ?>"><?= $item->s_label ?></option>
            <?php } ?>
          </select>
        </div>
      </div>
    </form>
    <form id="edit-service-form">
      <input type="hidden" name="id_service" id="id_service_add">
      <div class="row">
        <div class="form-group col">
          <label for="lv-label-u">Nom du service</label>
          <input type="text" class="form-control" id="lv-label-u" name="s_label" aria-describedby="lv-label-u" required>
        </div>
        <div class="form-group col">
          <label for="lv-desc-u">Description</label>
          <input type="text" class="form-control" id="lv-desc-u" name="s_description" aria-describedby="lv-desc-u">
        </div>
      </div>
      <div class="row">
        <div class="col">
          <button type="submit" class="btn btn-secondary">Modifier</button>
        </div>
      </div>
    </form>
  </div>
</div>
<br>

<!-- Modal pour mofication LDAP -->
<div class="modal fade" id="edit_params" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="params_serviceLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="params_serviceLabel">Modification de : <small id="title-params">Domaine</small></h5>
        <button type="button" class="close" data-dismiss="modal" onclick="reloadIfResp()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="updateparams-form">
          <div class="row">
            <div class="form-group col">
              <label for="lv-code">Params code</label>
              <input type="text" class="form-control" id="lv-code" name="param_code" aria-describedby="lv-code" required>
            </div>
            <div class="form-group col">
              <label for="lv-lib">Params lib</label>
              <input type="text" class="form-control" id="lv-lib" name="param_lib" aria-describedby="lv-lib" required>
            </div>
            <div class="form-group col for-resp">
              <label for="lv-value">Params value</label>
              <input type="text" class="form-control" id="lv-value" name="param_value" aria-describedby="lv-value" required>
              <div class="eye-hidden-password"><i class="fa fa-eye-slash" aria-hidden="true"></i></div>
            </div>
          </div>
          <input type="hidden" data-code="" id="code_params" name="code_params">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-value="rakoto" data-dismiss="modal" onclick="reloadIfResp()">Fermer</button>
        <button type="button" class="btn btn-primary" id="update_params">Sauver</button>
      </div>
    </div>
  </div>
</div>

<script>
  function reloadIfResp() {
    if ($("#code_params").val() === 'email_destinataire') {
      location.reload();
    }
  }

  $('.icon_edit').on('click', function() {
    $('.form-group.col.for-resp input').attr('type', 'password');
    $('.eye-hidden-password i').addClass("fa-eye-slash");
    $('.eye-hidden-password i').removeClass("fa-eye");
    if ($(this).data('code') === 'PWD_AD' || $(this).data('code') === 'email_password') {
      $('.form-group.col.for-resp input').attr('type', 'password');
      $('.eye-hidden-password').show();
    } else {
      $('.eye-hidden-password').hide();
      $('.form-group.col.for-resp input').attr('type', 'text');
    }
    let users = <?= $users ?>;
    if ($(this).data('code') == 'email_destinataire') {
      let str = '<select class="form-control" id="lv-value" name="param_value" aria-describedby="lv-value" required="required">';
      users.forEach(item => {
        if (item.u_email != null) {
          str += `
                <option value="` + item.u_email + `">` + item.u_email + `</option>
                `;
        } else {
          str += `
                <option value="` + item.u_email + `" disabled>` + item.u_prenom + ` ` + item.u_nom + `(Pas de mail)</option>
                `;
        }
      })
      str += `</select>`;
      $('#updateparams-form .for-resp').html(`
          <label for="lv-value">Params value</label>
          ` + str + `
        `)
    }
    $('#title-params').html($(this).data('code'))
    $('#updateparams-form #lv-code').val($(this).data('code'))
    $('#updateparams-form #lv-lib').val($(this).data('lib'))
    $('#updateparams-form #lv-value').val($(this).data('value'))
    $('#code_params').val($(this).data('code'));

  })

  $('.eye-hidden-password').click(function() {
    if ($('.form-group.col.for-resp input').attr("type") == "text") {
      $('.form-group.col.for-resp input').attr('type', 'password');
      $('.eye-hidden-password i').removeClass("fa-eye").addClass("fa-eye-slash");
    } else if ($('.form-group.col.for-resp input').attr("type") == "password") {
      $('.form-group.col.for-resp input').attr('type', 'text');
      $('.eye-hidden-password i').removeClass("fa-eye-slash").addClass("fa-eye");
    }
  })

  // Modification parametre
  $('#update_params').on('click', function() {
    ajax_func($('#updateparams-form').serializeArray(), 'params/update_params')
  })

  // Tester si les params messagerie sont correctes
  $("#test_messagerie").on('click', function() {
    $.ajax({
      url: '<?= site_url('/params/send_test') ?>',
      method: "POST",
      data: null,
      beforeSend: function() {
        $('.progress .message').html('Envoie de mail en cours ...')
        $(".progress").addClass('active');
      },
      success: function(msg) {
        $(".progress").removeClass('active');
        location.reload();
      }
    })
  })

  $('#service-form').on('submit', function(e) {
    e.preventDefault();
    ajax_func($(this).serializeArray(), 'params/add_service');
  })

  $('#edit-service-form').on('submit', function(e) {
    e.preventDefault();
    ajax_func($(this).serializeArray(), 'params/update_service');
  })

  $('#lv-service-u').change(function() {
    $('#lv-service-u option:selected').each(function() {
      $('#lv-label-u').val($(this).html());
      $('#lv-desc-u').val($(this).data('desc'));
      $('#id_service_add').val($(this).val());
    })
  })
</script>