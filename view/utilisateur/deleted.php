<?php
echo "<p>L'utilisateur $Identifiant a bien été supprimée !</p>";
require(File::build_path(array("view", "utilisateur", "list.php")));
?>