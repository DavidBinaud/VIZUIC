        <form method="<?php echo Conf::getDebug()?"GET":"POST"; ?>" action="index.php">
          <fieldset>
            <legend><?php echo $legend?> :</legend>
            <p>
              <input type="hidden" name="action" value="<?php echo $action?>">
              <input type="hidden" name="controller" value="utilisateur">
              <label for="Identifiant">Identifiant: </label>
              <input type="text" placeholder="Ex : polo" name="Identifiant" id="Identifiant" value="<?php echo $Identifiant?>" <?php echo $etat?>/> <br>
              <label for="nom">Nom: </label>
              <input type="text" placeholder="Ex : Binaud David" name="nomUtilisateur" id="nomUtilisateur" value="<?php echo $nomUtilisateur?>" required/> <br>
              <label for="email">Mail: </label>
              <input type="email" placeholder="Ex: abcd@mail.com" id="email" name="email" value="<?php echo $email ?>" required>
              <label>Mot de passe: </label>
              <input type="password" name="mdp1" required><br>
              <label>Répetez le mot de passe: </label>
              <input type="password" name="mdp2" required><br>
              <?php
              if(Session::is_admin() | $action=='created') {
                $checked = "";
                if(isset($est_Admin) && $est_Admin == 1) {
                  $checked = "checked";
                }

                echo "<label>
                        <input type=\"checkbox\" name=\"est_Admin\" " . $checked . " />
                        <span>Admin</span>
                      </label>";
              } else {
                echo "<input type=\"hidden\" name=\"est_Admin\"/><br>";
              }
              ?>
            </p>
            <p>
              <button class='waves-effect waves-light btn blue accent-3 right' type="submit" value="Enregistrer" /> Envoyer <i class="material-icons right">send</i> </button>
            </p>
          </fieldset> 
        </form>