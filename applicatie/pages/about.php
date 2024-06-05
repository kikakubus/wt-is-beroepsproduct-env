<?php 

namespace pages; 

$array = [
    ["titel" => "titanic", "id" => 1],
    ["titel" => "skyscraper", "id" => 2]
];


foreach ($array as $film){
    echo "<div><a href='index.php?page=films&id=".$film["id"]."'>".$film["titel"]."</a></div>";
}

?>