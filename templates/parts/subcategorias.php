<div class="dm-document-items">
<?php foreach($subcategorias as $subcategoria): ?>
    <div class="dm-subcategoria dm-document-loop-item">
        <div class="dm-document-loop-item-header">
            <strong><?php echo $subcategoria->titulo ?></strong>
        </div>
        <div class="dm-document-loop-item-content">            
            <div class="dm-descricao">
                <?php echo wpautop($subcategoria->descricao); ?>
            </div>
        </div>
        <div class="dm-document-loop-item-footer">
            <a href="<?php echo $current_url; ?>?dmcat=<?php echo $subcategoria->ID; ?>" class="button button-primary btn btn-primary">Ver</a>
        </div>
    </div>
<?php endforeach; ?>
</div>