<?php
class Model
{
    protected $_db;
	protected $_db_host = 'localhost';
	protected $_db_user	= 'root';
	protected $_db_pass = '';
	protected $_db_name = 'sarmiento';
	protected $_db_char = 'utf8mb4';
	

    public function __construct()
    {
    	$this->_db = new mysqli($this->_db_host, $this->_db_user, $this->_db_pass, $this->_db_name);
		if ( $this->_db->connect_errno )
        {
            echo "Fallo al conectar a MySQL: ". $this->_db->connect_error;
            return;    
        }
		
		$this->_db->set_charset($this->_db_char);
    }
}


