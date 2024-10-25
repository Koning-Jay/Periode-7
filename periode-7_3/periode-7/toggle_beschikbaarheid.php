<?php
require_once 'conn.php';

class BookAvailabilityManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function toggleAvailability($boekId) {
        // Retrieve the current beschikbaarheid from the database
        $selectQuery = "SELECT beschikbaarheid FROM boek WHERE id = ?";
        $selectStmt = $this->conn->prepare($selectQuery);
        $selectStmt->bind_param('i', $boekId);
        $selectStmt->execute();
        $result = $selectStmt->get_result();
        $row = $result->fetch_assoc();

        // Toggle the beschikbaarheid
        $newBeschikbaarheid = ($row['beschikbaarheid'] == 1) ? 0 : 1;

        // Update the beschikbaarheid in the database for the specific book
        $updateQuery = "UPDATE boek SET beschikbaarheid = ? WHERE id = ?";
        $updateStmt = $this->conn->prepare($updateQuery);
        $updateStmt->bind_param('ii', $newBeschikbaarheid, $boekId);
        $updateResult = $updateStmt->execute();

        if (!$updateResult) {
            // Handle update failure
            echo "Error updating beschikbaarheid: " . $this->conn->error;
        }
    }
}

// Check if boek_id is provided in the request
if (isset($_GET['boek_id'])) {
    $boekId = $_GET['boek_id'];

    // Instantiate BookAvailabilityManager with the database connection
    $bookManager = new BookAvailabilityManager($conn);

    // Toggle the availability
    $bookManager->toggleAvailability($boekId);
}
?>
