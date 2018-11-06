<?php
/**
 * Created by PhpStorm.
 * User: majdbassoumi
 * Date: 30/10/2018
 * Time: 16:29
 */

class DBClass
{

    private $servername = "localhost";
    private $username = "root";
    private $password = '';
    private $db_name = 'printful';

    protected $db_connection;

    public function __construct()
    {
        $this->db_connection = new mysqli($this->servername, $this->username, $this->password, $this->db_name);

        if ($this->db_connection->connect_error) {
            die("Connection failed: " . $this->db_connection->connect_error);
        }
        return $this->db_connection;
    }

}
