<?php

class DM_Document_Model extends DM_Base_Model
{
    protected $tableName = 'dm_documents_documents';
    protected $fields = [
        'ID',
        'ID_category',
        'titulo',
        'data',
        'descricao',
        'documentos',
        'status'
    ];

    protected $scaffold = [
        'ID_category' => '',
        'titulo' => '',
        'descricao' => '',
        'data' => '',
        'documentos' => array(
            'interno' => [],
            'externo' => []
        ),
        'status' => 'draft',
    ];

    public function createTable()
    {        
        $this->db->query(
            "CREATE TABLE IF NOT EXISTS `$this->tableName` (
      `ID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `ID_category` INT(11) NOT NULL DEFAULT 0,
      `titulo` VARCHAR(255) NOT NULL DEFAULT '',
      `descricao` TEXT NULL,
      `data` VARCHAR(255),
      `documentos` TEXT NULL,
      `status` ENUM('publish', 'draft') NULL DEFAULT 'draft',
      PRIMARY KEY (`ID`));"
        );

        return parent::createTable();
    }
}
