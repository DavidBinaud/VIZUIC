<?php
    require_once './lib/File.php';
    if($q == false) {

        require File::build_path(array("view", "formulaire", "error.php"));
    }
    else {
        echo "<p>Question : " . htmlspecialchars($q->get('nomChamp')) . " et de type : " . htmlspecialchars($q->get('typeChamp')) . " <a class='waves-effect waves-light btn blue accent-3'  href='./index.php?action=update&controller=champ&idChamp={$q->get('idChamp')}'>Modifier</a>  <a class='waves-effect waves-light btn'  href='./index.php?action=delete&controller=champ&idChamp={$q->get('idChamp')}'>Supprimer</a>";
    }
?>
