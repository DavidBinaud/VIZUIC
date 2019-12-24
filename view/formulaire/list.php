<?php
	echo "<h3 class='titreListForm center'> Liste des formulaires	 <br> </h3>
        <div class='container'>";
    
    if ($gestion == 1) {
        echo "<table>
        <thead>
          <tr>
              <th>Formulaire</th>
              <th>Voir questions</th>
              <th>Modifier</th>
              <th>Supprimer</th>
          </tr>
        </thead>

        <tbody>";

		foreach ($tab_q as $q) {						
        echo "<tr>
            <td>" . $q->get('nomFormulaire') . "</td>
            <td><a href='index.php?action=readAll&controller=champ&gestion=1&idFormulaire={$q->get('idFormulaire')}'><i class='material-icons'>reply</i></a></td>
            <td><a href='./index.php?action=update&controller=formulaire&idFormulaire={$q->get('idFormulaire')}'><i class='material-icons'>edit</i></a></td>
            <td><a href='./index.php?action=delete&controller=formulaire&idFormulaire={$q->get('idFormulaire')}'><i class='material-icons'>close</i></a></td>
          </tr>";
		}
    echo "</tbody>
            </table>";

	} else{
    echo "<table>
        <thead>
          <tr>
              <th>Formulaire</th>
              <th>Répondre</th>
              <th>Liste réponses</th>
              <th>Visualiser</th>
          </tr>
        </thead>

        <tbody>";
		foreach ($tab_q as $q) {
    		echo " <tr>
            <td>" . $q->get('nomFormulaire') . "</td>
            <td><a href='index.php?action=readAll&controller=champ&gestion=0&idFormulaire={$q->get('idFormulaire')}'><i class='material-icons'>reply</i></a></td>
            <td><a href='index.php?action=readAll&controller=reponse&idFormulaire={$q->get('idFormulaire')}'><i class='material-icons'>view_list</i></a></td>
            <td><a href='index.php?action=readAll&controller=visualisation&idFormulaire={$q->get('idFormulaire')}'<i class='material-icons'>bubble_chart</i></a></td>'
          </tr>";
   		 }
       echo "</tbody>
            </table>";	
   	}

    echo "</div>";        
         
?>