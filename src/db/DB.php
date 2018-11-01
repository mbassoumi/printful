<?php
/**
 * Created by PhpStorm.
 * User: majdbassoumi
 * Date: 31/10/2018
 * Time: 15:24
 */

include_once 'DBClass.php';

class DB extends DBClass
{
	public function __construct()
	{
		parent::__construct();
	}


    /**
     * select query
     *
     * @param $query
     * @return array|bool
     */
	public function getData($query)
	{
		$result = $this->db_connection->query($query);

		if ($result == false) {
			return false;
		}

		$rows = [];

		while ($row = $result->fetch_assoc()) {
			$rows[] = $row;
		}

		return $rows;
	}

    /**
     * (insert, update) query
     *
     * @param $query
     * @return bool
     */
	public function execute($query)
	{
		$result = $this->db_connection->query($query);

		if ($result == false) {
			echo "Error: cannot execute the query ($query)";
			return false;
		} else {
			return true;
		}
	}


    /**
     * insert query and get the inserted id
     *
     * @param $query
     * @return int|null|string
     */
    public function insertAndGetInsertedId($query)
    {
        if (mysqli_query($this->db_connection, $query)) {
            $last_id = mysqli_insert_id($this->db_connection);
            return $last_id;
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($this->db_connection);
            return null;
        }
	}



    /**
     * delete query
     *
     * @param $id
     * @param $table
     * @return bool
     */
	public function delete($id, $table)
	{
		$query = "DELETE FROM $table WHERE id = $id";

		$result = $this->db_connection->query($query);

		if ($result == false) {
			echo 'Error: cannot delete id ' . $id . ' from table ' . $table;
			return false;
		} else {
			return true;
		}
	}


    /**
     * delete special characters from the value.
     *
     * @param $value
     * @return string
     */
	public function escape_string($value)
	{
		return $this->db_connection->real_escape_string($value);
	}
}
