<?php
	echo "<h3 class='titreListForm center'> Liste des formulaires	 <br> </h3>
        <div class='container'>";

        if ($tab_q != false) {
          if ($gestion == 1) {
        echo "<table class='highlight'>
        <thead>
          <tr>
              <th>Formulaire</th>
              <th>Modifier</th>
              <th>Supprimer</th>
          </tr>
        </thead>

        <tbody>";

    foreach ($tab_q as $q) {            
        echo "<tr>
            <td>" . htmlspecialchars($q->get('nomFormulaire')) . "</td>
            <td><a href='./index.php?action=update&controller=formulaire&idFormulaire=" . rawurlencode($q->get('idFormulaire')) . "'><i class='material-icons blue-text blue-accent-3'>edit</i></a></td>
            <td><a href='./index.php?action=delete&controller=formulaire&idFormulaire=" . rawurlencode($q->get('idFormulaire')) . "'><i class='material-icons blue-text blue-accent-3'>close</i></a></td>
          </tr>";
    }
    echo "</tbody>
            </table>";

  } else{
    echo "<table class='highlight'>
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
            <td>" . htmlspecialchars($q->get('nomFormulaire')) . "</td>
            <td><a href='index.php?action=readAll&controller=champ&gestion=0&idFormulaire=" . rawurlencode($q->get('idFormulaire')) . "'><i class='material-icons blue-text blue-accent-3'>reply</i></a></td>
            <td><a href='index.php?action=readAll&controller=reponse&idFormulaire=" . rawurlencode($q->get('idFormulaire')) . "'><i class='material-icons blue-text blue-accent-3'>view_list</i></a></td>
            <td><a href='index.php?action=readAll&controller=visualisation&idFormulaire=" . rawurlencode($q->get('idFormulaire')) . "'><i class='material-icons blue-text blue-accent-3'>bubble_chart</i></a></td>
          </tr>";
       }
       echo "</tbody>
            </table>";  
    }
  } else {
    echo "Il n'y a pas de formulaires";
  }
  echo "</div>";    

  echo"<div class='fixed-action-btn'><a href='index.php?action=create&controller=formulaire' class='btn-floating btn-large waves-effect waves-light pulse white'><i class='large material-icons blue-text text-accent-3'>add</i></a></div>";      
         
?>

