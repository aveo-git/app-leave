<h6 class="py-2 border-bottom text-uppercase">Parametre LDAP</h6>
<form id="params-form">
    <div class="row">
        <?php foreach($params_ldap as $p): ?>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="lv-<?= $p->param_code ?>"><?= $p->param_lib ?> <ion-icon class="icon_edit" data-toggle="modal" data-target="#edit_params" data-code="<?= $p->param_code ?>" data-lib="<?= $p->param_lib ?>" data-value="<?= $p->param_value ?>"  name="create-outline"></ion-icon></label>
                <input type="text" class="form-control" value="<?= $p->param_value ?>" id="lv-<?= $p->param_code ?>" disabled>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</form>
<br>
<h6 class="py-2 border-bottom text-uppercase">Parametre méssagerie</h6>
<form id="params-form">
    <div class="row">
        <?php foreach($params_email as $p): ?>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="lv-<?= $p->param_code ?>"><?= $p->param_lib ?> <ion-icon class="icon_edit" data-toggle="modal" data-target="#edit_params" data-code="<?= $p->param_code ?>" data-lib="<?= $p->param_lib ?>" data-value="<?= $p->param_value ?>" name="create-outline"></ion-icon></label>
                <input type="text" class="form-control" value="<?= $p->param_value ?>" id="lv-<?= $p->param_code ?>" disabled>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</form>

<!-- Modal pour mofication LDAP -->
<div class="modal fade" id="edit_params" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="params_serviceLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="params_serviceLabel">Modification de : <small id="title-params">Domaine</small></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="background-color: #FFFFFF">
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
               <div class="form-group col">
                  <label for="lv-value">Params value</label>
                  <input type="text" class="form-control" id="lv-value" name="param_value" aria-describedby="lv-value" required>
               </div>
            </div>
            <input type="hidden" data-code="" id="code_params" name="code_params">
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary" id="update_params">Sauver</button>
      </div>
    </div>
  </div>
</div>

<script>
    $('.icon_edit').on('click', function() {
        $('#title-params').html($(this).data('code'))
        $('#updateparams-form #lv-code').val($(this).data('code'))
        $('#updateparams-form #lv-lib').val($(this).data('lib'))
        $('#updateparams-form #lv-value').val($(this).data('value'))
        $('#code_params').val($(this).data('code'));
    })

    // Modification parametre
   $('#update_params').on('click', function() {
      let data = $('#updateparams-form').serializeArray();
      $.ajax({
         url: "<?= site_url('params/update_params') ?>",
         method: "POST",
         data: data,
         success: function(msg) {
            location.reload();
         }
      })
   })
</script>