<?php
  $controller = static::$object;
  if (myGet('action') == 'create') {
    $value = 'created';
    $type = 'required';
    $idFormulaire = '""';
    $nomFormulaire = '""';
    $descriptionFormulaire = '""';
    $variable= '""';
    $idVariable= '""';
    $idCreateur='""';
  }
  else if(myGet('action') == 'update') {
    $value = 'updated';
    $type = 'readonly';
    $idFormulaire = htmlspecialchars($tab_q->get('idFormulaire'));
    $nomFormulaire = htmlspecialchars($tab_q->get('nomFormulaire'));
    $descriptionFormulaire = htmlspecialchars($tab_q->get('descriptionFormulaire'));
    $idCreateur = htmlspecialchars($tab_q->get('idCreateur'));
    $variable="";
    $idVariable="";
    if ($tab_variable != null) {
      foreach ($tab_variable as $v) {
        $variable .= $v['nomVariable'] . ";";
        $idVariable .= $v['idVariable'] . ";"; 
      }
    }
    
  }

   echo "<a class='btn-flat waves-effect' href='index.php?action=readAll&controller=formulaire&gestion=1'><i class='material-icons blue-text blue-accent-3'>arrow_back</i></a>";
?>

<form method="<?php echo Conf::getDebug()?"GET":"POST"; ?>" action="./index.php"> <!-- Transmissions des infos via le Get qui utilise une query string-->
  <fieldset class="container">
    <input type='hidden' name='action' value="<?php echo $value;?>"/>
    <input type='hidden' name='controller' value="<?php echo $controller;?>"/>
    <legend>Créer un formulaire :</legend>
    <?php 
      if(myGet('action') == 'update') {
        echo "<input type='hidden' name='idFormulaire' value='" . htmlspecialchars($idFormulaire) . "'/>";
      }
    ?>
    <p>
      <label for="nomFormulaire_id">Nom du Formulaire :</label>
      <input type="text" value="<?php echo $nomFormulaire;?>" name="nomFormulaire" id="nomFormulaire_id" required/>
    </p>
    <p>
      <label for="descriptionFormulaire_id">Description du Formulaire :</label>
      <input type="text" value="<?php echo $descriptionFormulaire;?>" name="descriptionFormulaire" id="descriptionFormulaire_id" required/>
      <label for="variable_id">Liste des paramètres</label>
      <input type="text" value="<?php echo $variable;?>" name="variable" id="variable_id" placeholder="Veuillez entrer les paramètres souhaités séparé par des ';'. Exemple : paramètres1;paramètres2" />
      <input type="hidden" value="<?php echo $idVariable;?>" name="idVariable" id="idVariable_id" />

    </p>
      <input type='hidden' value="<?php echo $idCreateur;?>" name="idCreateur" id="idCreateur">
    <p>
      <button class='waves-effect waves-light btn blue accent-3 right' type="submit" value="Enregistrer"> Envoyer <i class="material-icons right">send</i> </button>
    </p>
  </fieldset> 
</form>