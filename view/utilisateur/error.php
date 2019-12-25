<?php 

 	echo "<p style=\"border: 2px solid red ; border-radius:6px;\" class=\"red lighten-3\">";
    echo "  <i class=\"material-icons left\">error_outline</i>" . $errorType;
    echo "</p>";
	require(File::build_path(array("view", "utilisateur", "profil.php")));
?>