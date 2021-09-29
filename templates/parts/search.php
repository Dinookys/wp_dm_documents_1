<form action="" class="dm-document-search" >
    <div class="cols cols-50">
        <div>
            <input type="text" name="n" value="<?php echo filter_input(INPUT_GET, 'n'); ?>" placeholder="Nome" >
        </div>
        <div>
            <button type="submit" class="button btn"  >Pesquisar</button>
        </div>
    </div>
</form>