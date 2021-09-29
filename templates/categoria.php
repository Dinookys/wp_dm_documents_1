<div class="dm-document dm-categoria" >
<?php echo $breadCrumbs; ?>

<?php if($this->root_category && $this->show_title == false): ?>

    <?php if($this->root_category->ID != $categoria['ID']) : ?>
        <h3 class="dm-title" ><?php echo $categoria['titulo']; ?></h3>
    <?php endif; ?>

<?php else: ?>
    <h2 class="dm-title" ><?php echo $categoria['titulo']; ?></h2>
<?php endif; ?>
    
    <div class="descricao"><?php echo wpautop($categoria['descricao']); ?></div>
    
<?php if($subcategorias): ?>
    <div class="dm-box" >
        <div class="dm-box-header">
            <h4>Categorias em <?php echo $categoria['titulo']; ?></h4>
        </div>
        <div class="dm-box-content">
            <?php require DM_DOCUMENTS_DIR . 'templates/parts/subcategorias.php'; ?>
        </div>
    </div>
<?php endif; ?>
    
<?php if($documentos['items']): ?>
    <div class="dm-box" >
        <div class="dm-box-header">
            <h4>Documentos</h4>
        </div>
        <?php require DM_DOCUMENTS_DIR . 'templates/parts/documentos_filtro.php'; ?>
        <div class="dm-box-content">
            <?php require DM_DOCUMENTS_DIR . 'templates/parts/documentos.php'; ?>
        </div>
    </div>
<?php endif; ?>
</div>