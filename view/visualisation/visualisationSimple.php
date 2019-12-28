<?php
	//On affiche un div contenant les choix des variables
	echo "<form action='#' id='parametres' style='border: 2px solid; margin: 5px;'>";
				
	foreach ($tab_InfosVariables as $variable) {
		$nomParametre = $variable['nomVariable'];
		$idParametre = $variable['idVariable'];
		echo "<label for='Param$idParametre'>
			<input type='checkbox' value='$idParametre' class='parametre' id=Param$idParametre checked='checked'>
			<span>$nomParametre</span>
			</label>";
	}	
	echo"</form>";
	
?>
<div>
		<button id='Filtrer' class='waves-effect waves-light btn blue lighten-1'>Filtrer</button>
</div>

<div class="radarChart"></div>

<script src="radarChart.js"></script>


<script>
	document.getElementById("Filtrer").addEventListener("click", function(event) {
  		event.preventDefault();
  		TracerVisualisation();
	});

	var dataReponses = <?php echo json_encode($tab_DataReponses);?>;
	

    function TracerVisualisation() {

        //On recupere les options de parametres selectionnées
        var docParam = document.getElementById('parametres');
        var Parametres =  docParam.getElementsByClassName("parametre")
        var Nbparametres =  docParam.getElementsByClassName("parametre").length
       	//console.log(Parametres[0].value);
        //console.log(Nbparametres);



        var data = [[]];

		for (var kParametre = 0; kParametre < Nbparametres; kParametre++) {
		    if(Parametres[kParametre].checked){
		        var found = false;
		        var countFound = 0;

		     	while(!found & countFound < Nbparametres){
		        	if (dataReponses[countFound].idVariable == Parametres[kParametre].value) {
		        		found = true;
		        	}else{
		        		countFound++;
		        	}
		        }
		        parametreToPush = [];
		        parametreToPush['axis'] = dataReponses[countFound].nomVariable;
		        parametreToPush['value'] = parseFloat(dataReponses[countFound].valeurVariable);
		        data[0].push(parametreToPush);
			}
		}
		

		var margin = {top: 100, right: 100, bottom: 100, left: 100},
				width = Math.min(700, window.innerWidth - 10) - margin.left - margin.right,
				height = Math.min(width, window.innerHeight - margin.top - margin.bottom - 20);

		var color = d3.scale.ordinal()
				.range(["#EDC951","#CC333F","#00A0B0"]);
				
			var radarChartOptions = {
			  w: width,
			  h: height,
			  margin: margin,
			  maxValue: 10,
			  levels: 5,
			  roundStrokes: true,
			  color: color
			};




		RadarChart(".radarChart", data, radarChartOptions);
    };



    TracerVisualisation();
</script>

<div>
	<button id='saveButton' class='waves-effect waves-light btn blue lighten-1'>Telecharger en tant qu'Image PNG</button>
</div>

<!-- Prise en compte du bouton d'export-->
<script>
	// Set-up the export button
	d3.select('#saveButton').on('click', function(){
		saveSvgAsPng(document.getElementById("diagram.radarChart"), "diagram.png",{backgroundColor: "#FFFFFF"});
	});
</script>