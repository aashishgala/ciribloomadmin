<?php

class mysql_function{

    public $conn;
    private $host = '';
    private $user = '';
    private $pass = '';
    private $database = '';

    // private $host = 'localhost';
    // private $user = 'root';
    // private $pass = '';
    // private $database = 'makaan';

    // private $host = "localhost";
    // private $user = "quizz";
    // private $pass  = "1@Quizz#";
    // private $database   = "pgpl_quizz";


    function __construct()
    {
        // private property can only be accessible with in class and can only use/access using object created i.e $this if we access only $host inside any function it will throw undefined variable error
        
        if ($_SERVER['REMOTE_ADDR'] == "::1" OR $_SERVER['SERVER_ADDR'] == "::1" OR $_SERVER['SERVER_ADDR'] == "127.0.0.1") {
            $this->host = "localhost";
            $this->user = "root";
            $this->pass = "";
            $this->database = "dbforum";
        }
        else{
            $this->host = "localhost";
            $this->user = "aditee_quizz";
            $this->pass = "quizz@123";
            $this->database = "aditee_quizz";
        }

        $this->conn = $this->dbconn();
    }

    function dbconn()
    {
        $dbconn = new mysqli($this->host, $this->user, $this->pass, $this->database);
        // echo $this->host.' | '.$this->user.' | '.$this->pass.' | '.$this->database;
        // Check connection
        if ($dbconn->connect_error) {
            die("Connection failed: " . $dbconn->connect_error);
        }

        return $dbconn;
        
    }

    function dbclose()
    {
        $this->conn->close();
    }

    function insert_data($sql)
    {
        // echo $sql;
        $conn = $this->conn;

        if($conn->query($sql) === TRUE){

            return true;

        }else{

            return "Error: " . $sql . "<br>" . $conn->error;
        }

    }

    function execute_query($query)
    {
        $conn = $this->conn;
        $result = $conn->query($query);

        if($conn->query($query)){

            return $result;

        }
        else{

            return "Error: " . $query . "<br>" . $conn->error;
        }

    }

    function mysql_num_rows($result){

        return $num_row = mysqli_num_rows($result);

    }

    function fetch_data($result){

        $data = array();
        
        // return $result;
        $data = $result->fetch_assoc();

        // while($row = $result->fetch_assoc())
        // {
        //     $data[] = $row;
        // }
        
        // $result -> free_result();

        return $data;

    }

    function delete_data($query)
    {
        $conn = $this->conn;

        if($conn->query($query) === TRUE){

            return true;

        }else{

            return "Error: " . $query . "<br>" . $conn->error;
        }
    }

    function get_val($query){

        $conn = $this->conn;

        $sql = $this->execute_query($query);

        return $this->fetch_data($sql);

    }
}
?>