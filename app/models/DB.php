<?php

class DB
{
    private $conn;

    /**
     * @param $host
     * @param $user
     * @param $pass
     * @param $dbname
     */
    public function __construct($host, $user, $pass, $dbname)
    {
        $this->conn = mysqli_connect($host, $user, $pass, $dbname);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
    }

    function insert($sql)
    {
        if ( mysqli_query($this->conn, $sql) ) { // check success of server 1
            $insert_id = mysqli_insert_id($this->conn);
            if (isset($insert_id)) {
                return $insert_id;
            } else {
                // id not found
                return false;
            }
        } else {
            // query failure
            return false;
        }
    }

    function select_single($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        $rows = []; // initialize
        if ( $result ) {
            while ($r = mysqli_fetch_array($result)) {
                $rows[] = $r[0];
            }
            return $rows;
        } else {
            return false;
        }
    }

    function select($sql)
    {
        $result = mysqli_query($this->conn, $sql);
        $rows = []; // initialize
        if ( $result ) {
            while ($r = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $rows[] = $r;
            }
            return $rows;
        } else {
            return false;
        }
    }
}