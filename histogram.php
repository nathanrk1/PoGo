<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
    <meta charset="utf-8" />
    <title>Pokemon Histogram</title>

    <script src="https://d3js.org/d3.v4.js"></script>

    <style type="text/css">
        body {
            margin: 100px 50px;
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
    $sql = "SELECT Form, Pokemon_ID, Pokemon_Name, Max_CP FROM PokemonGOMaxCP";
    // echo ($sql);
    // // exit();
    $result = $conn->query($sql);

    while($row = mysqli_fetch_assoc($result))
    $transfer[] = $row; 
    $json_array = json_encode($transfer);
  ?>
<!-- Create a div where the graph will take place -->
<div id="my_dataviz">
    
  </div>
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

<script>
    var data= <?php echo $json_array; ?>;
    var entryCNT = data.length;
    // histogram code 

    // set the dimensions and margins of the graph
    
    var margin = {top: 10, right: 30, bottom: 30, left: 40},
        width = 1100 - margin.left - margin.right,
        height = 400 - margin.top - margin.bottom;
    
    // append the svg object to the body of the page
    var svg = d3.select("#my_dataviz")
      .append("svg")
        .attr("width", width + margin.left + margin.right)
        .attr("height", height + margin.top + margin.bottom)
      .append("g")
        .attr("transform",
              "translate(" + margin.left + "," + margin.top + ")");
      // X axis: scale and draw:
      var x = d3.scaleLinear()
          .domain([0, d3.max(data, function(d) { return +d.Pokemon_ID })])    // can use this instead of 1000 to have the max of data: d3.max(data, function(d) { return +d.price })
          .range([0, width]);
      svg.append("g")
          .attr("transform", "translate(0," + height + ")")
          .call(d3.axisBottom(x));
      // set the parameters for the histogram
      var histogram = d3.histogram()
          .value(function(d) { return d.Pokemon_ID })   // I need to give the vector of value
          .domain(x.domain())  // then the domain of the graphic
          .thresholds(x.ticks(entryCNT)) // then the numbers of bins
    
      // And apply this function to data to get the bins
      var bins = histogram(data);
     
      // Y axis: scale and draw:
      var y = d3.scaleLinear()
          .range([height, 0])
          .domain([0, d3.max(bins, function(d) { return d.Max_CP; })]);   // d3.hist has to be called before the Y axis obviously
      svg.append("g")
          .call(d3.axisLeft(y));
    
      // append the bar rectangles to the svg element
      svg.selectAll("rect")
          .data(bins)
          .enter()
          .append("rect")
            .attr("x", 1)
            .attr("transform", function(d) { return "translate(" + x(d.x0) + "," + y(d.Max_CP) + ")"; })
            .attr("width", function(d) { return x(d.x1) - x(d.x0) -1 ; })
            .attr("height", function(d) { return height - y(d.Max_CP); })
            .style("fill", "#69b3a2");
    
    // end histogram code

    </script>
    </body>
</html>