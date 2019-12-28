<?php
	//On affiche un div contenant les choix des réponses
	echo "<div class='container'>
	<div class='section'>
	<form action='#' id='reponses'>";
				
	foreach ($tab_InfosReponses as $reponse) {
		$nomReponse = $reponse['nomReponse'];
		$idReponse = $reponse['idReponse'];
		echo "<p class='CustomCheckboxes'>
			<label for='Reponse$idReponse'>
			<input type='checkbox' value='$idReponse' class='reponse' id=Reponse$idReponse>
			<span>$nomReponse</span>
			</label>
			</p>
		";
	}	
	echo"</form>
	</div>";





	//On affiche un div contenant les choix des variables
	echo "<div class='divider'></div>
	<div class='section'>
	<form action='#' id='parametres'>";
				
	foreach ($tab_InfosVariables as $variable) {
		$nomParametre = $variable['nomVariable'];
		$idParametre = $variable['idVariable'];
		echo "<p class='CustomCheckboxes'>
			<label for='Param$idParametre'>
			<input type='checkbox' value='$idParametre' class='parametre' id=Param$idParametre checked='checked'>
			<span>$nomParametre</span>
			</label>
			</p>";
	}	
	echo"</form>
	</div>";
	
?>

<div class='divider'></div>
<div class="section">
	<div class="row">
<div class="switch col s6">
    <label>
      Visualisation Superposée
      <input type="checkbox" name="switch">
      <span class="lever"></span>
      Visualisation Séparée
    </label>
 </div>


<div class="col s6">
		<button id='Filtrer' class='waves-effect waves-light btn blue lighten-1 right'>Filtrer</button>
</div>
</div>
</div>


<div class="section">

<div id='charts' style='display:flex; flex-wrap: wrap; justify-content:center;'></div>
</div>
</div>

<script src="radarChart.js"></script>


<script>
	document.getElementById("Filtrer").addEventListener("click", function(event) {
  		event.preventDefault();
  		TracerVisualisation();
	});


	var dataReponses = <?php echo json_encode($tab_DataReponses);?>;




    function TracerVisualisation() {
    	document.getElementById("charts").innerHTML = "";


        //On recupere les options de reponses selectionnées
        var docReponses = document.getElementById('reponses');
        var Reponse =  docReponses.getElementsByClassName("reponse")
        var NbReponses =  docReponses.getElementsByClassName("reponse").length



        //On recupere les options de parametres selectionnées
        var docParam = document.getElementById('parametres');
        var Parametres =  docParam.getElementsByClassName("parametre")
        var Nbparametres =  docParam.getElementsByClassName("parametre").length




        var data = [];
        var pushedDataSet = 0;

        //on fais un for each Reponse Selectionné
        for (var kReponse = 0; kReponse < NbReponses; kReponse++) {

        	if(Reponse[kReponse].checked === true){
        		data.push([]);

		        //on ajoutes les parametres on the go
		        for (var kParametre = 0; kParametre < Nbparametres; kParametre++) {
		        	if(Parametres[kParametre].checked){
		        		var found = false;
		        		var countFound = 0;

		        		while(!found & countFound < Nbparametres){
		        			if (dataReponses[Reponse[kReponse].value][countFound].idVariable == Parametres[kParametre].value) {
		        				found = true;
		        			}else{
		        				countFound++;
		        			}
		        		}
		        		parametreToPush = [];
		        		parametreToPush['axis'] = dataReponses[Reponse[kReponse].value][countFound].nomVariable;
		        		parametreToPush['value'] = parseFloat(dataReponses[Reponse[kReponse].value][countFound].valeurVariable);
		        		data[pushedDataSet].push(parametreToPush);
		        	}
		        }
		        data[pushedDataSet]['nomReponse'] = Reponse[kReponse].labels[0].innerText.slice(0,-1);
		        pushedDataSet++;
		    }
	    }


		

		var margin = {top: 100, right: 200, bottom: 100, left: 100},
				width = Math.min(700, window.innerWidth - 10) - margin.left - margin.right,
				height = Math.min(width, window.innerHeight - margin.top - margin.bottom - 20);

		var color = d3.scale.ordinal()
				.range(["#EDC951","#CC333F","#00A0B0","#7bc043"]);
				
			var radarChartOptions = {
			  w: width,
			  h: height,
			  margin: margin,
			  maxValue: 10,
			  levels: 5,
			  roundStrokes: true,
			  color: color
			};



		if (document.querySelector('input[name="switch"]').checked) {
			

			for (var i = 0; i < pushedDataSet; i++) {

				var localdata = data.splice(0,1);
				var divCharts = document.getElementById("charts");
				var divRadar  = document.createElement("div");
				divRadar.className = `radarChart${i}`;
				divRadar.style = 'border: 2px solid; margin: 5px;';
				divCharts.appendChild(divRadar);

				RadarChart(`.radarChart${i}`, localdata, radarChartOptions);


				//Ajout du boutton pour télécharger le svg en image
				var divButton = document.createElement("div");
				divButton.style.textAlign = "center";

				var button = document.createElement("button");
				button.id = `saveButton${i}`;
				button.className = "waves-effect waves-light btn blue lighten-1";
				button.innerText = "Telecharger en tant qu'Image PNG";

				divButton.appendChild(button);
				divRadar.appendChild(divButton);

				//il connait la valeur de i finale et donc ne retrouve pas le diagram correspondant
				button.onclick = function(){
					var numero = this.id.substr(10);
					console.log(numero);
					var radarChartToDL = document.getElementById("diagram-radarChart"+numero);
					var name = radarChartToDL.getElementById("legendText0-radarChart" + numero).innerHTML;
					console.log(radarChartToDL);
					saveSvgAsPng(radarChartToDL, name + '.png',{backgroundColor: '#FFFFFF'});}
			};


		}else if(pushedDataSet > 0){
			document.getElementById("charts").innerHTML = "<div class='radarChart' style='border: 2px solid; margin: 5px;'></div>";
			RadarChart(".radarChart", data, radarChartOptions);

			//Ajout du boutton pour télécharger le svg en image
			divRadar = document.getElementsByClassName('radarChart')[0];

			var divButton = document.createElement("div");
			divButton.style.textAlign = "center";

			var button = document.createElement("button");
			button.id = 'saveButton';
			button.className = "waves-effect waves-light btn blue lighten-1";
			button.innerText = "Telecharger en tant qu'Image PNG";

			divButton.appendChild(button);
			divRadar.appendChild(divButton);

			//on prepare le nom de l'image a telecharger
			var name = "";
			data.forEach(function(u){name = name + u['nomReponse'] + "-";});
			//on enleve le dernier '-'
			name = name.slice(0, -1);
			//Ajout de l'évenement sur le bouton
			d3.select('#saveButton').on('click', function(){saveSvgAsPng(document.getElementById("diagram-radarChart"), name + '.png',{backgroundColor: '#FFFFFF'});});
		}
    }
    
</script>
