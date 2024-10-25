<?php

namespace MyApp;

class Database {
    private $conn;
    private $username;
    private $password;
    private $database;

    public function __construct($username, $password, $database) {
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->connect();
    }

    private function connect() {
        $this->conn = mysqli_connect("localhost", $this->username, $this->password, $this->database);

        if (mysqli_connect_error()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

$database = new Database("root", "", "bibliotheek");
$conn = $database->getConnection();

?>
