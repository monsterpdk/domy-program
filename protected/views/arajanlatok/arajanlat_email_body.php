<?php
/* @var $this ArajanlatokController */
/* @var $model Arajanlatok */

$ugyintezo_nev = $model->ugyintezo->nev ;
if ($ugyintezo_nev == "") {
	$ugyintezo_nev = "Ügyfelünk" ;
}
?>

<h1>Árajánlat</h1>

<p>Tisztelt <?php echo $ugyintezo_nev;?>!<br />
<br />
Csatolva küldjük árajánlatunkat a kért munkára, köszönjük megkeresését.<br />
Kérjük, hogy az árajánlat elfogadását válasz e-mailben, vagy telefonon jelezze felénk.<br />
<br />
Köszönettel:<br />
Gesztesi Anita<br />
Domypack & Press Kft.<br /></p>
