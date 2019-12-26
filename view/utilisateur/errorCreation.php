<?php 


	$Identifiant = htmlspecialchars(myGet("Identifiant"));
    $nomUtilisateur = htmlspecialchars(myGet("nomUtilisateur"));
    $email = htmlspecialchars(myGet("email"));

 	echo "<p>Erreur : $errorType </p>";
	require(File::build_path(array("view", "utilisateur", "update.php")));
?>