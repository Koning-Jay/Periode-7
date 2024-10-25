<?php

require_once 'conn.php';

class Database {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }

    public function escapeString($string) {
        return $this->conn->real_escape_string($string);
    }

    public function affectedRows() {
        return $this->conn->affected_rows;
    }
}

class Book {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function deleteBook($naam_boek) {
        $naam_boek = $this->db->escapeString($naam_boek);
        $sql = "DELETE FROM boek WHERE naam_boek = '$naam_boek'";
        $result = $this->db->query($sql);
        if (!$result) {
            echo "Error: " . $this->db->conn->error;
        }  
    }

    public function toggleAvailability($naam_boek) {
        $naam_boek = $this->db->escapeString($naam_boek);
        $sql = "UPDATE boek SET beschikbaarheid = NOT beschikbaarheid WHERE naam_boek = '$naam_boek'";
        $result = $this->db->query($sql);
        if (!$result) {
            echo "Error: " . $this->db->conn->error;
        }
    }

    public function getAllBooks() {
        $sql = "SELECT *, CASE WHEN beschikbaarheid = 1 THEN 'Beschikbaar' ELSE 'Niet beschikbaar' END AS beschikbaarheid_text FROM boek";
        $result = $this->db->query($sql);

        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }

        return $books;
    }
}

$database = new Database($conn);
$book = new Book($database);

if (isset($_GET['action']) && isset($_GET['naam_boek'])) {
    $action = $_GET['action'];
    $naam_boek = $_GET['naam_boek'];

    if ($action === 'delete') {
        $book->deleteBook($naam_boek);
    } elseif ($action === 'toggle') {
        $book->toggleAvailability($naam_boek);
    }
}

$boeken = $book->getAllBooks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rowdies:wght@300;400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.scss">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <div>
                <a class="navbar-brand" href="dashbord.php"><i class="ph ph-house"></i></a>
                <a class="navbar-brand" href="login.php"><i class="ph ph-user-switch"></i></a>
                <a class="navbar-brand" href="book_add_form.php"><i class="ph ph-stack-plus"></i></a>
                <a class="navbar-brand" href="books.php"><i class="ph ph-books"></i></a>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            </div>
        </div>
    </nav>
</header>
<div id="contentSection">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <table class="table bookList">
                    <thead>
                    <tr>
                        <th><h4>Naam</h4></th>
                        <th><h4>Auteur</h4></th>
                        <th><h4>Uitgever</h4></th>
                        <th><h4>Boekjaar</h4></th>
                        <th><h4>Beschrijving</h4></th>
                        <th><h4>Voorraad</h4></th>
                        <th><h4>Beschikbaarheid</h4></th>
                        <th><h4>Actie</h4></th> <!-- New column for actions -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($boeken as $boek): ?>
                        <tr>
                            <td><h6><?php echo $boek['naam_boek']; ?></h6></td>
                            <td><h6><?php echo $boek['auteur']; ?></h6></td>
                            <td><h6><?php echo $boek['uitgever']; ?></h6></td>
                            <td><h6><?php echo $boek['boekjaar']; ?></h6></td>
                            <td><h6><?php echo $boek['beschrijving']; ?></h6></td>
                            <td><h6><?php echo $boek['vooraad']; ?></h6></td>
                            <td><h6><?php echo $boek['beschikbaarheid_text']; ?></h6></td>
                            <td>
                                <a href='books.php?action=toggle&naam_boek=<?php echo urlencode($boek['naam_boek']); ?>'>Switch</a>
                                <a class="ps-3" href='books.php?action=delete&naam_boek=<?php echo urlencode($boek['naam_boek']); ?>'>Verwijder</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <p>Deze website is mede mogelijk gemaakt door <span class="fw-bold fst-italic">koning Jay</span> en <span class="fst-italic fw-bold">keizer Finn</span>.</p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
