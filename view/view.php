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
        <nav class='blue lighten-1'>
        <?php
        if (isset($_SESSION["Identifiant"])) {
    	   echo "
           <div class ='nav-wrapper'>
           <a href'index.php?action=readAll&controller=formulaire&gestion=1' class='brand-logo center'><img src='images/VIZUIC_LOGO.png' width='70' height='70'></a>
    		<ul> 
                <li><a href='index.php?action=readAll&controller=formulaire&gestion=1'>Mes formulaire</a></li>
	    		<li><a href='index.php?action=readAll&controller=formulaire&gestion=0'>Mes réponses</a></li>
            </ul>
            <ul class='right'>
                <li><a href='index.php?action=connect&controller=utilisateur'><i class='material-icons'>account_circle</i></a></li>
            </ul>
            </div>
    	   ";
        }
        echo "</nav>
        <header></header>
        <main>";

		// Si $controleur='voiture' et $view='list',
		// alors $filepath="/chemin_du_site/view/voiture/list.php"
		$filepath = File::build_path(array("view", static::$object, "$view.php"));
		require $filepath;
		?>

    </main>

     <footer class="page-footer blue lighten-1">
        <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text center">VIZUIC :</h5>
              </div>
              <div class="col l4 s12">
                <ul>
                    <li><a class="grey-text text-lighten-3" href="#!">Vizualisation de l'intelligence collective</a></li>
                </ul>
              </div>
            </div>
          </div>
    </footer>

    </body>

   

</html>