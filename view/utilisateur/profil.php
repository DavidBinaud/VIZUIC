<?php
    echo "<h3>Votre profil</h3>";

    echo "<br>Nom: " . htmlspecialchars($u->get("nomUtilisateur"));
	echo "<br>Mail: " . htmlspecialchars($u->get("email"));

    if(Session::is_admin() || Session::is_user($u->get("Identifiant"))) {
		echo " <p><a class='waves-effect waves-light btn blue accent-3' href=index.php?action=update&controller=utilisateur&Identifiant=" . rawurlencode($u->get("Identifiant")) . ">Modifier les informations</a> </p>";
	}
	if(Session::is_user($u->get("Identifiant"))) {
    	echo "<p><a class='waves-effect waves-light btn red' href=index.php?action=deconnect&controller=utilisateur>Se déconnecter</a></p>";
    }	
?>