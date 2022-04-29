<div>
    <div class="row">
        <div class="col">
            <h6 class="py-2 border-bottom text-uppercase">Ajouter un jour ferié</h6>
        </div>
    </div>
    <br>
    <form id="jourferie-form">
        <div class="row">
            <div class="form-group col">
                <label class="" for="c-debut">Debut</label>
                <input type="date" class="form-control" id="c-debut" value="" name="c_debut" required>
            </div>
            <div class="form-group col">
                <label class="" for="c-fin">Fin *</label>
                <input type="date" class="form-control" id="c-fin" value="" name="c_fin">
                <small>* Facultatif s'il n'y a qu'un seul jour</small>
            </div>
        </div>
        <div class="row">
            <div class="form-group col">
                <label class="" for="c-description">Description :</label>
                <textarea name="c_description" id="c-description" class="form-control" cols="10" rows="3" required></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </form>
    <br>
    <div class="row">
        <div class="col">
            <h6 class="py-2 border-bottom text-uppercase">Clôture d'agence (Année 2022)</h6>
        </div>
    </div>
    <br>
    <form id="cloture-form">
        <div class="row">
            <div class="form-group col">
                <label class="" for="c-debut-cloture">Debut</label>
                <input type="date" class="form-control" id="c-debut-cloture" value="" name="c_debut" required>
            </div>
            <div class="form-group col">
                <label class="" for="c-fin-cloture">Jusqu'au</label>
                <input type="date" class="form-control" id="c-fin-cloture" value="" name="c_fin" required>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>
    </form>
</div>

<script>
    $('#jourferie-form').on('submit', function(e) {
        e.preventDefault();
        let data = $(this).serializeArray();
        data.push({name: "c_flag", value: 0});
        console.dir(data)
        ajax_func(data, 'params/add_calendar');
    })

    $('#cloture-form').on('submit', function(e) {
        e.preventDefault();
        let data = $(this).serializeArray();
        data.push({name: "c_description", value: "Clôture d'agence"});
        data.push({name: "c_flag", value: 1});
        ajax_func(data, 'params/add_calendar');
    })
</script>