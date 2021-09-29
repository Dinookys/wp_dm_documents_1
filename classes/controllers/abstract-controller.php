<?php

abstract class DM_Abstract_Controller
{
    protected $model = null;
    protected $fields = [];
    protected $filterAlias = [];
    protected $filterColumns = [];
    protected $messages;

    use DM_Validation;

    public function __construct()
    {
        $this->messages = new stdClass();
        $this->messages->generic_error = 'Houve um problema, tente novamente mais tarde.';
        $this->messages->generic_success = 'Salvo com sucesso!';
        $this->messages->generic_info = 'Sem alterações';
    }

    public function listItems(WP_REST_Request $request)
    {}

    public function update(WP_REST_Request $request)
    {}

    public function store(WP_REST_Request $request)
    {}

    public function delete(WP_REST_Request $request)
    {
        return $this->model->delete($request->get_param('ID'));
    }

    protected function makeFilters($column, $search)
    {

        $filters = [];
        $s = trim($search);
        $like_value = "{$s}%";
        $like = ' LIKE ';

        if (!empty($column)) {
            $alias = $this->filterAlias[$column];

            if (is_array($alias)) {
                foreach ($alias as $columnName) {
                    $filters[$columnName . $like] = $like_value;
                }
            } elseif ($alias) {
                $filters[$alias . $like] = $like_value;
            } else {
                $filters[$column . $like] = $like_value;
            }

            return $filters;

        } elseif (empty($column) && !empty($search)) {

            $filterColumns = !empty($this->filterColumns) ? $this->filterColumns : $this->fields;

            foreach ($filterColumns as $fieldName) {
                $alias = $this->filterAlias[$fieldName];

                if (is_array($alias)) {
                    foreach ($alias as $columnName) {
                        $filters[$columnName . $like] = $like_value;
                    }
                } elseif ($alias) {
                    $filters[$alias . $like] = $like_value;
                } else {
                    $filters[$fieldName . $like] = $like_value;
                }
            }
        }

        return $filters;

    }

    protected function sanitize_fields_data($dirty_data = array()): array
    {
        $data = [];

        foreach ($this->fields as $field) {
            if (isset($dirty_data[$field])) {
                $data[$field] = $dirty_data[$field];
            }
        }

        return $data;
    }
}
