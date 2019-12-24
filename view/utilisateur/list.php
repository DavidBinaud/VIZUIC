        <?php
        echo "<h3>Liste des utilisateurs:</h3><br>";
        foreach ($tab_u as $u) {
            echo "<p>Utilisateur: <a href=index.php?action=read&controller=utilisateur&utilisateur=" . rawurlencode($u->get("Identifiant")) . ">" . htmlspecialchars($u->get("Identifiant")) . "</a></p>";
        }
        echo "<p><a class='waves-effect waves-light btn blue accent-3' href=index.php?action=create&controller=utilisateur>Création d'un utilisateur</a></p>";
        ?>