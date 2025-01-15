<?php
function fetchLeaveForms($conn, $tableName, $lecturerId) {
    $sql = "SELECT * FROM $tableName WHERE lecturer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lecturerId);
    $stmt->execute();
    return $stmt->get_result();
}
?>
