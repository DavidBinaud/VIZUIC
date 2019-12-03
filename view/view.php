<!DOCTYPE html>
<html >
    <head lang="fr">
        <meta charset="UTF-8">

        <link rel="stylesheet" type="text/css" href="./css/styles.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

        <!-- D3.js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.6/d3.min.js"></script>

        <!-- SaveImg librairie js locale -->
        <script src="./saveSvg/src/saveSvgAsPng.js"></script>

        <title><?php echo $pagetitle; ?></title>
    </head>
    <body>
    	<nav class='blue'>
    		<div> 
                <p>
                <a class='waves-effect waves-light btn blue lighten-1' href="index.php?action=readAll&controller=formulaire&gestion=0">Répondre à un formulaire</a>
	    		<a class='waves-effect waves-light btn blue lighten-1' href="index.php?action=readAll&controller=formulaire&gestion=1">Gestion formulaire</a>
                <a class='waves-effect waves-light btn blue lighten-1' href="index.php?action=create&controller=formulaire">Creation de formulaire</a>
                <a href="index.php?action=readAll&controller=visualisation&idFormulaire=1">Affichage visualisation</a>
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