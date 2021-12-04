<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
    <meta charset="utf-8" />
    <title>Pokemon Histogram</title>
    <style type="text/css">
          body {
            font-size: 16px;  
            margin: 20px 20px;
            }

          .bar:hover {
            fill: brown;
          }

          .axis--x path {
            display: none;
          }
          #bars {
              position: absolute;
              margin-top: 0.625em;
          }
          svg {
              position: absolute;
              margin-top: 1.875em;
          }

          select {
            margin-left: 3.750em;
          }

        /* Slider CSS */
            [slider] {
            position: relative;
            height: 0.875em;
            border-radius: 0.625em;
            text-align: left;
            margin: 2.813em 0em 0.625em 0em;
            }

            [slider] > div {
            position: absolute;
            left: 0.813em;
            right: 0.938em;
            height: 0.875em;
            }

            [slider] > div > [inverse-left] {
            position: absolute;
            left: 0em;
            height: 0.875em;
            border-radius: 0.625em;
            background-color: #CCC;
            margin: 0em 7px;
            }

            [slider] > div > [inverse-right] {
            position: absolute;
            right: 0;
            height: 0.875em;
            border-radius: 0.625em;
            background-color: #CCC;
            margin: 0em 0.438em;
            }

            [slider] > div > [range] {
            position: absolute;
            left: 0em;
            height: 0.875em;
            border-radius: 0.875em;
            background-color: #1ABC9C;
            }

            [slider] > div > [thumb] {
            position: absolute;
            top: -0.438em;
            z-index: 2;
            height: 1.750em;
            width: 1.750em;
            text-align: left;
            margin-left: -0.688em;
            cursor: pointer;
            box-shadow: 0em 0.188em 0.500em rgba(0, 0, 0, 0.4);
            background-color: #FFF;
            border-radius: 50%;
            outline: none;
            }

            [slider] > input[type=range] {
            position: absolute;
            pointer-events: none;
            -webkit-appearance: none;
            z-index: 3;
            height: 0.875em;
            top: -0.125em;
            width: 100%;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            filter: alpha(opacity=0);
            -moz-opacity: 0;
            -khtml-opacity: 0;
            opacity: 0;
            }

            div[slider] > input[type=range]::-ms-track {
            -webkit-appearance: none;
            background: transparent;
            color: transparent;
            }

            div[slider] > input[type=range]::-moz-range-track {
            -moz-appearance: none;
            background: transparent;
            color: transparent;
            }

            div[slider] > input[type=range]:focus::-webkit-slider-runnable-track {
            background: transparent;
            border: transparent;
            }

            div[slider] > input[type=range]:focus {
            outline: none;
            }

            div[slider] > input[type=range]::-ms-thumb {
            pointer-events: all;
            width: 1.750em;
            height: 1.750em;
            border-radius: 0em;
            border: 0em none;
            background: red;
            }

            div[slider] > input[type=range]::-moz-range-thumb {
            pointer-events: all;
            width: 1.750em;
            height: 1.750em;
            border-radius: 0em;
            border: 0em none;
            background: red;
            }

            div[slider] > input[type=range]::-webkit-slider-thumb {
            pointer-events: all;
            width: 1.750em;
            height: 1.750em;
            border-radius: 0em;
            border: 0em none;
            background: red;
            -webkit-appearance: none;
            }

            div[slider] > input[type=range]::-ms-fill-lower {
            background: transparent;
            border: 0em none;
            }

            div[slider] > input[type=range]::-ms-fill-upper {
            background: transparent;
            border: 0em none;
            }

            div[slider] > input[type=range]::-ms-tooltip {
            display: none;
            }

            [slider] > div > [sign] {
            opacity: 0;
            position: absolute;
            margin-left: -0.688em;
            top: -2.438em;
            z-index:3;
            background-color: #1ABC9C;
            color: #fff;
            width: 1.750em;
            height: 1.750em;
            border-radius: 1.750em;
            -webkit-border-radius: 1.750em;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
            text-align: center;
            }

            [slider] > div > [sign]:after {
            position: absolute;
            content: '';
            left: 0em;
            border-radius: 1em;
            top: 1.188em;
            border-left: 0.875em solid transparent;
            border-right: 0.875em solid transparent;
            border-top-width: 1em;
            border-top-style: solid;
            border-top-color: #1ABC9C;
            }

            [slider] > div > [sign] > span {
            font-size: 0.750em;
            font-weight: 700;
            line-height: 1.750em;
            }

            [slider]:hover > div > [sign] {
            opacity: 1;
            }
        /* Slider CSS */

        .buttons{
          display: inline-block;
        }
    </style>
</head>

<body>
<?php
    $servername = "va.tech.purdue.edu";
    $username = "cgt2021f";
    $password = "cgtdatavis";
    $dbname = "cgt2021f";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats";


    if($_REQUEST["dex_Order"]){
      $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats ORDER BY Data_ID";
    }

    if($_REQUEST["type_Order"]){
      $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats ORDER BY Pokemon_Type ASC";
    }

    if($_REQUEST["CP_Order"]){
      $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats ORDER BY Max_CP ASC";
    }


    // echo ($sql);
    // // exit();
    $result = $conn->query($sql);

    while($row = mysqli_fetch_assoc($result))
    $transfer[] = $row; 
    $json_array = json_encode($transfer);
    
  ?>
<!-- Create a div where the graph will take place -->
  <!-- slider code -->
  <div slider id="slider-distance">
    <div>
      <div inverse-left style="width:100%;"></div>
      <div inverse-right style="width:100%;"></div>
      <div range style="left:0%;right:0%;"></div>
      <span thumb style="left:0%;"></span>
      <span thumb style="left:100%;"></span>
      <div sign style="left:0%;">
        <span id="value">0</span>
      </div>
      <div sign style="left:100%;">
        <span id="value">5000</span>
      </div>
    </div>
    <input type="range" tabindex="0" value="0" max="5000" min="0" step="1" oninput="
    this.value=Math.min(this.value,this.parentNode.childNodes[5].value-1);
    value = (value/5000) * 100;
    var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
    var children = this.parentNode.childNodes[1].childNodes;
    children[1].style.width=value+'%';
    children[5].style.left=value+'%';
    children[7].style.left=value+'%';children[11].style.left=value+'%';
    children[11].childNodes[1].innerHTML=this.value;
    
    // use this variable for all queries involving the slider's Min
    var CPMin = (value/100) * 5000;" />
  
    <input type="range" tabindex="0" value="5000" max="5000" min="0" step="1" oninput="
    this.value=Math.max(this.value,this.parentNode.childNodes[3].value-(-1));
    value = (value/5000) * 100;
    var value=(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.value)-(100/(parseInt(this.max)-parseInt(this.min)))*parseInt(this.min);
    var children = this.parentNode.childNodes[1].childNodes;
    children[3].style.width=(100-value)+'%';
    children[5].style.right=(100-value)+'%';
    children[9].style.left=value+'%';children[13].style.left=value+'%';
    children[13].childNodes[1].innerHTML=this.value;
    
    // use this variable for all queries involving the slider's Max
    var CPMax = (value/100) * 5000;" />
  </div> 
<!-- slider code end -->
<div id="bars">
    <form class="buttons" id="dex_Order" method="post" action="histogram.php">
      <input name="dex_Order" type="submit" value="Pokemon ID">
    </form>

    <form class="buttons" id="type_Order" method="post" action="histogram.php">
      <input name="type_Order" type="submit" value="Type">
    </form>

    <form class="buttons" id="CP_Order" method="post" action="histogram.php">
        <input name="CP_Order" type="submit" value="Max CP">
    </form>
</div>
<svg id="SVGdiv" width="960" height="440"></svg>

<script src="https://d3js.org/d3.v4.js"></script>
<script src="js/jquery-3.6.0.min.js"></script>

<script>
    var data= <?php echo $json_array; ?>;
    // console.log(data);

    function cleanType(x){
      var tempType = x.Pokemon_Type.split(', ');
      var tempTypeFinal = tempType[0].replace("[","").replace("'","").replace("'","").replace("]","");
      return tempTypeFinal;
    }

    // histogram code 

      //determines bar color based on primary type
      function typeColor(x){
        if (x =='Normal'){
          return '#A8A77A'
        }
        else if (x == 'Fire'){
          return '#EE8130'
        }
        else if (x == 'Water'){
          return '#6390F0'
        }
        else if (x == 'Electric'){
          return '#F7D02C'
        }
        else if (x == 'Grass'){
          return '#7AC74C'
        }
        else if (x == 'Ice'){
          return '#96D9D6'
        }
        else if (x == 'Fighting'){
          return '#C22E28'
        }
        else if (x == 'Poison'){
          return '#A33EA1'
        }
        else if (x == 'Ground'){
          return '#E2BF65'
        }
        else if (x == 'Flying'){
          return '#A98FF3'
        }
        else if (x == 'Psychic'){
          return '#F95587'
        }
        else if (x == 'Bug'){
          return '#A6B91A'
        }
        else if (x == 'Rock'){
          return '#B6A136'
        }
        else if (x == 'Ghost'){
          return '#735797'
        }
        else if (x == 'Dragon'){
          return '#6F35FC'
        }
        else if (x == 'Dark'){
          return '#705746'
        }
        else if (x == 'Steel'){
          return '#B7B7CE'
        }
        else if (x == 'Fairy'){
          return '#D685AD'
        }
        else{
          return '#000'
        }
      };
      
      $(document).ready(function(event){

          var svg = d3.select("#SVGdiv"),
              margin = {top: 20, right: 20, bottom: 30, left: 40},
              width = +svg.attr("width") - margin.left - margin.right,
              height = +svg.attr("height") - margin.top - margin.bottom;

          var x = d3.scaleLinear();
              y = d3.scaleLinear().rangeRound([height, 0]);

          var g = svg.append("g")
              .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
          
          // set the domains of the axes
          x.domain(0,data.length);
          y.domain([0, 5000]);

          // add the svg elements
          g.append("g")
              .attr("class", "axis axis--x")
              .attr("transform", "translate(0," + height + ")")
              .call(d3.axisBottom(x));

          g.append("g")
              .attr("class", "axis axis--y")
              .call(d3.axisLeft(y).ticks(10))
            .append("text")
              .attr("transform", "rotate(-90)")
              .attr("y", 6)
              .attr("dy", "0.71em")
              .attr("text-anchor", "end")
              .text("Max CP");
              
            var listLen =[];
            
            function data_index(temp){
              listLen.push(temp);
              var tempNum = listLen.length;
              var xpos = (width/data.length) * tempNum;
              return xpos;
            }

          g.selectAll(".bar")
            .data(data)
            .enter().append("rect")
              .attr("class", "bar")
              .attr("x", function(d) { return data_index(d.Max_CP); })
              .attr("y", function(d) { return y(d.Max_CP); })
              .attr("width", width/data.length)
              .attr("height", function(d) { return height - y(d.Max_CP); })
              .attr("fill", function(d){ return typeColor(cleanType(d))});


      });
                  
    </script>  

    </body>
</html>