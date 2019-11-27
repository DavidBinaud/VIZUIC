<?php
	echo "<p> La question n°" . $id . " à bien été éffacé. </p>";
	require File::build_path(array("view", "formulaire","list.php"));
?>