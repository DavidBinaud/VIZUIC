<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/styles.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
        <title><?php echo $pagetitle; ?></title>
    </head>
    <body>
    	<nav class='blue'>
    		<div> 
                <p>
                <a class='waves-effect waves-light btn blue lighten-1' href="index.php?action=readAll&controller=formulaire">Répondre à un formulaire</a>
	    		<a class='waves-effect waves-light btn blue lighten-1' href="index.php?action=readAll&controller=formulaire">Gestion formulaire</a>
                <a class='waves-effect waves-light btn blue lighten-1' href="index.php?action=create&controller=formulaire">Creation de formulaire</a>
                </p>
    		</div>
    	</nav>
		<?php
		// Si $controleur='voiture' et $view='list',
		// alors $filepath="/chemin_du_site/view/voiture/list.php"
		$filepath = File::build_path(array("view", static::$object, "$view.php"));
		require $filepath;
		?>
    </body>
    <p style="border: 1px solid black;text-align:right;padding-right:1em;">
  		Formulaire de VIZUIC
	</p>
</html>