<?php
	echo '<p> Liste des formulaires : <br> </p>';
    foreach ($tab_q as $q) {
    	echo "<p> Le Formulaire <a class='nomForm' href='index.php?action=readAll&controller=champ&idFormulaire=" . $q->get('idFormulaire') . "'>" . $q->get('nomFormulaire') . "</a> </p>";
    }
?>