<?php

trait DM_Validation
{
    protected $validationFields = [];
    protected $errorMessages = [
        'unique' => '%s já cadastrado(a).',
        'required' => '%s não pode ser vazio.',
        'min' => '%s deve ter no minímo %q caracteres.',
        'equal' => 'O campo "%f" deve ser igual ao campo "%c".',
        'equal_as_value' => 'O valor do campo "%f" deve ser igual a "%c".',
        'email' => '%s inválido.',
        'cpf' => '%s inválido.',
        'length' => 'O campo "%s" deve ter "%l" caracteres.'
    ];

    protected $currentFieldName = '';
    protected $currentMethod = '';

    protected $validationsMessages = [];

    protected function handlerValidations($fieldName, $validationsString)
    {
        // Return true is no validation for the field
        if (!$validationsString) {
            return true;
        }

        // Set current fieldName
        $this->currentFieldName = $fieldName;

        // Get Validation Types
        $validations = explode('|', $validationsString);

        foreach ($validations as $validation) {
            $valid_arr = explode(':', $validation);
            $method = trim(array_shift($valid_arr));
            $args = trim(array_shift($valid_arr));

            // Set currentMethod name
            $this->currentMethod = $method;

            if(method_exists($this, $method) && $args) {
                $this->$method($fieldName, trim($args));
            } else if(method_exists($this, $method) && !$args) {
                $this->$method($fieldName);
            }
        }
    }

    protected function validationData($data = array())
    {
        // Populate for validation
        $this->data = $data;

        if (is_array($this->validationFields)) {
            foreach ($this->validationFields as $fieldName => $validationsString) {

                if ($fieldName === '*') {
                    foreach (array_keys($data) as $fieldNameData) {
                        $this->handlerValidations($fieldNameData, $validationsString);
                    }
                } else {
                    $this->handlerValidations($fieldName, $validationsString);
                }

            }
        }

        return $this->validationsMessages;
    }

    protected function required($fieldName, $args = '')
    {
        $value = $this->data[$fieldName];

        if (empty($value) || is_null($value) || $value == '') {
            $this->prepareMessage($this->prepareFieldName($fieldName));
        }

    }

    protected function email($fieldName, $args = '') {
        $value = $this->data[$fieldName];

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->prepareMessage($this->prepareFieldName($fieldName));
        }
    }

    protected function equal($fieldName, $compareField = '') {
        $value = $this->data[trim($fieldName)];
        $compare = $this->data[trim($compareField)];

        if ($value != $compare) {
            $this->prepareMessage([$this->prepareFieldName($fieldName), $this->prepareFieldName($compareField)], ['%f', '%c']);
        }
    }

    protected function equal_as_value($fieldName, $compare = '') {
        $value = $this->data[trim($fieldName)];

        if ($value != $compare) {
            $this->prepareMessage([$this->prepareFieldName($fieldName), $compare], ['%f', '%c']);
        }
    }

    protected function min($fieldName, $quantity = '')
    {
        $quantity = is_numeric($quantity) ? $quantity : 4;
        $value = (int) strlen($this->data[trim($fieldName)]);

        if ($value < $quantity) {
            $this->prepareMessage([$this->prepareFieldName($fieldName), $quantity], ['%s', '%q']);
        }

    }

    protected function unique($fieldName, $compareField = 'ID')
    {
        $fieldNameReturn = $compareField;

        $value = $this->data[$fieldName];

        $tableName = $this->model->getTableName();
        $query = "SELECT COUNT($fieldNameReturn) FROM $tableName WHERE $fieldName=%s";

        $arrayValues = array($value);

        // Verifica sem existe o campo no array de dados
        if (isset($this->data[$fieldNameReturn])) {

            // Adicionando o campo para verifica se o valor do campo checado esta em um item diferente do atual
            // Campo de comparação extra geralmente será o ID
            $query .= " AND $fieldNameReturn != %s";
            $arrayValues[] = $this->data[$fieldNameReturn];
        }

        $result = $this->model->db->get_col($this->model->db->prepare($query, $arrayValues));

        if ($result[0]) {
            $this->prepareMessage($this->prepareFieldName($fieldName));
        }

    }

    /**
     * @see https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40
     */
    protected function cpf($fieldName, $args = '') {
        $result = true;

        // Extrair somente os números
        $cpf = preg_replace('/[^0-9]/is', '', $this->data[$fieldName]);

        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            $result = false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $result = false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $result = false;
            }
        }

        if (!$result) {
            $this->prepareMessage($this->prepareFieldName($fieldName));
        }
    }

    /**
     * @return void
     */
    private function prepareMessage($replace_texts = [], $symbols = ['%s']) {

        if(is_null($symbols)) {
            $symbols = ['%s'];
        }

        // Check if exists custom message for current field and method
        $errorMessage = 
            isset($this->errorMessages[$this->currentFieldName][$this->currentMethod]) ?
            $this->errorMessages[$this->currentFieldName][$this->currentMethod] :
            $this->errorMessages[$this->currentMethod];

        $this->validationsMessages[$this->currentFieldName][] = str_replace($symbols, $replace_texts, $errorMessage);
    }

    private function prepareFieldName($fieldName) {
        return ucfirst(str_replace('_',' ', $fieldName));
    }

    protected function length($fieldName, $length)
    {
        $value = trim($this->data[$fieldName]);
        if($length && strlen($value) != $length)  {
            $this->prepareMessage([$this->prepareFieldName($fieldName), $length], ['%s', '%l']);
        }
    }
}