<?php
function fGetBaseObject($tableName, $key, $value) {
    $conn = makeConnection();

    try {
        $conn = makeConnection();

        $sql = "SELECT * FROM $tableName";
        $sql .= " WHERE $key = '".$value."'";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

?>