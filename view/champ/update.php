<?php
  $controller = static::$object;
  if (myGet('action') == 'create') {
    $value = 'created';
    $type = 'required';
    $idChamp = '""';
    $nomChamp = '""';
    $instructionReponse = '""';
    $contexte = '""';
    $typeChamp = 'choisir un type';
    $idFormulaire = myGet('idFormulaire');
  }
  else if(myGet('action') == 'update') {
    $value = 'updated';
    $type = 'readonly';
    $idChamp = htmlspecialchars($tab_q->get('idChamp'));
    $nomChamp = htmlspecialchars($tab_q->get('nomChamp'));
    $typeChamp = htmlspecialchars($tab_q->get('typeChamp'));
    $idFormulaire = htmlspecialchars($tab_q->get('idFormulaire'));
    $instructionReponse = htmlspecialchars($tab_q->get('instructionReponse'));
    $contexte = htmlspecialchars($tab_q->get('contexte'));
  }

   echo "<a class='btn-flat waves-effect' href='index.php?action=readAll&controller=champ&idFormulaire=" . rawurlencode($idFormulaire) . "&gestion=1'><i class='material-icons blue-text blue-accent-3'>arrow_back</i></a>";
  
?>

<form method="<?php echo Conf::getDebug()?"GET":"POST"; ?>" action="./index.php"> <!-- Transmissions des infos via le Get qui utilise une query string-->
  <fieldset>
    <input type='hidden' name='action' value="<?php echo $value;?>"/>
    <input type='hidden' name='controller' value="<?php echo $controller;?>"/>
    <input type='hidden' name='idFormulaire' value="<?php echo $idFormulaire; ?>">
    <legend>Créer/modifier une question :</legend>
    <input type="hidden" value="<?php echo $idChamp;?>" name="idChamp" id="idChamp" required/>

    <p>
      <label for="nomChamp_id">Contexte :</label>
      <input type="text" value="<?php echo $contexte;?>" name="contexte" id="nomChamp_id" />
    </p><p>
      <label for="nomChamp_id">Question :</label>
      <input type="text" value="<?php echo $nomChamp;?>" name="nomChamp" id="nomChamp_id" required/>
    </p>
    <p>
      <label for="nomChamp_id">Instrunctions de réponse :</label>
      <input type="text" value="<?php echo $instructionReponse;?>" name="instructionReponse" id="nomChamp_id" />
    </p>
    <p>
      <label for="typeChamp">Type :</label>
      <select name="typeChamp" id="typeChamp" onchange="myFunction()">
      <option value="texte">Texte</option>
      <option value="nombre">Nombre</option>
      <option value="echelle">Echelle</option>
      </select>

      <p id ="demo"></p>

      <script>
      function myFunction() {
       var x = document.getElementById("typeChamp").value;
        if(x == "echelle" | x == "nombre"){
        
          document.getElementById("demo").innerHTML = "Insérer valeur max : " + x;
          document.getElementById("demo").innerHTML += " <input name='max' type='text' placeholder = 'Exemple : 10'/>"
        }
        else {
          document.getElementById("demo").innerHTML = "Le type choisi est le type " + x;
        }
      }
      </script>
      
    </p>

    <p>
      <label for="variable">Paramètre : </label>
      <select name="idVariable" id="idVariable" onchange="myFunction2()">
        <option value=""  selected></option>
         <?php 
          foreach ($tab_variable as $v) {
            echo "<option value='" . $v['idVariable'] . "'> " . $v['nomVariable'] . "</option>";
          }
        ?>
      </select>

      <p id ="demo2"></p>

      <script>
      function myFunction2() {
       var x = document.getElementById("idVariable").value;
        if(x != ""){
        
        document.getElementById("demo2").innerHTML = "Insérer un coefficient";
        document.getElementById("demo2").innerHTML += " <input name='coefficient' type='number' min='0.01' max='99.99' step='0.01' placeholder = 'Exemple : 0.9'/>"
        }
        //else {
        //document.getElementById("demo2").innerHTML = "Le type choisi est le type " + x;
        //}
      }
      </script>
      
  </p>

    <p>
      <button class='waves-effect waves-light btn blue accent-3 right' type="submit" value="Enregistrer"> Envoyer <i class="material-icons right">send</i> </button>
    </p>
  </fieldset> 
</form>