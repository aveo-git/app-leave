<div class="segment" style="min-height: 80vh">
   <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
         <a class="nav-link" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">Général</a>
      </li>
      <li class="nav-item">
         <a class="nav-link active" id="users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">Utilisateurs</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" id="calendar-tab" data-toggle="tab" href="#calendar" role="tab" aria-controls="calendar" aria-selected="false">Calendrier</a>
      </li>
   </ul>
   <br>
   <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade" id="general" role="tabpanel" aria-labelledby="general-tab">
         <div>
            <?= $general ?>
         </div>
      </div>
      <div class="tab-pane fade show active" id="users" role="tabpanel" aria-labelledby="users-tab"><?= $users ?></div>
      <div class="tab-pane fade" id="calendar" role="tabpanel" aria-labelledby="calendar-tab">calendar</div>
   </div>
</div>