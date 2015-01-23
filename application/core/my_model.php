<?php

class MY_Model extends CI_Model {
    const DB_TABLE = 'abstract';
    const DB_TABLE_PK = 'abstract';
    
    /**
     * Create record.
     */
    private function insert() {
        $this->db->insert($this::DB_TABLE, $this);
        $this->{$this::DB_TABLE_PK} = $this->db->insert_id();
    }
    
//     /**
//      * Update record.
//      */
//     private function update() {
//         $this->db->update($this::DB_TABLE, $this, $this::DB_TABLE_PK);
//     }
    
    /**
     * Update record.
     */
    private function update() {
    	$this->db->where($this::DB_TABLE_PK , $this->{$this::DB_TABLE_PK});
    	$this->db->update($this::DB_TABLE, $this);
    }
    
    /**
     * Populate from an array or standard class.
     * @param mixed $row
     */
    public function populate($row) {
        foreach ($row as $key => $value) {
            $this->$key = $value;
        }
    }
    
    /**
     * Load from the database.
     * @param int $id
     */
    public function load($id) {
        $query = $this->db->get_where($this::DB_TABLE, array(
            $this::DB_TABLE_PK => $id,
        ));
        $this->populate($query->row());
//         if ($query->num_rows() > 0)
//         {
//          $this->populate($query->row());
//         }
        
    }
    
    /**
     * Load from the database by fileds.
     * @param int $id
     */
    public function load_by_field($array) {
    	$query = $this->db->get_where($this::DB_TABLE, $array
    	);
    	$ret_val = array();
    	$class = get_class($this);
    	foreach ($query->result() as $row) {
    		$model = new $class;
    		$model->populate($row);
    		$ret_val[$row->{$this::DB_TABLE_PK}] = $model;
    	}
    	return $ret_val;
    }
    
    /**
     * Load from the database by fileds.
     * @param int $id
     */
    public function load_by_field_as_array($array) {
    	$query = $this->db->get_where($this::DB_TABLE, $array
    	);
    	$ret_val = array();
    	$class = get_class($this);
    	foreach ($query->result() as $row) {
    		$model = new $class;
    		$model->populate($row);
    		$ret_val[] = $model;
    	}
    	return $ret_val;
    }
    /**
     * Delete the current record.
     */
    public function delete() {
        $this->db->delete($this::DB_TABLE, array(
           $this::DB_TABLE_PK => $this->{$this::DB_TABLE_PK}, 
        ));
        //unset($this->{$this::DB_TABLE_PK});
    }
    
    /**
     * Save the record.
     */
    public function save() {
        if (isset($this->{$this::DB_TABLE_PK})) {
            $this->update();
        }
        else {
            $this->insert();
        }
    }
    
    /**
     * Get an array of Models with an optional limit, offset.
     * 
     * @param int $limit Optional.
     * @param int $offset Optional; if set, requires $limit.
     * @return array Models populated by database, keyed by PK.
     */
    public function get($limit = 0, $offset = 0) {
        if ($limit) {
            $query = $this->db->get($this::DB_TABLE, $limit, $offset);
        }
        else {
            $query = $this->db->get($this::DB_TABLE);
        }
        $ret_val = array();
        $class = get_class($this);
        foreach ($query->result() as $row) {
            $model = new $class;
            $model->populate($row);
            $ret_val[$row->{$this::DB_TABLE_PK}] = $model;
        }
        return $ret_val;
    }
    
    public function get_where($fields , $array , $sql = FALSE){
       	 $this->db->select($fields);
       	 $query;
       	 if(!$sql)
    	 $query = $this->db->get_where($this::DB_TABLE , $array);
       	 else {
       	 	$this->db->where($sql, NULL, FALSE);
       	 	$query = $this->db->get($this::DB_TABLE);
       	 }
 
//        	 '`order_id` NOT IN (SELECT `order_id` FROM `shipment`)'
    	 return $query->result();
    }
    
    
    
    
    
    public function get_by_properties($search_string=null, $order_by=null, $order_type='Asc', $limit_start=null, $limit_end=null)
    {
    	 
    	$this->db->select('*');
    	$this->db->from($this::DB_TABLE);
    
    	if($search_string){
    		$array = array();
    		$fields = $this->db->list_fields($this::DB_TABLE);
    		foreach ($fields as $field)
    		{
    			$array[$field]=$search_string;
    		}
    		$this->db->or_like($array, $search_string);
    	}
    	$this->db->group_by($this::DB_TABLE_PK);
    
    	if($order_by){
    		$this->db->order_by($order_by, $order_type);
    	}else{
    		$this->db->order_by($this::DB_TABLE_PK, $order_type);
    	}
    
    	if($limit_start && $limit_end){
    		$this->db->limit($limit_start, $limit_end);
    	}
    
    	if($limit_start != null){
    		$this->db->limit($limit_start, $limit_end);
    	}
    
    	$query = $this->db->get();
    	return $query->result_array();
    }
    
    function count_rows($array=null, $search_string=null, $order_by=null)
    {
    	$this->db->select('*');
    	$this->db->from($this::DB_TABLE);
    	if(isset($array)){
    		$this->db->where($array);
    	}
    	if($search_string){
    		$array = array();
    		$fields = $this->db->list_fields($this::DB_TABLE);
    		foreach ($fields as $field)
    		{
    			$array[$field]=$search_string;
    		}
    		$this->db->or_like($array, $search_string);
    	}
    	if($order_by){
    		$this->db->order_by($order_by, 'Asc');
    	}else{
    		$this->db->order_by($this::DB_TABLE_PK, 'Asc');
    	}
    	$query = $this->db->get();
    	return $query->num_rows();
    }
    
    
}