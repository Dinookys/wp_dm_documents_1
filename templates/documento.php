<div class="dm-document dm-documento" >
    <?php echo $breadCrumbs; ?>

    <?php if($this->root_category && $this->show_title == false): ?>
        <h3 class="dm-title" ><?php echo $documento->titulo; ?></h3>
    <?php else: ?>
        <h2 class="dm-title" ><?php echo $documento->titulo; ?></h2>
    <?php endif; ?>

    <div class="data"><small><?php echo $documento->data; ?></small></div>
    <div><?php echo wpautop($documento->descricao); ?></div>

    <?php require DM_DOCUMENTS_DIR . 'templates/parts/documento_anexos.php'; ?>

</div>