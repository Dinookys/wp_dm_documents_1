<div class="dm-document dm-categorias" >
<?php require DM_DOCUMENTS_DIR . '/templates/parts/search.php'; ?>

<table>
    <thead>
    <tr>
        <th>Nome</th>
        <th>Descrição</th>
        <th class="dm-document-text-right" >Detalhes</th>
    </tr>
    </thead>
    <tbody>
    <?php if(count($categorias)): ?>
        <?php foreach($categorias as $key => $categoria) : ?>
            <tr>
                <td><?php echo $categoria->titulo; ?></td>
                <td><?php echo $categoria->descricao; ?></td>
                <td class="dm-document-text-right" >
                    <a class="button btn" href="<?php echo $current_url; ?>?dmcat=<?php echo $categoria->ID; ?>">Ver</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="3" class="align-center" >Nenhuma categoria encontrada</td>
    </tr>
    <?php endif; ?>
    </tbody>    
</table>

<?php if($total_pages) : ?>
    <?php 
        echo paginate_links(array(
            'total' => $total_pages,
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged'))
        ));  
    ?>
<?php endif; ?>

</div>
<style>
    #dm-document {
        max-width: 100%;
        overflow-x: auto;
    }

    #dm-document thead th,
    #dm-document tbody td {
        vertical-align: middle;
    }

    #dm-document tbody tr:nth-child(odd) td {
        background-color: #eee;
    }

    #dm-document tbody tr:hover td {
        background-color: rgba(0, 250, 100, .3);
    }

    #dm-document tr td:last-child a {
        display: block;
        width: 100%;
    }

    #dm-document thead th {
        background-color: #383838;
        color: white;
        position: sticky;
        top: 0;
    }
</style>