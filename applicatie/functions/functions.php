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

function fGetAllObjects($tableName, $key, $value, $addon = "") {
    $conn = makeConnection();
    try {
        $conn = makeConnection();

        $sql = "SELECT * FROM $tableName";
        $sql .= " WHERE $key = '".$value."' ".$addon."";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

function fGetMax($tableName, $key, $value, $object, $addon = "") {
    $conn = makeConnection();
    try {
        $conn = makeConnection();
        
        $sql = "SELECT MAX(".$object.") AS max FROM $tableName";
        $sql .= " WHERE $key = '".$value."' ".$addon."";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['max'];
        
    } catch (PDOException $e) {
        return false;
    }
}

function fGetSum($tableName, $key, $value, $object, $addon = "") {
    $conn = makeConnection();
    try {
        $conn = makeConnection();
        
        $sql = "SELECT SUM(".$object.") AS sum FROM $tableName";
        $sql .= " WHERE $key = '".$value."' ".$addon."";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['sum'];
        
    } catch (PDOException $e) {
        return false;
    }
}

function fGetName($tableName, $key, $value, $object, $addon = "") {
    $conn = makeConnection();
    try {
        $conn = makeConnection();
        
        $sql = "SELECT ".$object." AS name FROM $tableName";
        $sql .= " WHERE $key = '".$value."' ".$addon."";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['name'];
        
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
        // Handle error
        return 0;
    }
}

function fShowFlightInfo($id) {    
    $flight = fGetBaseObject('Vlucht', 'vluchtnummer', $id);
    $luchthaven = fGetBaseObject('Luchthaven', 'luchthavencode', $flight["bestemming"]);
    $info = "";
    if ($flight) {
        $info .= "<div class='form-container'>";
        $info .= "<h2>Flight Details</h2>";
        $info .= "<p><strong>Flight Number: </strong>".$flight['vluchtnummer']."</p>";
        $info .= "<p><strong>Destination: </strong>".$flight['bestemming']." - ".$luchthaven['naam']."</p>";
        $info .= "<p><strong>Gatecode: </strong>".$flight['gatecode']."</p>";
        $info .= "<p><strong>Departure Time: </strong>".$flight['vertrektijd']."</p>";
        $info .= "</div>";
    }

    return $info;
}

function fShowPassengerInfo($id) {
    $passenger = fGetBaseObject('Passagier', 'passagiernummer', $id);
    $info = "";
    if ($passenger) {
        $info .= "<div class='form-container'>";
        $info .= "<h2>Passenger Details</h2>";
        $info .= "<p><strong>Passenger Number: </strong>".$passenger['passagiernummer']."</p>";
        $info .= "<p><strong>Name: </strong>".$passenger['naam']."</p>";
        $info .= "<p><strong>Sex: </strong>".fGetSex($passenger['geslacht'])."</p>";
        $info .= "<p><strong>Seat: </strong>".$passenger['stoel']."</p>";
        $info .= "</div>";
    }

    return $info;
}

function fGetSex($sex) {
    $sexName = "";
    if ($sex == 'M') {
        $sexName = "Male";
    } elseif ($sex == 'V') {
        $sexName = "Female";
    } elseif ($sex == 'x') {
        $sexName = "Other";
    }

    return $sexName;
}

function fShowBaggageOverview($passenger) {
    $baggageInfo = fGetAllObjects('BagageObject', 'passagiernummer', $passenger);
    $info = "";
    if ($baggageInfo) {
        $info .= "<h2>Baggage overview</h2>";
        $info .= "<table border='1'>";
        $info .= "<thead>";
        $info .= "<tr>";
        $info .= "<td>Weight</td>";
        $info .= "<td>&nbsp;</td>";
        $info .= "</tr>";
        $info .= "</thead>";
        $info .= "<tbody>";
        foreach ($baggageInfo as $baggage) {
            $passengerNumber = $baggage['passagiernummer'];
            $number = $baggage['objectvolgnummer'];
            $weight = $baggage['gewicht'];

            $info .= "<tr>";
            $info .= "<td>".$weight." kg</td>";
            $info .= "<td><a href='logic/deleteBaggage.php?&number=".$number."&passenger=".$passengerNumber."'>".DELETEBUTTON."</a></td>";
            $info .= "</tr>";
        }
        $info .= "</tbody>";
        $info .= "</table>";
    }

    return $info;
}
?>