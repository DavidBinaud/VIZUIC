<?php
	//On affiche un div contenant les choix des réponses
	echo "	<div id='reponses' style='border: 1px solid; padding:10px;'>";
				
	foreach ($tab_InfosReponses as $reponse) {
		$nomReponse = $reponse['nomReponse'];
		$idReponse = $reponse['idReponse'];
		echo "<label for='$nomReponse'>$nomReponse</label>
		<input type='checkbox' value='$idParametre' class='reponse' id=$idReponse checked>";
	}	
	echo"</div>";





	//On affiche un div contenant les choix des variables
	echo "	<div id='parametres' style='border: 1px solid; padding:10px;'>";
				
	foreach ($tab_InfosVariables as $variable) {
		$nomParametre = $variable['nomVariable'];
		$idParametre = $variable['idVariable'];
		echo "<label for='$nomParametre'>$nomParametre</label>
		<input type='checkbox' value='$idParametre' class='parametre' id=Param$idParametre checked>";
	}	
	echo"</div>
	<div>
		<button id='Filtrer'>Filtrer</button>
	</div>";
?>

<div class="radarChart"></div>

<script src="radarChart.js"></script>


<script>
	document.getElementById("Filtrer").addEventListener("click", function(event) {
  		event.preventDefault();
  		TracerVisualisation();
	});

	var dataReponses = <?php echo json_encode($tab_DataReponses);?>;
	console.log(dataReponses);



    //document.getElementById('parametres').onchange = function (e) {
    function TracerVisualisation() {

        
        // callback fn handles selected options
        //var parametres = getSelectedOptions(document.getElementById('parametres'));
        //document.getElementById("myText").innerHTML = options;

        //On recupere les options de reponses selectionnées
        var div = document.getElementById('reponses');
        var Reponse =  div.getElementsByClassName("reponse")
        var NbReponses =  div.getElementsByClassName("reponse").length
       	//console.log(Parametres[0].value);
        console.log(NbReponses);

        //On recupere les options de parametres selectionnées
        var div = document.getElementById('parametres');
        var Parametres =  div.getElementsByClassName("parametre")
        var Nbparametres =  div.getElementsByClassName("parametre").length
       	//console.log(Parametres[0].value);
        console.log(Parametres[0].id +Parametres[0].value);



        var data = [];
        var pushedDataSet = 0;
        //on fais un for each Reponse Selectionné
        for (var kReponse = 0; kReponse < NbReponses; kReponse++) {
        	console.log(Reponse[kReponse].checked);
        	if(Reponse[kReponse].checked === true){
        		data.push([]);
        		console.log(data);
		        //on ajoutes les parametres on the go
		        for (var kParametre = 0; kParametre < Nbparametres; kParametre++) {
		        	if(Parametres[kParametre].checked){
		        		var found = false;
		        		var countFound = 0;

		        		while(!found & countFound < Nbparametres){
		        			if (dataReponses[Reponse[kReponse].id][countFound].idVariable == Parametres[kParametre].value) {
		        				found = true;
		        			}else{
		        				countFound++;
		        			}
		        		}
		        		parametreToPush = [];
		        		parametreToPush['axis'] = dataReponses[Reponse[kReponse].id][countFound].nomVariable;
		        		parametreToPush['value'] = dataReponses[Reponse[kReponse].id][countFound].valeurVariable;
		        		data[pushedDataSet].push(parametreToPush);
		        	}
		        }
		        pushedDataSet++;
		    }
	    }
	    console.log(data);



  //       var data = [[]];
  //       for (const element of parametres){
		// 	//data[0].push("{axis:\"" + element.text + "\",value:" + element.value + "}");
		// 	/*var test = [];
		// 	test['axis'] = "initiative";
		// 	test['value'] = 4;*/

		// 	parametre = [];
		// 	parametre['axis'] = element.text;
		// 	parametre['value'] = element.value;

		// 	data[0].push(parametre);
		// }
		
		// console.log(data);
		

		var margin = {top: 100, right: 100, bottom: 100, left: 100},
				width = Math.min(700, window.innerWidth - 10) - margin.left - margin.right,
				height = Math.min(width, window.innerHeight - margin.top - margin.bottom - 20);

		var color = d3.scale.ordinal()
				.range(["#EDC951","#CC333F","#00A0B0","#7bc043"]);
				
			var radarChartOptions = {
			  w: width,
			  h: height,
			  margin: margin,
			  maxValue: 5,
			  levels: 5,
			  roundStrokes: true,
			  color: color
			};




		RadarChart(".radarChart", data, radarChartOptions);
    };



    TracerVisualisation();
</script>

<div>
<button id='saveButton'>Telecharger en tant qu'Image PNG</button>
</div>

<!-- Prise en compte du bouton d'export-->
<script>
	// Set-up the export button
	d3.select('#saveButton').on('click', function(){
		saveSvgAsPng(document.getElementById("diagram"), "diagram.png",{backgroundColor: "#FFFFFF"});
	});
</script>