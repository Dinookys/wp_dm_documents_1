<?php

class DM_Category_Model extends DM_Base_Model
{

    protected $delimiter = " \ ";

    protected $tableName = 'dm_documents_categories';
    protected $fields = [
        'ID',
        'ID_parent',
        'titulo',
        'descricao',
        'status',
    ];

    protected $scaffold = [
        'ID_parent' => 0,
        'titulo' => '',
        'descricao' => '',
        'status' => 'draft',
    ];

    public function createTable()
    {

        $this->db->query(
            "CREATE TABLE IF NOT EXISTS `$this->tableName` (
      `ID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      `ID_parent` INT(11) NULL DEFAULT 0,
      `titulo` VARCHAR(255) NOT NULL,
      `descricao` TEXT NULL,
      `status` ENUM('publish', 'draft') NULL DEFAULT 'draft',
      PRIMARY KEY (`ID`));"
        );

        return parent::createTable();
    }

    public function getCategoriesOrder()
    {
        $lista = $this->setItemsPerPage(-1)->listItems([
            'cols' => ['titulo', 'ID', 'ID_parent'],
            'order' => "ID_parent DESC",
        ]);

        foreach ($lista as $key => $cat) {
            if ($cat->ID_parent) {
                $lista[$key]->titulo = $this->getNameFromList($cat->titulo, $cat->ID_parent, $lista);                
            }
            
            // $exp = explode($this->delimiter, $cat->titulo);
            // $titulo = array_pop($exp);
            // $size = count($exp) ?: 1;
            // $lista[$key]->option_titulo = str_repeat('&nbsp;&nbsp;', $size) . '|' . str_repeat('_', $size) . $titulo;
        }

        usort($lista, function ($a, $b) {
            return $a > $b ? 1 : 0;
        });

        return $lista;
    }

    private function getNameFromList($titulo, $id_parent = 0, $lista)
    {
        foreach ($lista as $cat) {
            if ($cat->ID == $id_parent) {
                $titulo = $cat->titulo . $this->delimiter . $titulo;

                if ($cat->ID_parent) {
                    $titulo = $this->getNameFromList($titulo, $cat->ID_parent, $lista);
                }
            }
        }

        return $titulo;
    }

}
