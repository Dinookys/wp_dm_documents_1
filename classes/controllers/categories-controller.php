<?php

class DM_Categories_Controller extends DM_Base_Controller
{    

    protected $validationFields = [
        'titulo' => 'required'
    ];
    
    public function __construct()
    {        
        $this->model = new DM_Category_Model();        
        
        /**
         * Recuperando a lista de campos da tabela
         */
        $this->fields = $this->model->fields;

        parent::__construct();
    }

    public function save(WP_REST_Request $request)
    {
        $result = parent::save($request);

        if(isset($result['messages']['notice_success'])) {
            $result['categories'] = $this->model->getCategoriesOrder();
        }

        return $result;
    }

    public function delete(WP_REST_Request $request)
    {

        $ID = $request->get_param('ID');
        if($ID) {
            /**
             * @var wpdb
             */
            $db = $this->model->getDB();
            $db->query(
                $db->prepare(
                    "UPDATE {$this->model->getTableName()} SET ID_parent='0' WHERE ID_parent=%d",
                    $ID
                )
            );
        }
        return parent::delete($request);
    }

    public function listItems (WP_REST_Request $request)
    {
        if($term = $request->get_param('term')) {
            $request->set_param('filter', array(
                'AND' => array(
                    'titulo LIKE' => "%$term%"
                )
                ));
        }
        return parent::listItems($request);
    }

}
