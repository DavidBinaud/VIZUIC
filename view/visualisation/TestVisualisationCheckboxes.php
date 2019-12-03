<?php
	echo "	<div id='parametres' style='border: 1px solid; padding:10px;'>";
				
	foreach ($tab_variables as $variable) {
		$nomParametre = $variable['nomVariable'];
		$valeurParametre = $variable['valeurVariable'];
		echo "<label for='$nomParametre'>$nomParametre</label>
		<input type='checkbox' value='$valeurParametre' class='parametres' id=$nomParametre checked>";
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



	function getSelectedOptions(sel) {
        var opts = [], opt;
        
        // loop through options in select list
        for (var i=0, len=sel.options.length; i<len; i++) {
            opt = sel.options[i];
            
            // check if selected
            if ( opt.selected ) {
                // add to array of option elements to return from this function
                opts.push(opt);
                
                // invoke optional callback function if provided
            }
        }
        
        // return array containing references to selected option elements
        return opts;
    }



    //document.getElementById('parametres').onchange = function (e) {
    function TracerVisualisation() {

        
        // callback fn handles selected options
        //var parametres = getSelectedOptions(document.getElementById('parametres'));
        //document.getElementById("myText").innerHTML = options;
        var div = document.getElementById('parametres');
        var Parametres =  div.getElementsByClassName("parametres")
        var Nbparametres =  div.getElementsByClassName("parametres").length
       	//console.log(Parametres[0].value);
        console.log(Nbparametres);

        var data = [[]];
        for (var i = 0; i < Nbparametres; i++) {
        	if(Parametres[i].checked){
        		parametres = [];
        		parametres['axis'] = Parametres[i].id;
        		parametres['value'] = Parametres[i].value;
        		data[0].push(parametres);
        	}
        }



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
				.range(["#EDC951","#CC333F","#00A0B0"]);
				
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