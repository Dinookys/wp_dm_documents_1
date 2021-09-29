<?php

class DM_Shortcode
{

    public $root_category = false;
    public $show_title = false;

    public function __construct()
    {
        add_shortcode('dm_categorias', array($this, 'dm_categorias'));
        add_shortcode('dm_documentos', array($this, 'dm_documentos'));
        add_action('wp_head', array($this, 'addCSSOnHeader'));
    }

    public function dm_documentos($attrs)
    {
        $attrs = shortcode_atts(array(
            'doc' => ''
        ), $attrs);

        ob_start();

        $documento = $this->getDocumento($attrs['doc']);
        if ($documento) {
            require DM_DOCUMENTS_DIR . 'templates/parts/documento_anexos.php';
        }

        return ob_get_clean();
    }

    public function dm_categorias($attrs)
    {
        $attrs = shortcode_atts(array(
            'cat' => '',
            'show_title' => false
        ), $attrs);

        if($attrs['cat']) {
            $this->root_category = (object) $this->getCategoria($attrs['cat']);
        }

        $this->show_title = $attrs['show_title'];

        ob_start();

        $cat_ID = isset($_GET['dmcat']) ? $_GET['dmcat'] : $attrs['cat'];
        $doc_ID = isset($_GET['dmdoc']) ? $_GET['dmdoc'] : '';

        require DM_DOCUMENTS_DIR . '/templates/css.php';

        if ($cat_ID && !$doc_ID) {
            $this->renderCategoria($cat_ID);
        } else if ($doc_ID) {
            $this->renderDocumento($doc_ID);
        } else {
            $this->renderListaCategorias();
        }

        return ob_get_clean();

    }

    protected function renderDocumento($id)
    {
        $documento = $this->getDocumento($id);
        if ($documento) {

            if($this->root_category) {
                $first_name = $this->root_category->titulo;
            } else {
                $first_name = 'Lista';
            }            

            $breadCrumbs = dm_create_breadcrumbs_HTML($this->createBreadCrumb($documento), $first_name, true);

            require DM_DOCUMENTS_DIR . 'templates/documento.php';
        }
    }

    protected function renderCategoria($cat)
    {
        $categoria = $this->getCategoria($cat);

        if ($categoria) {

            if($this->root_category) {
                $first_name = $this->root_category->titulo;
            } else {
                $first_name = 'Lista';
            }

            $breadCrumbs = dm_create_breadcrumbs_HTML($this->createBreadCrumb($categoria), $first_name, true);            

            $subcategorias = $this->getSubCategorias($cat);
            $documentos = $this->getDocumentos($cat);
            $current_url = $this->current_url();
            require DM_DOCUMENTS_DIR . 'templates/categoria.php';
        }
    }

    protected function renderListaCategorias()
    {
        $filter = [
            'status =' => 'publish',
            'ID_parent =' => 0,
        ];

        if(isset($_GET['n'])) {
            $filter['titulo LIKE'] = '%'. filter_input(INPUT_GET, 'n') .'%';
        }

        $model = new DM_Category_Model();

        $page = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

        $categorias = $model->listItems([
            'filter' => $filter,
            'page' => $page,
        ]);

        $total_pages = $model->totalPages($filter)->pages;
        $current_url = $this->current_url();

        require DM_DOCUMENTS_DIR . 'templates/categorias.php';
    }

    protected function getCategoria($cat)
    {
        if (!$cat || !is_numeric($cat)) {
            return;
        }

        $model = new DM_Category_Model();
        return $model->getByQuery('ID=' . $cat . ' AND status="publish"');
    }

    protected function getDocumento($ID)
    {
        if (!$ID || !is_numeric($ID)) {
            return;
        }

        $model = new DM_Document_Model();
        return $model->getByQuery('ID=' . $ID . ' AND status="publish"', OBJECT);
    }

    protected function getSubCategorias($ID)
    {
        if (!$ID || !is_numeric($ID)) {
            return;
        }

        $model = new DM_Category_Model();
        return $model->getAllByQuery('ID_parent=' . $ID . ' AND status="publish"');
    }

    protected function getDocumentos($cat)
    {
        if (!$cat || !is_numeric($cat)) {
            return;
        }

        $model = new DM_Document_Model();

        $page = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

        $likeName = filter_input(INPUT_GET, 'docname');

        $filter = [
            'AND' => [
                'status =' => 'publish',
                'ID_category=' => $cat,
            ],
        ];

        if($likeName) {
            $filter['AND']['titulo LIKE'] = "%{$likeName}%";
        }

        $documentos = $model->listItems([
            'filter' => $filter,
            'page' => $page,
        ]);

        $total_pages = $model->totalPages($filter)->pages;

        return [
            'items' => $documentos,
            'total_pages' => $total_pages,
        ];
    }

    protected function createBreadCrumb($obj, $acc = [])
    {
        if (is_array($obj)) {
            $obj = (object) $obj;
        }

        if($this->root_category && $obj->ID == $this->root_category->ID) return $acc;

        array_unshift($acc, $obj);

        if (isset($obj->ID_category)) {
            $ID_cat = $obj->ID_category;
        } else {
            $ID_cat = $obj->ID_parent;
        }

        if ($ID_cat) {
            $obj = (new DM_Category_Model())->getByQuery('ID=' . $ID_cat);
            $acc = $this->createBreadCrumb($obj, $acc);
        }

        return $acc;
    }

    protected function current_url()
    {
        return get_permalink( get_the_ID() );
    }

    public function addCSSOnHeader()
    {
        if (is_single() || is_page()) {
            global $post;
            if (has_shortcode($post->post_content, 'dm_documentos')) {
                require DM_DOCUMENTS_DIR . 'templates/css.php';
            }
        }
    }

}

new DM_Shortcode();
