<?php
/**
 * Plugin Name: DM Documentos V1
 * Description: Gerenciador de documentos
 * Version: 1.0.5
 * Author: <a href="https://mediavirtual.com.br">Media Virtual</a>
 */

//DEFINES
define('DM_DEBUG', false);
define('DM_DOCUMENTS_DIR', plugin_dir_path(__FILE__));
define('DM_DOCUMENTS_URL', plugin_dir_url(__FILE__));
define('DM_DOCUMENTS_REST_NAMESPACE', 'dm-documents/v1');

//INCLUDES
include_once DM_DOCUMENTS_DIR . 'models.php';
include_once DM_DOCUMENTS_DIR . 'controllers.php';
include_once DM_DOCUMENTS_DIR . 'router.php';
include_once DM_DOCUMENTS_DIR . 'hooks.php';
include_once DM_DOCUMENTS_DIR . 'helpers.php';
include_once DM_DOCUMENTS_DIR . 'shortcodes.php';

class DM_Bootstrap
{

    protected $version = '1.0.5';

    public function __construct()
    {
        //Admin
        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue'));
        add_action('admin_menu', array($this, 'admin_page'));
        add_action('plugins_loaded', array($this, 'create_tables'));
    }

    public function admin_enqueue($hook)
    {

        if ($hook !== 'toplevel_page_dm-document') {
            return;
        }

        $model = new DM_Base_Model();

        if (!did_action('wp_enqueue_media')) {
            wp_enqueue_media();
        }

        $ver = fileatime(DM_DOCUMENTS_DIR . 'assets/admin/chunk-vendors.js');

        wp_enqueue_style('dm-document', DM_DOCUMENTS_URL . 'assets/admin/app.css', [], $ver);
        wp_enqueue_style('vue-js', DM_DOCUMENTS_URL . 'assets/admin/chunk-vendors.css', [], $ver);

        wp_enqueue_script('vue-js', DM_DOCUMENTS_URL . 'assets/admin/chunk-vendors.js', [], $ver, true);
        wp_enqueue_script('dm-document', DM_DOCUMENTS_URL . 'assets/admin/app.js', ['vue-js'], $ver, true);
        wp_localize_script('dm-document', 'dm_documents', [
            'restAPI' => get_rest_url() . DM_DOCUMENTS_REST_NAMESPACE,
            'token' => wp_create_nonce('wp_rest'),
            'status' => $model->getStatus(),
            'categories' => (new DM_Category_Model())->getCategoriesOrder(),
            'empty' => [
                'category' => (new DM_Category_Model)->getScaffold(),
                'document' => (new DM_Document_Model)->getScaffold(),
            ],
        ]);
    }

    public function enqueue()
    {

    }

    public function create_tables()
    {
        if (get_option('dm_document_version', '0.0.0') != $this->version || DM_DEBUG) {
            (new DM_Document_Model())->createTable()->updateTable();
            (new DM_Category_Model())->createTable()->updateTable();
            update_option('dm_document_version', $this->version);            
        }
    }

    public function activation_hook ()
    {
        $this->create_tables();
    }

    public function admin_page()
    {
        add_menu_page(
            "DM Documentos",
            "DM Documentos",
            "manage_options",
            "dm-document",
            array($this, 'admin_page_html'),
            "dashicons-format-aside",
            "22"
        );
    }

    public function admin_page_html()
    {
        echo '<div id="dm-document" ></div>';
        echo '<div>' . $this->version . '</div>';
    }
}

$DM_Bootstrap = new DM_Bootstrap();
register_activation_hook(__FILE__, array($DM_Bootstrap, 'activation_hook'));
