<div class="dm-document-items" >
    <?php foreach($documentos['items'] as $documento): ?>
        <div class="dm-document-loop-item" >
            <div class="dm-document-loop-item-header">
                <div class="data"><small><?php echo $documento->data; ?></small></div>
                <strong><?php echo $documento->titulo; ?></strong>
            </div>
            <div class="dm-document-loop-item-content">
                <?php echo wpautop($documento->descricao); ?>
                <?php require DM_DOCUMENTS_DIR . 'templates/parts/loop_documento_anexos.php'; ?>
            </div>
            <div class="dm-document-loop-item-footer">
                <a href="<?php echo $current_url; ?>?dmdoc=<?php echo $documento->ID; ?>" class="button button-primary btn btn-primary">Detalhes</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php 
$total_pages = $documentos['total_pages'];
if($total_pages) : ?>
    <?php 
        echo paginate_links(array(
            'total' => $total_pages,
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged'))
        ));  
    ?>
<?php endif; ?>