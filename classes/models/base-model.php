<?php

class DM_Base_Model extends DM_Abstract_Model
{
    protected $tableName = '';
    protected $status = ['publish', 'draft'];
    protected $fields = [];
    protected $scaffold = [];

    public function getStatus(): array
    {
        return array_combine(
            $this->status,
            [
                __('Yes'),
                __('No'),
            ]
        );
    }

    /**
     * Retorna um array de colunas que pode ser preechidos 
     * já com um valor prédefinido
     */
    public function getScaffold()
    {
        return $this->scaffold;
    }
}
