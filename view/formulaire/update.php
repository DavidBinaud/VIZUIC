<?php
  $controller = static::$object;
  if ($_GET['action'] == 'create') {
    $value = 'created';
    $type = 'required';
    $idFormulaire = '""';
    $nomFormulaire = '""';
    $descriptionFormulaire = '""';
  }
  else if($_GET['action'] == 'update') {
    $value = 'updated';
    $type = 'readonly';
    $idFormulaire = htmlspecialchars($tab_q->get('idFormulaire'));
    $nomFormulaire = htmlspecialchars($tab_q->get('nomFormulaire'));
    $descriptionFormulaire = htmlspecialchars($tab_q->get('descriptionFormulaire'));
    $idCreateur = htmlspecialchars($tab_q->get('idCreateur'));
  }
?>

<form method="get" action="./index.php"> <!-- Transmissions des infos via le Get qui utilise une query string-->
  <fieldset>
    <input type='hidden' name='action' value="<?php echo $value;?>"/>
    <input type='hidden' name='controller' value="<?php echo $controller;?>"/>
    <legend>Créer un formulaire :</legend>
    <p>
      <label for="idFormulaire_id">Numéro du formulaire :</label>
      <input type="text" value="<?php echo $idFormulaire;?>" name="idFormulaire" id="idFormulaire_id" required/>
    </p>
    <p>
      <label for="nomFormulaire_id">Nom du Formulaire :</label>
      <input type="text" value="<?php echo $nomFormulaire;?>" name="nomFormulaire" id="nomFormulaire_id" required/>
    </p>
    <p>
      <label for="descriptionFormulaire_id">Description du Formulaire :</label>
      <input type="text" value="<?php echo $descriptionFormulaire;?>" name="descriptionFormulaire" id="descriptionFormulaire_id" required/>
    <!--</p>
      <input type='hidden' value="<?php echo $idCreateur;?>" name="idCreateur" id="idCreateur">
    <p>-->
      <button class="waves-effect waves-light btn" type="submit" value="Enregistrer"> Envoyer <i class="material-icons right">send</i> </button>
    </p>
  </fieldset> 
</form>