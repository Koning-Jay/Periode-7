<?php

include("conn.php");

class Database {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function query($sql) {
        return mysqli_query($this->conn, $sql);
    }

    public function escapeString($string) {
        return mysqli_real_escape_string($this->conn, $string);
    }

    public function fetchAssoc($result) {
        return mysqli_fetch_assoc($result);
    }
}

class BookSearch {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function searchBooks($input) {
        $input = $this->db->escapeString($input);
        $query = "SELECT * FROM boek WHERE naam_boek LIKE '%$input%' OR auteur LIKE '%$input%'";
        $result = $this->db->query($query);

        $books = [];
        if ($result) {
            while ($row = $this->db->fetchAssoc($result)) {
                $books[] = $row;
            }
        }

        return $books;
    }
}

$db = new Database($conn);
$search = new BookSearch($db);

if(isset($_POST['input'])) {
    $input = $_POST['input'];
    $books = $search->searchBooks($input);

    if(count($books) > 0) { ?>
        <table class="table table-borderd table-striped mt-4">
            <thead>
                <tr>
                    <th><h4>Naam</h4></th>
                    <th><h4>Auteur</h4></th>
                    <th><h4>Uitgever</h4></th>
                    <th><h4>Boekjaar</h4></th>
                    <th><h4>Beschrijving</h4></th>
                    <th><h4>vooraad</h4></th>
                    <th><h4>beschikbaarheid</h4></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $book): ?>
                    <tr>
                        <td><h6><?php echo $book['naam_boek'];?></h6></td>
                        <td><h6><?php echo $book['auteur'];?></h6></td>
                        <td><h6><?php echo $book['uitgever'];?></h6></td>
                        <td><h6><?php echo $book['boekjaar'];?></h6></td>
                        <td><h6><?php echo $book['beschrijving'];?></h6></td>
                        <td><h6><?php echo $book['vooraad'];?></h6></td>
                        <td><h6><?php echo $book['beschikbaarheid'] == 1 ? "beschikbaar" : "onbeschikbaar";?></h6></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php } else {
        echo "<h6 class='text-danger text-center mt-3'>Geen boeken gevonden</h6>";
    }
}

?>
