<?php
function fGetBaseObject($tableName, $key, $value, $addon = "") {
    $conn = makeConnection();

    try {
        $conn = makeConnection();

        $sql = "SELECT * FROM $tableName";
        $sql .= " WHERE $key = '".$value."' ".$addon."";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function fGetCount($tableName, $key, $value, $object, $addon = "") {
    $conn = makeConnection();
    
    try {
        $conn = makeConnection();
        
        $sql = "SELECT COUNT(".$object.") AS count FROM $tableName";
        $sql .= " WHERE $key = '".$value."' ".$addon."";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
        
    } catch (PDOException $e) {
        return false;
    }
}

function fInsertObject($table, $data, $idColumn = null, $idValue = null) {
    if ($idColumn && $idValue) {
        // Update operation
        $setParts = [];
        foreach ($data as $column => $value) {
            $setParts[] = "$column = :$column";
        }
        $setString = implode(", ", $setParts);
        $sql = "UPDATE $table SET $setString WHERE $idColumn = :id";
        $data['id'] = $idValue;  // Add ID to parameters
    } else {
        // Insert operation
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    }
    
    try {
        $conn = makeConnection();
        
        $stmt = $conn->prepare($sql);
        foreach ($data as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }
        return $stmt->execute();
    } catch (PDOException $e) {
        echo "hier";
        // Handle error
        return 0;
    }
}
?>