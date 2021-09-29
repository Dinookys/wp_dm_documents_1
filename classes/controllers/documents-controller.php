<?php

class DM_Documents_Controller extends DM_Base_Controller
{
    protected $validationFields = [
        'titulo' => 'required',
        'ID_category' => 'required',
    ];

    public function __construct()
    {
        $this->model = new DM_Document_Model();

        /**
         * Recuperando a lista de campos da tabela
         */
        $this->fields = $this->model->fields;

        parent::__construct();
    }

    public function save(WP_REST_Request $request)
    {
        $request->set_param('documentos', json_encode($request->get_param('documentos') ?? [], JSON_UNESCAPED_UNICODE));
        $save = parent::save($request);

        if(isset($save['item']) && is_string($save['item']['documentos'])) {
            $save['item']['documentos'] = json_decode($save['item']['documentos'], true);
        }
        return $save;
    }

    public function edit(WP_REST_Request $request)
    {
        $edit = parent::edit($request);

        if ($edit) {
            if ($edit['documentos']) {
                $edit['documentos'] = json_decode($edit['documentos'], true);
            } else {
                $edit['documentos'] = $this->model->getScaffold()['documentos'];
            }
        }

        return $edit;
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
