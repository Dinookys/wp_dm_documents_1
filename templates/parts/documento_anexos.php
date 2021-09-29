<div class="dm-document-items" >
    <?php $docs = json_decode($documento->documentos); ?>
    <?php foreach($docs as $doc_parts) :
        foreach($doc_parts as $doc) : ?>
        <div class="dm-document-loop-item" >
            <h4 class="dm-title" ><?php echo $doc->name; ?></h4>
            <div class="cols cols-50">
                <div>                
                    <?php if($doc->filesize): ?>
                    <div>
                        <strong>Tamanho: </strong><?php echo $doc->filesize; ?>
                    </div>
                    <?php endif; ?>
                    <?php if($doc->subtype): ?>
                    <div>
                        <strong>Tipo: </strong><?php echo $doc->subtype; ?>
                    </div>
                    <?php endif; ?>                    
                </div>
                <div class="dm-document-text-right" >
                    <a 
                        href="<?php echo $doc->url; ?>" 
                        target="_blank" 
                        class="button button-primary btn btn-primary"
                    >
                    <span class="dm-icon" >
                        <?php echo file_get_contents(DM_DOCUMENTS_DIR . 'assets/images/download.svg'); ?>
                    </span>
                    Download
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; 
        endforeach; ?>
</div>