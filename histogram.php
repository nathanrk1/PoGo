<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
    <meta charset="utf-8" />
    <title>Pokemon Histogram</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
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
          
          .histofilter {
              position: absolute;
              margin-top: 27em;
          }

          .apply_filter {
              position: absolute;
              top: 1.45em;
              margin-left:11.5em;
          }

          svg {
              position: absolute;
              margin-top: 0.925em;
          }

          select {
            margin-left: 3.750em;
          }

        .buttons{
          display: inline-block;
        }
    </style>
</head>

<body>
<?php
    session_start();

    $servername = "va.tech.purdue.edu";
    $username = "cgt2021f";
    $password = "cgtdatavis";
    $dbname = "cgt2021f";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    //baseline input
    $_SESSION['MinCP'] = 0;
    $_SESSION['MaxCP'] = 5000;
    // $_SESSION['Type1'] = '- Type1 -';
    // $_SESSION['Type2'] = '- Type2 -';

    $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats";

    //switch to dex sort
    if($_REQUEST["dex_Order"]){
      $_SESSION['Sort'] = "ID";
      $_REQUEST["apply_filter"];
    }//end dex sort

    //switch to type sort
    if($_REQUEST["type_Order"]){
      $_SESSION['Sort'] = "Type";
      $_REQUEST["apply_filter"];
    }//end type sort

    //switch to cp sort
    if($_REQUEST["CP_Order"]){
      $_SESSION['Sort'] = "CP";
      $_REQUEST["apply_filter"];
    }//end CP Sort

    // Apply filter
    if($_REQUEST["apply_filter"]){
        $_SESSION['MinCP'] = $_POST["CPMin"];
        $_SESSION['MaxCP'] = $_POST["CPMax"];
        $_SESSION['Type1'] = $_POST["Type1"];
        $_SESSION['Type2'] = $_POST["Type2"];
        
        //normal filter
        if ($_SESSION['Type1'] == "- Type 1 -" & $_SESSION['Type2'] == "- Type 2 -"){
          //for id sort
          if($_SESSION['Sort'] == "ID"){
            $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
          }

          //for type sort
          if($_SESSION['Sort'] == "Type"){
            $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
          }

          //for CP sort
          if($_SESSION['Sort'] == "CP"){
            $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
          }

      }//end normal filter 

      //only Type 1
      if ($_SESSION['Type1'] != "- Type 1 -" & $_SESSION['Type2'] == "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end only Type1 filter 

      //only Type 2
      if ($_SESSION['Type1'] == "- Type 1 -" & $_SESSION['Type2'] != "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end only Type 2 filter 

      //Both Types
      if ($_SESSION['Type1'] != "- Type 1 -" & $_SESSION['Type2'] != "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end Both Types filter 

    }//end Request



    $result = $conn->query($sql);

    while($row = mysqli_fetch_assoc($result))
    $transfer[] = $row; 
    $json_array = json_encode($transfer);
    
  ?>

  <script src="https://d3js.org/d3.v4.js"></script>
  <script src="js/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script> 

  <script>
    var CPMin = 0;
    var CPMax = 5000;
    var tempmin = <?php echo  $_SESSION['MinCP']; ?>;
    var tempmax = <?php echo  $_SESSION['MaxCP']; ?>;
    
    if(tempmin != 0){
      var CPMin = <?php echo  $_SESSION['MinCP']; ?>;
    }
    
    if(tempmax != 5000){
      var CPMax = <?php echo  $_SESSION['MaxCP']; ?>;
    }
    
    $( function() {
      $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 5000,
        values: [ CPMin, CPMax ],
        slide: function( event, ui ) {
          $( "#amount" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
          
          CPMin = ui.values[0];
          CPMax = ui.values[1];
        }
      });
      $( "#amount" ).val($( "#slider-range" ).slider( "values", 0 ) +
        " - " + $( "#slider-range" ).slider( "values", 1 ) );
    });
    
    function giveMin(){
      return CPMin;
    }

    function giveMax(){
      return CPMax;
    }

    function passnum(){ 
      document.getElementById("CPMin").value = giveMin();
      document.getElementById("CPMax").value = giveMax();
      }

    function select1(x) {

      var option1 = x + "1";
      
      if (option1 == "- Type1 -1"){
        option1 = "type1base";
      }

      var element = document.getElementById(option1);
      element.value = selectedIndex;
    }

    function select2(x) {
      
      var option2 = x + "2";
      
      if (option2 == "- Type2 -2"){
       option2 = "type2base";
      }

      var element = document.getElementById(option2);
      element.value = selectedIndex;
    }

    function callfunctions(){
      passnum();
      select1('<?php echo  $_SESSION['Type1']; ?>');
      select2('<?php echo  $_SESSION['Type2']; ?>');
    }
  </script>
  

  </div> 
  
<!-- slider code end -->
<p>
  <label for="amount">CP Range:</label>
  <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
</p>
 
<div id="slider-range"></div>
<svg id="SVGdiv" width="960" height="440"></svg>
<div id="bars">
<form class="buttons" id="apply_filter" method="post" action="histogram.php">
      <input onclick="callfunctions();" class="apply_filter" name="apply_filter" type="submit" value="Apply"/>
      <div class="histofilter">
        <input onclick="callfunctions();" name="dex_Order" type="submit" value="Pokemon ID">
        <input onclick="callfunctions();" name="type_Order" type="submit" value="Type">
        <input onclick="callfunctions();" name="CP_Order" type="submit" value="Max CP">
      </div>
        <select name="Type1" id="Type1">
            <option id="type1base"  value="- Type 1 -">- Type 1 -</option>
            <option id="Normal1"    value="Normal">Normal</option>
            <option id="Fire1"      value="Fire">Fire</option>
            <option id="Water1"     value="Water">Water</option>
            <option id="Electric1"  value="Electric">Electric</option>
            <option id="Grass1"     value="Grass">Grass</option>
            <option id="Ice1"       value="Ice">Ice</option>
            <option id="Fighting1"  value="Fighting">Fighting</option>
            <option id="Poison1"    value="Poison">Poison</option>
            <option id="Ground1"    value="Ground">Ground</option>
            <option id="Flying1"    value="Flying">Flying</option>
            <option id="Psychic1"   value="Psychic">Psychic</option>
            <option id="Bug1"       value="Bug">Bug</option>
            <option id="Rock1"      value="Rock">Rock</option>
            <option id="Ghost1"     value="Ghost">Ghost</option>
            <option id="Dragon1"    value="Dragon">Dragon</option>
            <option id="Dark1"      value="Dark">Dark</option>
            <option id="Steel1"     value="Steel">Steel</option>
            <option id="Fairy1"     value="Fairy">Fairy</option>
        </select>

        <select name="Type2" id="Type2">
        <option id="type2base"  value="- Type 2 -">- Type 2 -</option>
            <option id="Normal2"    value="Normal">Normal</option>
            <option id="Fire2"      value="Fire">Fire</option>
            <option id="Water2"     value="Water">Water</option>
            <option id="Electric2"  value="Electric">Electric</option>
            <option id="Grass2"     value="Grass">Grass</option>
            <option id="Ice2"       value="Ice">Ice</option>
            <option id="Fighting2"  value="Fighting">Fighting</option>
            <option id="Poison2"    value="Poison">Poison</option>
            <option id="Ground2"    value="Ground">Ground</option>
            <option id="Flying2"    value="Flying">Flying</option>
            <option id="Psychic2"   value="Psychic">Psychic</option>
            <option id="Bug2"       value="Bug">Bug</option>
            <option id="Rock2"      value="Rock">Rock</option>
            <option id="Ghost2"     value="Ghost">Ghost</option>
            <option id="Dragon2"    value="Dragon">Dragon</option>
            <option id="Dark2"      value="Dark">Dark</option>
            <option id="Steel2"     value="Steel">Steel</option>
            <option id="Fairy2"     value="Fairy">Fairy</option>
        </select>
      <input type="hidden" id="CPMin" name="CPMin"/>
      <input type="hidden" id="CPMax" name="CPMax"/>
  </form>

</div>

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
