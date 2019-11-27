<?php
  $controller = static::$object;
  if ($_GET['action'] == 'create') {
    $value = 'created';
    $type = 'required';
    $idChamp = '""';
    $nomChamp = '""';
    $typeChamp = 'choisir un type';
  }
  else if($_GET['action'] == 'update') {
    $value = 'updated';
    $type = 'readonly';
    $idChamp = htmlspecialchars($tab_q->get('idChamp'));
    $nomChamp = htmlspecialchars($tab_q->get('nomChamp'));
    $typeChamp = htmlspecialchars($tab_q->get('typeChamp'));
  }
?>

<form method="get" action="./index.php"> <!-- Transmissions des infos via le Get qui utilise une query string-->
  <fieldset>
    <input type='hidden' name='action' value="<?php echo $value;?>"/>
    <input type='hidden' name='controller' value="<?php echo $controller;?>"/>
    <legend>Créer un champ :</legend>
    <p>
      <label for="idChamp">Numéro de la question :</label>
      <input type="text" value="<?php echo $idChamp;?>" name="idChamp" id="idChamp" required/>
    </p>
    <p>
      <label for="nomChamp_id">Question :</label>
      <input type="text" value="<?php echo $nomChamp;?>" name="nomChamp" id="nomChamp_id" required/>
    </p>
    <p>
      <label for="typeChamp">Type :</label>
      <select name="typeChamp" id="typeChamp" onchange="myFunction()">
      <option value="Texte">Texte</option>
      <option value="Nombre">Nombre</option>
      <option value="Echelle">Echelle</option>
      </select>

      <p id ="demo"></p>

      <script>
      function myFunction() {
       var x = document.getElementById("typeChamp").value;
        if(x == "Echelle"){
        
        document.getElementById("demo").innerHTML = "Insérer valeur max de l'" + x;
        document.getElementById("demo").innerHTML += " <input name='max' type='text' placeholder = 'Exemple : 10'/>"
        }
        else {
        document.getElementById("demo").innerHTML = "Le type choisi est le type " + x;
        }
        }
      </script>
    </p>
    <p>
      <input type="submit" value="Envoyer" />
    </p>
  </fieldset> 
</form>