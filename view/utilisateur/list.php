<?php
	echo "<h3 class='titreListForm center'> Liste des utilisateurs	 <br> </h3>
        <div class='container'>";

   	if ($tab_u != false) {
    	echo "<table>
        		<thead>
          			<tr>
              			<th>Utilisateur</th>
              			<th>Modifier</th>
              			<th>Supprimer</th>
          			</tr>
        		</thead>

        	<tbody>";
    	foreach ($tab_u as $u) {
        	echo "<tr>
            		<td>" . htmlspecialchars($u->get('Identifiant')) . "</td>
            		<td><a href='index.php?action=update&controller=utilisateur&Identifiant=" . rawurlencode($u->get("Identifiant")) . "'><i class='material-icons blue-text blue-accent-3'>view_list</i></a></td>
            		<td><a href='index.php?action=delete&controller=utilisateur&Identifiant=" . rawurlencode($u->get("Identifiant")) . "'><i class='material-icons blue-text blue-accent-3'>clear</i></a></td>
          		</tr>";
       	}
       	echo "</tbody>
            </table>";  
    } else {
    	echo "Il n'y a pas de formulaires";
  	}
  	echo "</div>";

  	echo"<div class='fixed-action-btn'><a href='index.php?action=create&controller=utilisateur' class='btn-floating btn-large waves-effect waves-light pulse white'><i class='large material-icons blue-text text-accent-3'>add</i></a></div>";        
         
?>