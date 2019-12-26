<?php

echo "<p>L'utilisateur a bien été mis à jour</p>";
if (Session::is_admin() && (strcmp($_SESSION['Identifiant'],myGet('Identifiant')) !=0) ) {
	require(File::build_path(array("view", "utilisateur", "list.php")));
} else {
	require(File::build_path(array("view", "utilisateur", "profil.php")));
}

?>