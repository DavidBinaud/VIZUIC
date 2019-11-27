<?php
	echo "<p> Le formulaire d'id : " . $id . " à bien été éffacé. </p>";
	require File::build_path(array("view", "formulaire","list.php"));
?>