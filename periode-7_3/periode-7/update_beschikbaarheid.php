<?php
require_once 'conn.php';

class Boek {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function toggleBeschikbaarheid($naamBoek) {
        // Retrieve the current beschikbaarheid from the database for the specific book
        $selectQuery = "SELECT beschikbaarheid FROM boek WHERE naam_boek = ?";
        $selectStmt = $this->conn->prepare($selectQuery);
        $selectStmt->bind_param('s', $naamBoek);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            // Toggle the beschikbaarheid
            $newBeschikbaarheid = ($row['beschikbaarheid'] == 1) ? 0 : 1;

            // Update the beschikbaarheid in the database for the specific book
            $updateQuery = "UPDATE boek SET beschikbaarheid = ? WHERE naam_boek = ?";
            $updateStmt = $this->conn->prepare($updateQuery);
            $updateStmt->bind_param('is', $newBeschikbaarheid, $naamBoek);
            $updateResult = $updateStmt->execute();

            if (!$updateResult) {
                // Handle update failure
                echo "Error updating beschikbaarheid: " . $this->conn->error;
            }
        } else {
            // Handle book not found
            echo "Book not found.";
        }
    }
}

if (isset($_GET['naam_boek'])) {
    $naamBoek = $_GET['naam_boek'];

    // Instantiate Boek class
    $boek = new Boek($conn);
    
    // Toggle beschikbaarheid
    $boek->toggleBeschikbaarheid($naamBoek);
}
?>
