<?php

require_once 'conn.php';

class Database {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getConnection() {
        return $this->conn;
    }

    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        $values = array_values($data);

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($values);
    }
}

class Book {
    private $db;

    private $naam_boek;
    private $auteur;
    private $uitgever;
    private $boekjaar;
    private $beschrijving;
    private $vooraad;

    public function __construct($db, $naam_boek, $auteur, $uitgever, $boekjaar, $beschrijving, $vooraad) {
        $this->db = $db;
        $this->naam_boek = $naam_boek;
        $this->auteur = $auteur;
        $this->uitgever = $uitgever;
        $this->boekjaar = $boekjaar;
        $this->beschrijving = $beschrijving;
        $this->vooraad = $vooraad;
    }

    public function insertBook() {
        $data = [
            'naam_boek' => $this->naam_boek,
            'auteur' => $this->auteur,
            'uitgever' => $this->uitgever,
            'boekjaar' => $this->boekjaar,
            'beschrijving' => $this->beschrijving,
            'vooraad' => $this->vooraad
        ];

        $this->db->insert('boek', $data);
    }
}

$db = new Database();

if(isset($_POST['submit'])){
    $naam_boek = strip_tags($_POST['naam_boek']);
    $auteur = strip_tags($_POST['auteur']);
    $uitgever = strip_tags($_POST['uitgever']);
    $boekjaar = strip_tags($_POST['boekjaar']);
    $beschrijving = strip_tags($_POST['beschrijving']);
    $vooraad = strip_tags($_POST['vooraad']);

    $book = new Book($db, $naam_boek, $auteur, $uitgever, $boekjaar, $beschrijving, $vooraad);
    $book->insertBook();
    
    header("Location: dashbord.php");
}
?>
