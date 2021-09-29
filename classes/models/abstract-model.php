<?php

abstract class DM_Abstract_Model
{
    protected $tableName;
    protected $itemsPerPage = 20;
    public $pages = 0;
    public $db;

    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
        $this->tableName = $this->db->prefix . $this->tableName;
        $this->itemsPerPage = get_option('posts_per_page', 20);
    }

    public function __get ($name)
    {
        if(!isset($this->$name)) {
            throw new InvalidArgumentException("Atributo " . $name . " não existe.");
        }

        return $this->$name;
    }

    /**
     * @param array $conf
     * $conf['filter'] = array() | 
     * Use ['AND' => [FILTERS], 'OR'  => [FILTERS]] OR [filters] | 
     * $conf['order'] = 'ID DESC' | 
     * $conf['page'] = 1 | 
     * $conf['cols'] = ['*'] |
     * @see Method this->makeFilter
     * @see ESC_LIKE https://developer.wordpress.org/reference/classes/wpdb/esc_like/
     * @see https://developer.wordpress.org/reference/classes/wpdb/
     */
    public function listItems($conf = array())
    {
        $filter = isset($conf['filter']) ? $conf['filter'] : array(); 
        $current_page = isset($conf['page']) && $conf['page'] ? $conf['page'] : 1; 
        $order = isset($conf['order']) ? $conf['order'] : 'ID DESC'; 
        $cols = isset($conf['cols']) ? $conf['cols'] : array('*');

        $offset = '';
        $limit = '';
        $order = " ORDER BY $order";
        
        if($this->itemsPerPage > 0 && $current_page) {
            $offset = ($current_page * $this->itemsPerPage) - $this->itemsPerPage;
            $limit = " LIMIT $this->itemsPerPage OFFSET $offset";
        }

        $cols = implode(',', $cols);

        $query = "SELECT $cols FROM $this->tableName WHERE 1 $order $limit";
        if (!empty($filter)) {
            $queryFilter = $this->makeFilter($filter);
            $query = "SELECT $cols FROM $this->tableName WHERE $queryFilter $order $limit";
        }
        return $this->db->get_results($query);
    }

    public function totalPages($filter = array())
    {
        $query = "SELECT COUNT(1) FROM $this->tableName WHERE 1";
        if (!empty($filter)) {
            $queryFilter = $this->makeFilter($filter);
            $query = "SELECT COUNT(1) FROM $this->tableName WHERE $queryFilter";
        }

        $found = $this->db->get_var($query);

        $this->pages = ceil($found / $this->itemsPerPage);

        return $this;
    }

    /**
     * @see https://developer.wordpress.org/reference/classes/wpdb/delete/
     */
    public function delete($id = null)
    {
        if (is_null($id)) return false;
        return $this->db->delete($this->tableName, array('ID' => $id));
    }

    /**
     *
     * @see https://developer.wordpress.org/reference/classes/wpdb/insert/   *
     */
    public function insert($data = array(), $format = array())
    {
        if (empty($data)) return false;
        if ($this->db->insert($this->tableName, $data, $format)) {
            $last_insert = $this->db->insert_id;
            return $this->db->get_row("SELECT * FROM $this->tableName WHERE ID='$last_insert'", ARRAY_A);
        }
        return false;
    }

    /**
     * @param String $value
     * @param String $collumn
     */
    public function getBy ($value = null, $collumn = 'ID', $symbol = '=')
    {
        if(is_null($value) || is_null($collumn) ) {
            throw new InvalidArgumentException("Nenhum Valor/Coluna informado");
        }

        $filter = $collumn.$symbol.'"'.$value.'"';
        return $this->db->get_row("SELECT * FROM $this->tableName WHERE $filter", ARRAY_A);
        
    }

    public function getByQuery ($sql_arguments = '', $return_type = ARRAY_A)
    {
        if(empty($sql_arguments)) {
            throw new InvalidArgumentException("Informe uma string de argumentos SQL");
        }
        return $this->db->get_row("SELECT * FROM $this->tableName WHERE $sql_arguments", $return_type);
    }

    public function getAllByQuery ($sql_arguments = '', $return_type = OBJECT)
    {
        if(empty($sql_arguments)) {
            throw new InvalidArgumentException("Informe uma string de argumentos SQL");
        }
        return $this->db->get_results("SELECT * FROM $this->tableName WHERE $sql_arguments", $return_type);
    }

    public function update($id = null, $data = array())
    {
        if (is_null($id) || empty($data)) return false;

        if (isset($data['ID'])) unset($data['ID']);

        $bindData = implode(', ', array_map(function ($col) {
            return $col . '=%s';
        }, array_keys($data)));

        $data[] = $id;

        $query = $this->db->prepare("UPDATE $this->tableName SET $bindData WHERE ID=%s", $data);

        return $this->db->query($query);
    }

    public function setItemsPerPage($per_page = 20)
    {
        $this->itemsPerPage = $per_page;
        return $this;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function getDB()
    {
        return $this->db;
    }

    public function createTable()
    { 
        return $this;
    }

    public function updateTable ()
    {
        return $this;
    }

    /**          
     * EX 1: ADD mixin filters AND and OR
     * Filter use array key (for column and operator) and value
     * "column =" => 'value'
     * 
     * "column >= " => 'value'
     * 
     * "column LIKE " => "'%value'"
     *
     * "column LIKE " => "'%value%'"
     *
     * Example 1:
     * 
     * array(
     * 'AND' => array(Filters), 
     * 'OR' => array(Filters)
     * )
     * 
     * Example 2:
     * 
     * array("column >= " => 'value')     
     */
    protected function makeFilter($filter = array(), $or = false) {
        $queryFilter = '';

        if(isset($filter['AND']) && !empty($filter['AND'])) {
            $this->loopFilter($filter['AND'], false, $queryFilter);
        }

        if(isset($filter['OR']) && !empty($filter['OR'])) {
            $this->loopFilter($filter['OR'], true, $queryFilter);
        }

        if(!isset($filter['AND']) && !isset($filter['OR'])) {
            $this->loopFilter($filter, $or, $queryFilter);
        }

        return $queryFilter;
    }

    protected function loopFilter($filter = array(), $or = false, &$queryFilter = '')
    {

        $union = ' AND ';
        if($or) {
            $union = ' OR ';
        }

        if (!empty($filter)) {

            $currentFilter = 0;

            foreach ($filter as $col => $value) {                
                $value = trim($value);                
                $queryFilter .= !empty($queryFilter) ? $union : '';
                $queryFilter .= "$col '{$value}'";
                $currentFilter++;
            }
        }

        return $queryFilter;
    }
}