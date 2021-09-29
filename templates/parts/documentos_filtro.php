<form action="" class="dm-document-search" >
    <div class="cols cols-65-35">
        <div>
            <input type="text" name="docname" value="<?php echo filter_input(INPUT_GET, 'docname') ?>" placeholder="Buscar por nome" >
        </div>
        <div>
            <button type="submit">Filtrar</button>
        </div>
    </div>
</form>