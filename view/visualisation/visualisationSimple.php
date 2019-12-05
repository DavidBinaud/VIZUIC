<?php
	echo "	<div>
				<select multiple='true' id='parametres' onchange='TracerVisualisation()'>";
	foreach ($tab_variables as $variable) {
		$nomParametre = $variable['nomVariable'];
		$valeurParametre = $variable['valeurVariable'];
		echo "<option value='$valeurParametre' selected>$nomParametre</option>";
	}	
	echo" 		</select>
			</div>";
	
?>

<div class="radarChart"></div>

<script src="radarChart.js"></script>


<script type="text/javascript">




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
        var options = getSelectedOptions(document.getElementById('parametres'));
        //document.getElementById("myText").innerHTML = options;
        




        var data = [[]];
        for (const element of options){
			//data[0].push("{axis:\"" + element.text + "\",value:" + element.value + "}");
			/*var test = [];
			test['axis'] = "initiative";
			test['value'] = 4;*/

			parametre = [];
			parametre['axis'] = element.text;
			parametre['value'] = element.value;

			data[0].push(parametre);
		}
		
		console.log(data);
		

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
	<button class='waves-effect waves-light btn' id='saveButton'>Telecharger en tant qu'Image PNG</button>
</div>

<!-- Prise en compte du bouton d'export-->
<script type="text/javascript">
	// Set-up the export button
	d3.select('#saveButton').on('click', function(){
		saveSvgAsPng(document.getElementById("diagram"), "diagram.png",{backgroundColor: "#FFFFFF"});
	});
</script>