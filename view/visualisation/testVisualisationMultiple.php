<?php
	//On affiche un div contenant les choix des réponses
	echo "<form action='#' id='reponses' style='border: 2px solid; margin: 5px;'>";
				
	foreach ($tab_InfosReponses as $reponse) {
		$nomReponse = $reponse['nomReponse'];
		$idReponse = $reponse['idReponse'];
		echo "
			<label for='Reponse$idReponse'>
			<input type='checkbox' value='$idReponse' class='reponse' id=Reponse$idReponse>
			<span>$nomReponse</span>
			</label>
		";
	}	
	echo"</form>";





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
<form action='#' id='options' style='border: 2px solid; margin: 5px;'>
				
	<label>
	<input name="options" type="radio" value="Super"checked>
	<span>Visualisations Superposée</span>
	</label>

	<label>
	<input name="options" type="radio" value="Sep">
	<span>Visualisations Séparée</span>
	</label>

</form>


<div>
		<button id='Filtrer' class='waves-effect waves-light btn blue lighten-1'>Filtrer</button>
</div>


<div id='charts' style='display:flex; flex-wrap: wrap; justify-content:center;'>
	
</div>

<script src="radarChart.js"></script>


<script>
	document.getElementById("Filtrer").addEventListener("click", function(event) {
  		event.preventDefault();
  		TracerVisualisation();
	});

	///////////////////////TRAVAIL SUR OPTION DE VISUALISATION SEPAREE OU SUPERPOSEE//////////////////////////////
	//document.getElementById("charts").innerHTML += '<div class="radarChart3"></div>';

	// var a = 7;
	// document.getElementById("charts").innerHTML += <div class='radarChart${a}'></div>`;

	//console.log(document.getElementById("options"));
	






	var dataReponses = <?php echo json_encode($tab_DataReponses);?>;
	//console.log(dataReponses);



    function TracerVisualisation() {
    	if(document.querySelector('input[name="options"]:checked').value == "Sep"){
    		console.log("LOL");
    	}
    	document.getElementById("charts").innerHTML = "";

    	var element = document.getElementById("scriptDL");
    	if(element != null)element.parentNode.removeChild(element);

        
        // callback fn handles selected options
        //var parametres = getSelectedOptions(document.getElementById('parametres'));
        //document.getElementById("myText").innerHTML = options;

        //On recupere les options de reponses selectionnées
        var docReponses = document.getElementById('reponses');
        var Reponse =  docReponses.getElementsByClassName("reponse")
        var NbReponses =  docReponses.getElementsByClassName("reponse").length
       	//console.log(Parametres[0].value);
        //console.log(NbReponses);

        //On recupere les options de parametres selectionnées
        var docParam = document.getElementById('parametres');
        var Parametres =  docParam.getElementsByClassName("parametre")
        var Nbparametres =  docParam.getElementsByClassName("parametre").length
       	//console.log(Parametres[0].value);
        //console.log(Nbparametres);



        var data = [];
        var pushedDataSet = 0;
        //on fais un for each Reponse Selectionné
        for (var kReponse = 0; kReponse < NbReponses; kReponse++) {
        	//console.log(Reponse[kReponse].checked);
        	if(Reponse[kReponse].checked === true){
        		data.push([]);
        		//console.log(data);
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
		        		parametreToPush['value'] = dataReponses[Reponse[kReponse].value][countFound].valeurVariable;
		        		data[pushedDataSet].push(parametreToPush);
		        	}
		        }
		        data[pushedDataSet]['nomReponse'] = Reponse[kReponse].labels[0].innerText;
		        pushedDataSet++;
		        console.log(Reponse[kReponse].labels[0].innerText);
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
		

		var margin = {top: 100, right: 200, bottom: 100, left: 100},
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

		if (document.querySelector('input[name="options"]:checked').value == "Sep") {
			var script = document.createElement("script");

			for (var i = 0; i < pushedDataSet; i++) {
				var localdata = data.splice(0,1);
				console.log(localdata);
				document.getElementById("charts").innerHTML += `<div class='radarChart${i}' style='border: 2px solid; margin: 5px;'></div>`;
				RadarChart(`.radarChart${i}`, localdata, radarChartOptions);
				//console.log(document.getElementsByClassName(`radarChart${i}`));
				//document.getElementsByClassName(`radarChart${i}`)[0].innerHTML += `<p><div class='SaveButton'><button id='saveButton${i}'>Telecharger en tant qu'Image PNG</button></div>`;

				//document.getElementsByClassName(`radarChart${i}`)[0].innerHTML += "<script>" + "d3.select(" + `#saveButton${i}` + ").on('click', function(){saveSvgAsPng(document.getElementById(" + `diagram.radarChart${i}` + "), 'diagram.png',{backgroundColor: '#FFFFFF'});});";
				
				//script.text = "d3.select(" + `#saveButton${i}` + ").on('click', function(){saveSvgAsPng(document.getElementById(" + `diagram.radarChart${i}` + "), 'diagram.png',{backgroundColor: '#FFFFFF'});});";
				// script.text += "document.getElementById(" + `#saveButton${i}` + ").addEventListener('click', function(event) {event.preventDefault();saveSvgAsPng(document.getElementById(" + `diagram.radarChart${i}` + "), 'diagram.png',{backgroundColor: '#FFFFFF'});});";
				// script.id = "scriptDL";
				// //document.body.appendChild(script);
				// console.log(document.querySelector('body'));
				// document.querySelector('body').appendChild(script);
			};
		}else if(document.querySelector('input[name="options"]:checked').value == "Super" && pushedDataSet > 0){
			document.getElementById("charts").innerHTML = "<div class='radarChart' style='border: 2px solid; margin: 5px;'></div>";
			RadarChart(".radarChart", data, radarChartOptions);
		}
    }



    TracerVisualisation();
</script>
