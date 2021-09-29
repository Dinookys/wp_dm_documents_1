<?php

class DM_Routes
{
  protected static $_instance = null;

  public function init()
  {
    add_action('rest_api_init', array($this, 'registerRoutes'));
  }

  public function registerRoutes()
  {

    //FrontEnd
    
    $documentController = new DM_Documents_Controller();  
    $documentCategoriesController = new DM_Categories_Controller();  

    //Backend
    register_rest_route(DM_DOCUMENTS_REST_NAMESPACE, '/b/documents/list', array(
      'methods' => 'GET',
      'callback' => array($documentController, 'listItems'),
      'permission_callback' => function() {
        return '';
      }
    ));

    register_rest_route(DM_DOCUMENTS_REST_NAMESPACE, '/b/documents/edit', array(      
      'methods' => 'GET',
      'callback' => array($documentController, 'edit'),
      'permission_callback' => array($this, 'is_admin')
    ));

    register_rest_route(DM_DOCUMENTS_REST_NAMESPACE, '/b/documents/save', array(
      'methods' => 'POST',
      'callback' => array($documentController, 'save'),
      'permission_callback' => array($this, 'is_admin')
    ));

    register_rest_route(DM_DOCUMENTS_REST_NAMESPACE, '/b/documents/delete', array(
      'methods' => 'POST',
      'callback' => array($documentController, 'delete'),
      'permission_callback' => array($this, 'is_admin')
    ));

    //Backend
    register_rest_route(DM_DOCUMENTS_REST_NAMESPACE, '/b/categories/list', array(
      'methods' => 'GET',
      'callback' => array($documentCategoriesController, 'listItems'),
      'permission_callback' => function() {
        return '';
      }
    ));

    register_rest_route(DM_DOCUMENTS_REST_NAMESPACE, '/b/categories/edit', array(      
      'methods' => 'GET',
      'callback' => array($documentCategoriesController, 'edit'),
      'permission_callback' => array($this, 'is_admin')
    ));

    register_rest_route(DM_DOCUMENTS_REST_NAMESPACE, '/b/categories/save', array(
      'methods' => 'POST',
      'callback' => array($documentCategoriesController, 'save'),
      'permission_callback' => array($this, 'is_admin')
    ));

    register_rest_route(DM_DOCUMENTS_REST_NAMESPACE, '/b/categories/delete', array(
      'methods' => 'POST',
      'callback' => array($documentCategoriesController, 'delete'),
      'permission_callback' => array($this, 'is_admin')
    ));

  }

  public function is_admin ()
  {
    
    if(!is_user_logged_in() && !is_admin() ) {
        die(json_encode([
            'messages' => [
                'notice_error' => 'Está é uma rota protegida, por favor verifique o token!!!!'
            ]
        ], JSON_UNESCAPED_UNICODE));
    }

    return '';
    
  }
}

add_action('init', array(new DM_Routes, 'init'));