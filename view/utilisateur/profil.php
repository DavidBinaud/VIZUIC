<?php
    echo "<h3>Votre profil</h3>";

    echo "<br>Nom: " . htmlspecialchars($u->get("nomUtilisateur"));
	echo "<br>Mail: " . htmlspecialchars($u->get("email"));

    if(Session::is_admin() || Session::is_user($u->get("Identifiant"))) {
		echo "<p><a class=\"amber waves-effect waves-light btn\" href=index.php?action=delete&controller=utilisateur&Identifiant=" . rawurlencode($u->get("Identifiant")) . ">Supprimer le compte ?</a> </p>";
		echo " <p><a class=\"amber waves-effect waves-light btn\"href=index.php?action=update&controller=utilisateur&Identifiant=" . rawurlencode($u->get("Identifiant")) . ">Modifier les informations ?</a> </p>";
	}
	if(Session::is_user($u->get("Identifiant"))) {
    	echo "<p><a class=\"amber waves-effect waves-light btn\" href=index.php?action=preference&controller=utilisateur&Identifiant=" . rawurlencode($u->get("Identifiant")) . ">Ma préférence</a></p>";
    	echo "<p><a class=\"amber waves-effect waves-light btn\"href=index.php?action=deconnect&controller=utilisateur>Se déconnecter ?</a></p>";
    }	
?>