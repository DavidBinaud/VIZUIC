<?php
	echo "<h3 class='titreListForm'> Liste des réponses	 <br> </h3>

		<div class='container'>
		<table>
        <thead>
          <tr>
              <th>Nom réponse</th>
              <th>Voir réponse</th>
              <th>Modifier</th>
              <th>Supprimer</th>
          </tr>
        </thead>

        <tbody>";

        if ($tab_r != null) {
        	foreach ($tab_r as $r) {
 				echo " <tr>
           					<td>" . $r->get('nomReponse') . "</td>
	            			<td><a href='index.php?action=read&controller=reponse&gestion=0&idFormulaire=" . $r->get('idFormulaire') . "&idReponse=" . $r->get('idReponse') . "'><i class='material-icons'>assignment</i></a></td>
	            			<td><a href='./index.php?action=update&controller=reponse&idReponse={$r->get('idReponse')}&idFormulaire={$r->get('idFormulaire')}'><i class='material-icons'>edit</i></a></td>
	           				<td><a href='./index.php?action=delete&controller=reponse&idReponse={$r->get('idReponse')}&idFormulaire={$r->get('idFormulaire')}'><i class='material-icons'>clear</i></a></td>
	          			</tr>";
			}
			echo "</tbody>
	            </table>";
        } else{
        	echo "</tbody>
	            </table>
	            <p>Il n'y a pas de réponses</p>";
        }
    
		
			
	        echo "</div>"; 	
?>