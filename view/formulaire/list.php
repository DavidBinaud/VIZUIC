<?php
	echo '<p> Liste des formulaires : <br> </p>';
    

    if ($gestion == 1) {
		foreach ($tab_q as $q) {
    		echo "<p> Le Formulaire <a class='nomForm' href='index.php?action=readAll&controller=champ&gestion=1&idFormulaire=" . $q->get('idFormulaire') . "'>" . $q->get('nomFormulaire') . "</a> </p>";
    	
    
			echo"
			<button>
				<a href='./index.php?action=delete&controller=formulaire&idFormulaire={$q->get('idFormulaire')}'>Supprimer</a>
			</button>
			<button>
				<a href='./index.php?action=update&controller=formulaire&idFormulaire={$q->get('idFormulaire')}'>Mettre à Jour</a>
			</button>";
		}
	} else{
		foreach ($tab_q as $q) {
    		echo "<p> Le Formulaire <a class='nomForm' href='index.php?action=readAll&controller=champ&gestion=0&idFormulaire=" . $q->get('idFormulaire') . "'>" . $q->get('nomFormulaire') . "</a> </p>";
   		 }	
   	}
?>