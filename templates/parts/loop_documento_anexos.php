<?php $docs = json_decode($documento->documentos); ?>
<?php foreach($docs as $doc_parts) :
    foreach($doc_parts as $doc) : ?>
    <div class="dm-document-box-document" >        
        <div class="cols cols-65-35">
            <div>
                <?php if($doc->name): ?>
                <div>
                    <strong>Arquivo: </strong><?php echo $doc->name; ?>
                </div>
                <?php endif; ?>
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