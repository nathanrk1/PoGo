<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
    <meta charset="utf-8" />
    <title>Pokemon Histogram</title>
    <style type="text/css">

          .bar:hover {
            fill: brown;
          }

          .axis--x path {
            display: none;
          }

          svg {
              position: absolute;
            margin-top: 40px;
          }

          select {
            margin-left: 60px;
          }

        body {
            margin: 100px 50px;
            }

        #slider-distance{
          transform:scale(1);
        }

        /* Slider CSS */
            [slider] {
            position: relative;
            height: 14px;
            border-radius: 10px;
            text-align: left;
            margin: 45px 0 10px 0;
            }

            [slider] > div {
            position: absolute;
            left: 13px;
            right: 15px;
            height: 14px;
            }

            [slider] > div > [inverse-left] {
            position: absolute;
            left: 0;
            height: 14px;
            border-radius: 10px;
            background-color: #CCC;
            margin: 0 7px;
            }

            [slider] > div > [inverse-right] {
            position: absolute;
            right: 0;
            height: 14px;
            border-radius: 10px;
            background-color: #CCC;
            margin: 0 7px;
            }

            [slider] > div > [range] {
            position: absolute;
            left: 0;
            height: 14px;
            border-radius: 14px;
            background-color: #1ABC9C;
            }

            [slider] > div > [thumb] {
            position: absolute;
            top: -7px;
            z-index: 2;
            height: 28px;
            width: 28px;
            text-align: left;
            margin-left: -11px;
            cursor: pointer;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.4);
            background-color: #FFF;
            border-radius: 50%;
            outline: none;
            }

            [slider] > input[type=range] {
            position: absolute;
            pointer-events: none;
            -webkit-appearance: none;
            z-index: 3;
            height: 14px;
            top: -2px;
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
            width: 28px;
            height: 28px;
            border-radius: 0px;
            border: 0 none;
            background: red;
            }

            div[slider] > input[type=range]::-moz-range-thumb {
            pointer-events: all;
            width: 28px;
            height: 28px;
            border-radius: 0px;
            border: 0 none;
            background: red;
            }

            div[slider] > input[type=range]::-webkit-slider-thumb {
            pointer-events: all;
            width: 28px;
            height: 28px;
            border-radius: 0px;
            border: 0 none;
            background: red;
            -webkit-appearance: none;
            }

            div[slider] > input[type=range]::-ms-fill-lower {
            background: transparent;
            border: 0 none;
            }

            div[slider] > input[type=range]::-ms-fill-upper {
            background: transparent;
            border: 0 none;
            }

            div[slider] > input[type=range]::-ms-tooltip {
            display: none;
            }

            [slider] > div > [sign] {
            opacity: 0;
            position: absolute;
            margin-left: -11px;
            top: -39px;
            z-index:3;
            background-color: #1ABC9C;
            color: #fff;
            width: 28px;
            height: 28px;
            border-radius: 28px;
            -webkit-border-radius: 28px;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
            text-align: center;
            }

            [slider] > div > [sign]:after {
            position: absolute;
            content: '';
            left: 0;
            border-radius: 16px;
            top: 19px;
            border-left: 14px solid transparent;
            border-right: 14px solid transparent;
            border-top-width: 16px;
            border-top-style: solid;
            border-top-color: #1ABC9C;
            }

            [slider] > div > [sign] > span {
            font-size: 12px;
            font-weight: 700;
            line-height: 28px;
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
      $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats ORDER BY Pokemon_Type";
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

  <select id="filter">
    <option value="1">1</option>
    <option value="2">2</option>
  </select>
  <svg width="960" height="600"></svg>

  <!-- slider code -->
  <!-- <div slider id="slider-distance">
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
  </div>  -->
<!-- slider code end -->

<script src="https://d3js.org/d3.v4.js"></script>
<script src="js/jquery-3.6.0.min.js"></script>

<script>
    var data= <?php echo $json_array; ?>;
    // console.log(data);

    function cleanType(x){
      var tempType = data[x].Pokemon_Type.split(', ');
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
      
          var svg = d3.select("svg"),
              margin = {top: 20, right: 20, bottom: 30, left: 40},
              width = +svg.attr("width") - margin.left - margin.right,
              height = +svg.attr("height") - margin.top - margin.bottom;

          var x = d3.scaleLinear();
              y = d3.scaleLinear().rangeRound([height, 0]);

          var g = svg.append("g")
              .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

          // create a variable that will hold the loaded data
          var datahold;

          
          
          // put the original data in tsv
          datahold = data;

          
          
          // set the domains of the axes
          x.domain(data.map(function(d) { return d.Data_ID; }));
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
          
          // create the bars
          g.selectAll(".bar")
            .data(data)
            .enter().append("rect")
              .attr("class", "bar")
              .attr("x", function(d) { return x(d.Data_ID); })
              .attr("y", function(d) { return y(d.Max_CP); })
              .attr("width", width/data.length)
              .attr("height", function(d) { return height - y(d.Max_CP); })
              .attr("fill", function(d){ return typeColor(cleanType(d.Data_ID - 1))});

          // add a change event handler 
          d3.select("#filter").on("change", function() {
              applyFilter(this.value);
            });

          // call this whenever the filter changes
          function applyFilter(value) {
            // filter the data
            var data = datahold.filter(function(d) {return d.group === value;})

            // update the bars
            d3.selectAll(".bar")
              .data(data)
              .transition().duration(1000)
              .attr("x", function(d) { return x(d.Data_ID); })
              .attr("y", function(d) { return y(d.Max_CP); })
              .attr("height", function(d) { return height - y(d.Max_CP); });
          }
   
    </script>

    <script >
    $(document).ready(function(event){
      $('#CP_Order').on('submit', function () {

        
      });
    });
  </script>
    </body>
</html>