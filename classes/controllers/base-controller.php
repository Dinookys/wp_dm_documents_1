<?php

class DM_Base_Controller extends DM_Abstract_Controller
{
    protected $fields = [];
    protected $validationFields = [];

    public function __construct()
    { 
        parent::__construct();
    }

    public function store(WP_REST_Request $request)
    {
        $result = [];
        $data = $this->sanitize_fields_data($request->get_params());

        $this->validationData($data);

        if (empty($this->validationsMessages) && $result = $this->model->insert($data)) {

            return array(
                'item' => $result,
                'messages' => ['notice_success' => $this->messages->generic_success],
            );
        }

        return array(
            'messages' => count($this->validationsMessages) ?
            [
                'validation_errors' => $this->validationsMessages,
            ]
            : ['notice_error' => $this->messages->generic_error],
        );
    }

    public function save(WP_REST_Request $request)
    {

        if ($request->get_param('ID')) {
            return $this->update($request);
        }

        return $this->store($request);
    }

    public function update(WP_REST_Request $request)
    {

        $data = $this->sanitize_fields_data($request->get_params());
        $this->validationData($data);

        if (empty($this->validationsMessages) && $this->model->update($data['ID'], $data)) {

            return array(
                'item' => $data,
                'messages' => ['notice_success' => 'Atualizado com sucesso!'],
            );
        }

        return array(
            'messages' => count($this->validationsMessages) ?
            [
                'validation_errors' => $this->validationsMessages,
            ]
            : ['notice_info' => $this->messages->generic_info],
        );
    }

    public function edit(WP_REST_Request $request)
    {

        $ID = $request->get_param('id');
        $item = $this->model->getBy($ID);

        return $item;
    }

    public function delete(WP_REST_Request $request)
    {
        parent::delete($request);
        return $this->listItems($request);
    }

    public function listItems(WP_REST_Request $request)
    {
        $filter = $request->get_param('filter') ?: [];

        $current_page = $request->get_param('page');

        if (!filter_var($current_page, FILTER_VALIDATE_INT)) {
            $current_page = 1;
        }

        $total_pages = $this->model->totalPages($filter)->pages;

        if ($current_page > $total_pages) {
            $current_page = $total_pages;
        }

        return array(
            'items' => $this->model->listItems([
                'filter' => $filter,
                'page' => $current_page,
            ]),
            'total_pages' => (int) $total_pages,
            'current_page' => (int) $current_page,
        );
    }

    public function getPublishedByID (WP_REST_Request $request)
    {        
        return $this->model->getByQuery("status='publish' AND ID=" . $request->get_param('ID'));
    }
}
