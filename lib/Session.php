<?php

class Session {
    public static function is_user($Identifiant) {
        return (!empty($_SESSION['Identifiant']) && ($_SESSION['Identifiant'] == $Identifiant));
    }

    public static function is_admin() {
    	return (!empty($_SESSION['est_Admin']) && $_SESSION['est_Admin']);
	}
}

?>