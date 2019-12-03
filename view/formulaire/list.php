<?php
	echo '<h3 class="titreListForm"> Liste des formulaires	 <br> </h3>';
    

    if ($gestion == 1) {
		foreach ($tab_q as $q) {
    		echo "<div class='formList'> <p> Le Formulaire <a class='nomForm' href='index.php?action=readAll&controller=champ&gestion=1&idFormulaire=" . $q->get('idFormulaire') . "'>" . $q->get('nomFormulaire') . "</a> </p>";
    	
    
			echo"
			<button>
				<a href='./index.php?action=delete&controller=formulaire&idFormulaire={$q->get('idFormulaire')}'>Supprimer</a>
			</button>
			<button>
				<a href='./index.php?action=update&controller=formulaire&idFormulaire={$q->get('idFormulaire')}'>Modifier</a>
			</button> 
			</div>";
		}
	} else{
		foreach ($tab_q as $q) {
    		echo "<p> Le Formulaire <a class='nomForm' href='index.php?action=readAll&controller=champ&gestion=0&idFormulaire=" . $q->get('idFormulaire') . "'>" . $q->get('nomFormulaire') . "</a> </p>";
   		 }	
   	}
?>