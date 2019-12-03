<?php 


	$Identifiant = htmlspecialchars($_GET["Identifiant"]);
    $nomUtilisateur = htmlspecialchars($_GET["nomUtilisateur"]);
    $email = htmlspecialchars($_GET["email"]);

 	echo "<p>Erreur : $errorType </p>";
	require(File::build_path(array("view", "utilisateur", "update.php")));
?>