<?php
	echo "<p> La question n°" . $idChamp . " à bien été éffacé. </p>";
	require File::build_path(array("view", "formulaire","list.php"));
?>