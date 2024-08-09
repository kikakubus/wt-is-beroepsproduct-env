<?php 
//passenger data
$passenger = fGetBaseObject('Passagier', 'passagiernummer', $_GET['id']);

//flight info
$flight = fGetBaseObject('Vlucht', 'vluchtnummer', $passenger['vluchtnummer']);
$luchthaven = fGetBaseObject('Luchthaven', 'luchthavencode', $flight["bestemming"]);
$flightInfo = fShowFlightInfo($passenger['vluchtnummer']);

//passenger info
$passengerInfo = fShowPassengerInfo($_GET['id']);

//baggage
$baggageText = fShowBaggageOverview($_GET['id']);
?>

<div class="mms-center">
	<?=$flightInfo?>
	<?=$passengerInfo?>
	<?=$baggageText?>
</div>