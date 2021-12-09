<?php
session_start();
if(empty($_SESSION["errorMessage"]))
    $_SESSION["errorMessage"] = "";

include("phpConnect.php")
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Pokemon Kanto Select</title>
    <style type="text/css">
    body {
      font-size: 16px;
    }

    .rect{
      width:100%;
    }
    .rec{
      position: absolute;
      text-align: center;
    }

    /* Button CSS */
    .glitch,
    .glitch:after {
      width: 9.375em;
      height: 4.750em;
      line-height: 4.875em;
      font-family: 'Bebas Neue', sans-serif;
      background: linear-gradient(45deg, transparent 5%, #FF013C 5%);
      border: 0;
      color: #fff;
      letter-spacing: 0.188em;
      box-shadow: 0.375em 0em 0em #00E6F6;
      outline: transparent;
      position: relative;
      user-select: none;
      -webkit-user-select: none;
      touch-action: manipulation;
    }

    .glitch:after {
      --slice-0: inset(50% 50% 50% 50%);
      --slice-1: inset(80% -0.375em 0 0);
      --slice-2: inset(50% -0.375em 30% 0);
      --slice-3: inset(10% -0.375em 85% 0);
      --slice-4: inset(40% -0.375em 43% 0);
      --slice-5: inset(80% -0.375em 5% 0);
      
      content: 'Pokemon';
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(45deg, transparent 3%, #00E6F6 3%, #00E6F6 5%, #FF013C 5%);
      text-shadow: -0.188em -0.188em 0em #F8F005, 0.188em 0.188em 0em #00E6F6;
      clip-path: var(--slice-0);
    }

    .glitch:hover:after {
      animation: 1s glitch;
      animation-timing-function: steps(2, end);
    }

    @keyframes glitch {
      0% {
        clip-path: var(--slice-1);
        transform: translate(-1.250em, -0.625em);
      }
      10% {
        clip-path: var(--slice-3);
        transform: translate(0.625em, 0.625em);
      }
      20% {
        clip-path: var(--slice-1);
        transform: translate(-0.625em, 0.625em);
      }
      30% {
        clip-path: var(--slice-3);
        transform: translate(0em, 0.313em);
      }
      40% {
        clip-path: var(--slice-2);
        transform: translate(-0.313em, 0em);
      }
      50% {
        clip-path: var(--slice-3);
        transform: translate(0.313em, 0em);
      }
      60% {
        clip-path: var(--slice-4);
        transform: translate(0.313em, 0.625em);
      }
      70% {
        clip-path: var(--slice-2);
        transform: translate(-0.625em, 0.625em);
      }
      80% {
        clip-path: var(--slice-5);
        transform: translate(1.250em, -0.625em);
      }
      90% {
        clip-path: var(--slice-1);
        transform: translate(-0.625em, 0em);
      }
      100% {
        clip-path: var(--slice-1);
        transform: translate(0);
      }
    }

    @media (min-width: 768px) {
      .glitch,
      .glitch:after {
        width: 10em;
        height: 5.375em;
        line-height: 5.500em;
      }
    }
    /* End Button CSS */
  

    /* Nav Bar */
    ul   { list-style-type: none; margin: 0em; padding: 0em; overflow: hidden; background-color: #426b67; border-bottom: 5px solid #375855;}
    li   { float: left; }
    li a { display: block;  color: white; text-align: center; padding: 0.875em 1em; text-decoration:none; font-size: 1.875em; }
    li a:hover:not(#home) { background-color: #375855; }
    .spacer { height: 25px; }

    /* General */
   /* html { background: #426b67; } */
    body{ font-size: 16px; font-family: Arial, Helvetica, sans-serif; margin: 0; }
    #text{ color: white; position: absolute; top: 16.875em; left: 3.125em; }

    </style>
</head>
<body>
  <ul>
      <li><a id="home" href="index.html"><img src="images/aipomoutline.png" height="45em"/></a></li>
      <li><a href="Pokedex.php">Pokedex</a></li>
      <li><a href="summary.php">Dashboard</a></li>
  </ul>

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
    $sql = "SELECT Form, Pokemon_ID, Pokemon_Name, 'Max_CP' FROM PokemonGOStats";
    // echo ($sql);
    // // exit();
    $result = $conn->query($sql);

    while($row = mysqli_fetch_assoc($result))
    $transfer[] = $row; 
    $json_array = json_encode($transfer);
  ?>
  <div class="spacer"></div>
  <div id="dex" class="rect" width = "100%" height = 100%; >
     <div id="buttons">
        <button id="b_all" class="glitch" role="button">All Pokemon</button>
        <button id="b_kanto" class="glitch" role="button">Kanto</button>
        <button id="b_johto" class="glitch" role="button">Johto</button>
        <button id="b_hoenn" class="glitch" role="button">Hoenn</button>
        <button id="b_sinnoh" class="glitch" role="button">Sinnoh</button>
        <button id="b_unova" class="glitch" role="button">Unova</button>
        <button id="b_kalos" class="glitch" role="button">Kalos</button>
        <button id="b_runknown" class="glitch" role="button">Unknown</button>
        <button id="b_galar" class="glitch" role="button">Galar</button>
      </div>
  </div>
  
      
  <script src="https://d3js.org/d3.v7.min.js"></script>
  <script src="js/jquery-3.6.0.min.js"></script>
  <script>
      $(document).ready(function(event){

          $('#b_all').click(function() {
                $('#kanto').remove();
                $('#johto').remove();
                $('#hoenn').remove();
                $('#sinnoh').remove();
                $('#unova').remove();
                $('#kalos').remove();
                $('#runknown').remove();
                $('#galar').remove();

                //disabling button function. and reenabling all other buttons
                document.getElementById("b_all").disabled = true;
                document.getElementById("b_kanto").disabled = false;
                document.getElementById("b_johto").disabled = false;
                document.getElementById("b_hoenn").disabled = false;
                document.getElementById("b_sinnoh").disabled = false;
                document.getElementById("b_unova").disabled = false;
                document.getElementById("b_kalos").disabled = false;
                document.getElementById("b_runknown").disabled = false;
                document.getElementById("b_galar").disabled = false;
              
            //all
            var height = "822em";
            var width = "100%";
            var svg = d3.select("#dex").append("svg").attr("id","all").attr("width", width).attr("height", height);
            var count = 0;
            // Add the path using this helper function
              for (let i = 0; i <= 100; i++) {
                for (let j = 0; j < 9; j++) {  
                
                if (count >= 908) { break; }
                
                //x-position
                var x = 10;
                x = x + (130*j);
                var xMeas = (x/16) + "em";

                //y-position
                var y = 10;
                y = y + (130*i);
                var yMeas = (y/16) + "em";

                //drawing the squares
                svg.append('rect')
                  .attr('x', xMeas)
                  .attr('y', yMeas)
                  .attr('class', altFormlower(count))
                  .attr('class',"all")
                  .attr('width', (115/16) + "em")
                  .attr('height',(115/16) + "em")
                  .attr('stroke', '#375855')
                  .attr('fill', '#5d938e')
                  .attr("rx", 10)
                  .attr("ry", 10)
                  .attr("class", "rec");

                var xID = 55;
                xID = xID + (130*j);
                var xMeasID = (xID/16) + "em";

                //y-position
                var yID = 35;
                yID = yID + (130*i);
                var yMeasID = (yID/16) + "em";
                
                svg.append('text')
                  .attr('x', xMeasID)
                  .attr('y', yMeasID)
                  .attr('class',"all")
                  .attr('font-size', "12pt")
                  .attr('stroke', 'black')
                  .text(data[count].Pokemon_ID);


                var xName = 30;
                xName = xName + (130*j);
                var xMeasName = (xName/16) + "em";

                //y-position
                var yName = 115;
                yName = yName + (130*i);
                var yMeasName = (yName/16) + "em";
                
                  svg.append('text')
                    .attr('x', xMeasName)
                    .attr('y', yMeasName)
                    .attr('class',"all")
                    .attr('font-size', "12pt")
                    .attr('stroke', 'black')
                    .text(altForm(count));

                var xSprite = 30;
                xSprite = xSprite + (130*j);
                var xMeasSprite = (xName/16) + "em";

                //y-position
                var ySprite = 35;
                ySprite = ySprite + (130*i);
                var yMeasSprite = (ySprite/16) + "em";
                    
                svg.append('image')
                  .attr('x', xMeasSprite)
                  .attr('y', yMeasSprite)
                  .attr('class',"all")
                  .attr('font-size', "12pt")
                  .attr('stroke', 'black')
                  .attr('href','sprites/' + altFormlower(count) + '.png');
                    

              count++; 
                  if (x + (130 * j)==1610) { x= 10; }
              }
              
            }
          
          });//end all

          $('#b_kanto').click(function() {
                $('#all').remove();
                $('#johto').remove();
                $('#hoenn').remove();
                $('#sinnoh').remove();
                $('#unova').remove();
                $('#kalos').remove();
                $('#runknown').remove();
                $('#galar').remove();

                //disabling button function. and reenabling all other buttons
                document.getElementById("b_all").disabled = false;
                document.getElementById("b_kanto").disabled = true;
                document.getElementById("b_johto").disabled = false;
                document.getElementById("b_hoenn").disabled = false;
                document.getElementById("b_sinnoh").disabled = false;
                document.getElementById("b_unova").disabled = false;
                document.getElementById("b_kalos").disabled = false;
                document.getElementById("b_runknown").disabled = false;
                document.getElementById("b_galar").disabled = false;

            //kanto
            var height = "163em";
            var svg = d3.select("#dex").append("svg").attr("id","kanto").attr("width", width).attr("height", height);
            var count = 0;
            // Add the path using this helper function
              for (let i = 0; i <= 20; i++) {
                for (let j = 0; j < 9; j++) {  
                
                if (count >= 178) { break; }
                
                //x-position
                var x = 10;
                x = x + (130*j);
                var xMeas = (x/16) + "em";

                //y-position
                var y = 10;
                y = y + (130*i);
                var yMeas = (y/16) + "em";

                //drawing the squares
                svg.append('rect')
                  .attr('x', xMeas)
                  .attr('y', yMeas)
                  .attr('class', altFormlower(count))
                  .attr('class',"kanto")
                  .attr('width', (115/16) + "em")
                  .attr('height',(115/16) + "em")
                  .attr('stroke', '#375855')
                  .attr('fill', '#5d938e')
                  .attr("class", "rec")
                  .attr("rx",10)
                  .attr("ry",10);

                var xID = 55;
                xID = xID + (130*j);
                var xMeasID = (xID/16) + "em";

                //y-position
                var yID = 35;
                yID = yID + (130*i);
                var yMeasID = (yID/16) + "em";
                
                svg.append('text')
                  .attr('x', xMeasID)
                  .attr('y', yMeasID)
                  .attr('class',"kanto")
                  .attr('font-size', "12pt")
                  .attr('stroke', 'black')
                  .text(data[count].Pokemon_ID);


                var xName = 30;
                xName = xName + (130*j);
                var xMeasName = (xName/16) + "em";

                //y-position
                var yName = 115;
                yName = yName + (130*i);
                var yMeasName = (yName/16) + "em";
                
                  svg.append('text')
                    .attr('x', xMeasName)
                    .attr('y', yMeasName)
                    .attr('class',"kanto")
                    .attr('font-size', "12pt")
                    .attr('stroke', 'black')
                    .text(altForm(count));

                var xSprite = 30;
                xSprite = xSprite + (130*j);
                var xMeasSprite = (xName/16) + "em";

                //y-position
                var ySprite = 35;
                ySprite = ySprite + (130*i);
                var yMeasSprite = (ySprite/16) + "em";
                    
                svg.append('image')
                  .attr('x', xMeasSprite)
                  .attr('y', yMeasSprite)
                  .attr('class',"kanto")
                  .attr('font-size', "12pt")
                  .attr('stroke', 'black')
                  .attr('href','sprites/' + altFormlower(count) + '.png');
                    

              count++; 
                  if (x + (130 * j)==1610) { x= 10; }
              }
              
            }
          
          });//end kanto

          $('#b_johto').click(function() {
                $('#all').remove();
                $('#kanto').remove();
                $('#hoenn').remove();
                $('#sinnoh').remove();
                $('#unova').remove();
                $('#kalos').remove();
                $('#runknown').remove();
                $('#galar').remove();

                //disabling button function. and reenabling all other buttons
                document.getElementById("b_all").disabled = false;
                document.getElementById("b_kanto").disabled = false;
                document.getElementById("b_johto").disabled = true;
                document.getElementById("b_hoenn").disabled = false;
                document.getElementById("b_sinnoh").disabled = false;
                document.getElementById("b_unova").disabled = false;
                document.getElementById("b_kalos").disabled = false;
                document.getElementById("b_runknown").disabled = false;
                document.getElementById("b_galar").disabled = false;

            //kanto
            var height = "98em";
            var svg = d3.select("#dex").append("svg").attr("id","johto").attr("width", width).attr("height", height);
            var count = 178;
            // Add the path using this helper function
              for (let i = 0; i <= 20; i++) {
                for (let j = 0; j < 9; j++) {  
                
                if (count >= 279) { break; }
                
                //x-position
                var x = 10;
                x = x + (130*j);
                var xMeas = (x/16) + "em";

                //y-position
                var y = 10;
                y = y + (130*i);
                var yMeas = (y/16) + "em";

                //drawing the squares
                svg.append('rect')
                  .attr('x', xMeas)
                  .attr('y', yMeas)
                  .attr('class', altFormlower(count))
                  .attr('class',"johto")
                  .attr('width', (115/16) + "em")
                  .attr('height',(115/16) + "em")
                  .attr('stroke', '#375855')
                  .attr('fill', '#5d938e')
                  .attr("class", "rec")
                  .attr("rx",10)
                  .attr("ry",10);

                var xID = 55;
                xID = xID + (130*j);
                var xMeasID = (xID/16) + "em";

                //y-position
                var yID = 35;
                yID = yID + (130*i);
                var yMeasID = (yID/16) + "em";
                
                svg.append('text')
                  .attr('x', xMeasID)
                  .attr('y', yMeasID)
                  .attr('class',"johto")
                  .attr('font-size', "12pt")
                  .attr('stroke', 'black')
                  .text(data[count].Pokemon_ID);


                var xName = 30;
                xName = xName + (130*j);
                var xMeasName = (xName/16) + "em";

                //y-position
                var yName = 115;
                yName = yName + (130*i);
                var yMeasName = (yName/16) + "em";
                
                  svg.append('text')
                    .attr('x', xMeasName)
                    .attr('y', yMeasName)
                    .attr('class',"johto")
                    .attr('font-size', "12pt")
                    .attr('stroke', 'black')
                    //.attr('fill', '#69a3b2')
                    .text(altForm(count));

                var xSprite = 30;
                xSprite = xSprite + (130*j);
                var xMeasSprite = (xName/16) + "em";

                //y-position
                var ySprite = 35;
                ySprite = ySprite + (130*i);
                var yMeasSprite = (ySprite/16) + "em";
                    
                svg.append('image')
                  .attr('x', xMeasSprite)
                  .attr('y', yMeasSprite)
                  .attr('class',"johto")
                  .attr('font-size', "12pt")
                  .attr('stroke', 'black')
                  .attr('href','sprites/' + altFormlower(count) + '.png');
                    

              count++; 
                  if (x + (130 * j)==1610) { x= 10; }
              }
              
            }
          
          });//end johto

          $('#b_hoenn').click(function() {
                $('#all').remove();
                $('#johto').remove();
                $('#kanto').remove();
                $('#sinnoh').remove();
                $('#unova').remove();
                $('#kalos').remove();
                $('#runknown').remove();
                $('#galar').remove();

                //disabling button function. and reenabling all other buttons
                document.getElementById("b_all").disabled = false;
                document.getElementById("b_kanto").disabled = false;
                document.getElementById("b_johto").disabled = false;
                document.getElementById("b_hoenn").disabled = true;
                document.getElementById("b_sinnoh").disabled = false;
                document.getElementById("b_unova").disabled = false;
                document.getElementById("b_kalos").disabled = false;
                document.getElementById("b_runknown").disabled = false;
                document.getElementById("b_galar").disabled = false;

            //hoenn
            var height = "130em";
            var svg = d3.select("#dex").append("svg").attr("id","hoenn").attr("width", width).attr("height", height);
            var count = 279;
            // Add the path using this helper function
              for (let i = 0; i <= 20; i++) {
                for (let j = 0; j < 9; j++) {  
                
                if (count >= 422) { break; }
                
                //x-position
                var x = 10;
                x = x + (130*j);
                var xMeas = (x/16) + "em";

                //y-position
                var y = 10;
                y = y + (130*i);
                var yMeas = (y/16) + "em";

                //drawing the squares
                svg.append('rect')
                  .attr('x', xMeas)
                  .attr('y', yMeas)
                  .attr('class', altFormlower(count))
                  .attr('class',"kanto")
                  .attr('width', (115/16) + "em")
                  .attr('height',(115/16) + "em")
                  .attr('stroke', '#375855')
                  .attr('fill', '#5d938e')
                  .attr("class", "rec")
                  .attr("rx",10)
                  .attr("ry",10);

                var xID = 55;
                xID = xID + (130*j);
                var xMeasID = (xID/16) + "em";

                //y-position
                var yID = 35;
                yID = yID + (130*i);
                var yMeasID = (yID/16) + "em";
                
                svg.append('text')
                  .attr('x', xMeasID)
                  .attr('y', yMeasID)
                  .attr('class',"kanto")
                  .attr('font-size', "12pt")
                  .attr('stroke', 'black')
                  .text(data[count].Pokemon_ID);


                var xName = 30;
                xName = xName + (130*j);
                var xMeasName = (xName/16) + "em";

                //y-position
                var yName = 115;
                yName = yName + (130*i);
                var yMeasName = (yName/16) + "em";
                
                  svg.append('text')
                    .attr('x', xMeasName)
                    .attr('y', yMeasName)
                    .attr('class',"kanto")
                    .attr('font-size', "12pt")
                    .attr('stroke', 'black')
                    .text(altForm(count));

                var xSprite = 30;
                xSprite = xSprite + (130*j);
                var xMeasSprite = (xName/16) + "em";

                //y-position
                var ySprite = 35;
                ySprite = ySprite + (130*i);
                var yMeasSprite = (ySprite/16) + "em";
                    
                svg.append('image')
                  .attr('x', xMeasSprite)
                  .attr('y', yMeasSprite)
                  .attr('class',"kanto")
                  .attr('font-size', "12pt")
                  .attr('stroke', 'black')
                  .attr('href','sprites/' + altFormlower(count) + '.png');
                    

              count++; 
                  if (x + (130 * j)==1610) { x= 10; }
              }
              
            }
          
          });//end hoenn

          $('#b_sinnoh').click(function() {
                $('#all').remove();
                $('#johto').remove();
                $('#hoenn').remove();
                $('#kanto').remove();
                $('#unova').remove();
                $('#kalos').remove();
                $('#runknown').remove();
                $('#galar').remove();

                //disabling button function. and reenabling all other buttons
                document.getElementById("b_all").disabled = false;
                document.getElementById("b_kanto").disabled = false;
                document.getElementById("b_johto").disabled = false;
                document.getElementById("b_hoenn").disabled = false;
                document.getElementById("b_sinnoh").disabled = true;
                document.getElementById("b_unova").disabled = false;
                document.getElementById("b_kalos").disabled = false;
                document.getElementById("b_runknown").disabled = false;
                document.getElementById("b_galar").disabled = false;

            //sinnoh
            var height = "114em";
            var svg = d3.select("#dex").append("svg").attr("id","sinnoh").attr("width", width).attr("height", height);
                    var count = 422;
              // Add the path using this helper function
                  for (let i = 0; i <= 20; i++) {
                    for (let j = 0; j < 9; j++) {  
                    
                    if (count >= 542) { break; }
                    
                    //x-position
                    var x = 10;
                    x = x + (130*j);
                    var xMeas = (x/16) + "em";

                    //y-position
                    var y = 10;
                    y = y + (130*i);
                    var yMeas = (y/16) + "em";

                    //drawing the squares
                    svg.append('rect')
                      .attr('x', xMeas)
                      .attr('y', yMeas)
                      .attr('class',altFormlower(count))
                      .attr('class',"sinnoh")
                      .attr('width', (115/16) + "em")
                      .attr('height',(115/16) + "em")
                      .attr('stroke', '#375855')
                      .attr('fill', '#5d938e')
                      .attr("class", "rec")
                      .attr("rx",10)
                      .attr("ry",10);

                    var xID = 55;
                    xID = xID + (130*j);
                    var xMeasID = (xID/16) + "em";

                    //y-position
                    var yID = 35;
                    yID = yID + (130*i);
                    var yMeasID = (yID/16) + "em";
                    
                    svg.append('text')
                      .attr('x', xMeasID)
                      .attr('y', yMeasID)
                      .attr('class',"sinnoh")
                      .attr('font-size', "12pt")
                      .attr('stroke', 'black')
                      .text(data[count].Pokemon_ID);


                    var xName = 30;
                    xName = xName + (130*j);
                    var xMeasName = (xName/16) + "em";

                    //y-position
                    var yName = 115;
                    yName = yName + (130*i);
                    var yMeasName = (yName/16) + "em";
                    
                      svg.append('text')
                        .attr('x', xMeasName)
                        .attr('y', yMeasName)
                        .attr('class',"sinnoh")
                        .attr('font-size', "12pt")
                        .attr('stroke', 'black')
                        .text(altForm(count));

                    var xSprite = 30;
                    xSprite = xSprite + (130*j);
                    var xMeasSprite = (xName/16) + "em";

                    //y-position
                    var ySprite = 35;
                    ySprite = ySprite + (130*i);
                    var yMeasSprite = (ySprite/16) + "em";
                        
                    svg.append('image')
                      .attr('x', xMeasSprite)
                      .attr('y', yMeasSprite)
                      .attr('class',"sinnoh")
                      .attr('font-size', "12pt")
                      .attr('stroke', 'black')
                      .attr('href','sprites/' + altFormlower(count) + '.png')
                        

                  count++; 
                      if (x + (130 * j)==1610) { x= 10; }
                  }
                }
          });//end sinnoh

          $('#b_unova').click(function() {
              $('#all').remove();
              $('#johto').remove();
              $('#hoenn').remove();
              $('#kanto').remove();
              $('#sinnoh').remove();
              $('#kalos').remove();
              $('#runknown').remove();
              $('#galar').remove();

                //disabling button function. and reenabling all other buttons
                document.getElementById("b_all").disabled = false;
                document.getElementById("b_kanto").disabled = false;
                document.getElementById("b_johto").disabled = false;
                document.getElementById("b_hoenn").disabled = false;
                document.getElementById("b_sinnoh").disabled = false;
                document.getElementById("b_unova").disabled = true;
                document.getElementById("b_kalos").disabled = false;
                document.getElementById("b_runknown").disabled = false;
                document.getElementById("b_galar").disabled = false;

              //unova
              var height = "163em";
              var svg = d3.select("#dex").append("svg").attr("id", "unova").attr("width", width).attr("height", height);
              var count = 542;
                // Add the path using this helper function
                    for (let i = 0; i <= 20; i++) {
                      for (let j = 0; j < 9; j++) {  
                      
                      if (count >= 718) { break; }
                      
                      //x-position
                      var x = 10;
                      x = x + (130*j);
                      var xMeas = (x/16) + "em";

                      //y-position
                      var y = 10;
                      y = y + (130*i);
                      var yMeas = (y/16) + "em";

                      //drawing the squares
                      svg.append('rect')
                        .attr('x', xMeas)
                        .attr('y', yMeas)
                        .attr('class',altFormlower(count))
                        .attr('class',"unova")
                        .attr('width', (115/16) + "em")
                        .attr('height',(115/16) + "em")
                        .attr('stroke', '#375855')
                        .attr("class", "rec")
                        .attr('fill', '#5d938e')
                        .attr("rx",10)
                        .attr("ry",10);

                      var xID = 55;
                      xID = xID + (130*j);
                      var xMeasID = (xID/16) + "em";

                      //y-position
                      var yID = 35;
                      yID = yID + (130*i);
                      var yMeasID = (yID/16) + "em";
                      
                      svg.append('text')
                        .attr('x', xMeasID)
                        .attr('y', yMeasID)
                        .attr('class',"unova")
                        .attr('font-size', "12pt")
                        .attr('stroke', 'black')
                        .text(data[count].Pokemon_ID);


                      var xName = 30;
                      xName = xName + (130*j);
                      var xMeasName = (xName/16) + "em";

                      //y-position
                      var yName = 115;
                      yName = yName + (130*i);
                      var yMeasName = (yName/16) + "em";
                      
                        svg.append('text')
                          .attr('x', xMeasName)
                          .attr('y', yMeasName)
                          .attr('class',"unova")
                          .attr('font-size', "12pt")
                          .attr('stroke', 'black')
                          .text(altForm(count));

                      var xSprite = 30;
                      xSprite = xSprite + (130*j);
                      var xMeasSprite = (xName/16) + "em";

                      //y-position
                      var ySprite = 35;
                      ySprite = ySprite + (130*i);
                      var yMeasSprite = (ySprite/16) + "em";
                          
                      svg.append('image')
                        .attr('x', xMeasSprite)
                        .attr('y', yMeasSprite)
                        .attr('class',"unova")
                        .attr('font-size', "12pt")
                        .attr('stroke', 'black')
                        .attr('href','sprites/' + altFormlower(count) + '.png')
                          

                    count++; 
                        if (x + (130 * j)==1610) { x= 10; }
                    }
                    
                  }
          });//end unova

          $('#b_kalos').click(function() {
                $('#all').remove();
                $('#johto').remove();
                $('#hoenn').remove();
                $('#kanto').remove();
                $('#sinnoh').remove();
                $('#unova').remove();
                $('#runknown').remove();
                $('#galar').remove();

                //disabling button function. and reenabling all other buttons
                document.getElementById("b_all").disabled = false;
                document.getElementById("b_kanto").disabled = false;
                document.getElementById("b_johto").disabled = false;
                document.getElementById("b_hoenn").disabled = false;
                document.getElementById("b_sinnoh").disabled = false;
                document.getElementById("b_unova").disabled = false;
                document.getElementById("b_kalos").disabled = true;
                document.getElementById("b_runknown").disabled = false;
                document.getElementById("b_galar").disabled = false;
                
                var height = "82em";
                var svg = d3.select("#dex").append("svg").attr("id", "kalos").attr("width", width).attr("height", height);
                var count = 718;
                  // Add the path using this helper function
                      for (let i = 0; i <= 20; i++) {
                        for (let j = 0; j < 9; j++) {  
                        
                        if (count >= 808) { break; }
                        
                        //x-position
                        var x = 10;
                        x = x + (130*j);
                        var xMeas = (x/16) + "em";

                        //y-position
                        var y = 10;
                        y = y + (130*i);
                        var yMeas = (y/16) + "em";

                        //drawing the squares
                        svg.append('rect')
                          .attr('x', xMeas)
                          .attr('y', yMeas)
                          .attr('class',altFormlower(count))
                          .attr('class',"kalos")
                          .attr('width', (115/16) + "em")
                          .attr('height',(115/16) + "em")
                          .attr('stroke', '#375855')
                          .attr("class", "rec")
                          .attr('fill', '#5d938e')
                          .attr("rx",10)
                          .attr("ry",10);

                        var xID = 55;
                        xID = xID + (130*j);
                        var xMeasID = (xID/16) + "em";

                        //y-position
                        var yID = 35;
                        yID = yID + (130*i);
                        var yMeasID = (yID/16) + "em";
                        
                        svg.append('text')
                          .attr('x', xMeasID)
                          .attr('y', yMeasID)
                          .attr('class',"kalos")
                          .attr('font-size', "12pt")
                          .attr('stroke', 'black')
                          .text(data[count].Pokemon_ID);


                        var xName = 30;
                        xName = xName + (130*j);
                        var xMeasName = (xName/16) + "em";

                        //y-position
                        var yName = 115;
                        yName = yName + (130*i);
                        var yMeasName = (yName/16) + "em";
                        
                          svg.append('text')
                            .attr('x', xMeasName)
                            .attr('y', yMeasName)
                            .attr('class',"kalos")
                            .attr('font-size', "12pt")
                            .attr('stroke', 'black')
                            .text(altForm(count));

                        var xSprite = 30;
                        xSprite = xSprite + (130*j);
                        var xMeasSprite = (xName/16) + "em";

                        //y-position
                        var ySprite = 35;
                        ySprite = ySprite + (130*i);
                        var yMeasSprite = (ySprite/16) + "em";
                            
                        svg.append('image')
                          .attr('x', xMeasSprite)
                          .attr('y', yMeasSprite)
                          .attr('class',"kalos")
                          .attr('font-size', "12pt")
                          .attr('stroke', 'black')
                          .attr('href','sprites/' + altFormlower(count) + '.png')
                            

                      count++; 
                          if (x + (130 * j)==1610) { x= 10; }
                      }
                      
                    }
          });//end kalos

          $('#b_runknown').click(function() {
                $('#all').remove();
                $('#johto').remove();
                $('#hoenn').remove();
                $('#kanto').remove();
                $('#sinnoh').remove();
                $('#unova').remove();
                $('#kalos').remove();
                $('#galar').remove();
                
                //disabling button function. and reenabling all other buttons
                document.getElementById("b_all").disabled = false;
                document.getElementById("b_kanto").disabled = false;
                document.getElementById("b_johto").disabled = false;
                document.getElementById("b_hoenn").disabled = false;
                document.getElementById("b_sinnoh").disabled = false;
                document.getElementById("b_unova").disabled = false;
                document.getElementById("b_kalos").disabled = false;
                document.getElementById("b_runknown").disabled = true;
                document.getElementById("b_galar").disabled = false;

                var height = "8em";
                var svg = d3.select("#dex").append("svg").attr("id","runknown").attr("width", width).attr("height", height);
                var count = 808;
                  // Add the path using this helper function
                      for (let i = 0; i <= 20; i++) {
                        for (let j = 0; j < 9; j++) {  
                        
                        if (count >= 810) { break; }
                        
                        //x-position
                        var x = 10;
                        x = x + (130*j);
                        var xMeas = (x/16) + "em";

                        //y-position
                        var y = 10;
                        y = y + (130*i);
                        var yMeas = (y/16) + "em";

                        //drawing the squares
                        svg.append('rect')
                          .attr('x', xMeas)
                          .attr('y', yMeas)
                          .attr('class',altFormlower(count))
                          .attr('class',"runkown")
                          .attr('width', (115/16) + "em")
                          .attr('height',(115/16) + "em")
                          .attr('stroke', '#375855')
                          .attr('fill', '#5d938e')
                          .attr("class", "rec")
                          .attr("rx",10)
                          .attr("ry",10);
                        var xID = 55;
                        xID = xID + (130*j);
                        var xMeasID = (xID/16) + "em";

                        //y-position
                        var yID = 35;
                        yID = yID + (130*i);
                        var yMeasID = (yID/16) + "em";
                        
                        svg.append('text')
                          .attr('x', xMeasID)
                          .attr('y', yMeasID)
                          .attr('class',"runknown")
                          .attr('font-size', "12pt")
                          .attr('stroke', 'black')
                          .text(data[count].Pokemon_ID);


                        var xName = 30;
                        xName = xName + (130*j);
                        var xMeasName = (xName/16) + "em";

                        //y-position
                        var yName = 115;
                        yName = yName + (130*i);
                        var yMeasName = (yName/16) + "em";
                        
                          svg.append('text')
                            .attr('x', xMeasName)
                            .attr('y', yMeasName)
                            .attr('class',"runknown")
                            .attr('font-size', "12pt")
                            .attr('stroke', 'black')
                            .text(altForm(count));

                        var xSprite = 30;
                        xSprite = xSprite + (130*j);
                        var xMeasSprite = (xName/16) + "em";

                        //y-position
                        var ySprite = 35;
                        ySprite = ySprite + (130*i);
                        var yMeasSprite = (ySprite/16) + "em";
                            
                        svg.append('image')
                          .attr('x', xMeasSprite)
                          .attr('y', yMeasSprite)
                          .attr('class',"runknown")
                          .attr('font-size', "12pt")
                          .attr('stroke', 'black')
                          .attr('href','sprites/' + altFormlower(count) + '.png')
                            

                      count++; 
                          if (x + (130 * j)==1610) { x= 10; }
                      }
                      
                    }
          });//end region unknown

          $('#b_galar').click(function() {
                $('#all').remove();
                $('#johto').remove();
                $('#hoenn').remove();
                $('#kanto').remove();
                $('#sinnoh').remove();
                $('#unova').remove();
                $('#kalos').remove();
                $('#runknown').remove();

                //disabling button function. and reenabling all other buttons
                document.getElementById("b_all").disabled = false;
                document.getElementById("b_kanto").disabled = false;
                document.getElementById("b_johto").disabled = false;
                document.getElementById("b_hoenn").disabled = false;
                document.getElementById("b_sinnoh").disabled = false;
                document.getElementById("b_unova").disabled = false;
                document.getElementById("b_kalos").disabled = false;
                document.getElementById("b_runknown").disabled = false;
                document.getElementById("b_galar").disabled = true;

            var height = "90em";
            var svg = d3.select("#dex").append("svg").attr("id", "galar").attr("width", width).attr("height", height);
            var count = 810;
              // Add the path using this helper function
                  for (let i = 0; i <= 20; i++) {
                    for (let j = 0; j < 9; j++) {  
                    
                    if (count >= 908) { break; }
                    
                    //x-position
                    var x = 10;
                    x = x + (130*j);
                    var xMeas = (x/16) + "em";

                    //y-position
                    var y = 10;
                    y = y + (130*i);
                    var yMeas = (y/16) + "em";

                    //drawing the squares
                    svg.append('rect')
                      .attr('x', xMeas)
                      .attr('y', yMeas)
                      .attr('class',altFormlower(count))
                      .attr('class',"galar")
                      .attr('width', (115/16) + "em")
                      .attr('height',(115/16) + "em")
                      .attr('stroke', '#375855')
                      .attr('fill', '#5d938e')
                      .attr("class", "rec")
                      .attr("rx",10)
                      .attr("ry",10);

                    var xID = 55;
                    xID = xID + (130*j);
                    var xMeasID = (xID/16) + "em";

                    //y-position
                    var yID = 35;
                    yID = yID + (130*i);
                    var yMeasID = (yID/16) + "em";
                    
                    svg.append('text')
                      .attr('x', xMeasID)
                      .attr('y', yMeasID)
                      .attr('class',"galar")
                      .attr('font-size', "12pt")
                      .attr('stroke', 'black')
                      .text(data[count].Pokemon_ID);


                    var xName = 30;
                    xName = xName + (130*j);
                    var xMeasName = (xName/16) + "em";

                    //y-position
                    var yName = 115;
                    yName = yName + (130*i);
                    var yMeasName = (yName/16) + "em";
                    
                      svg.append('text')
                        .attr('x', xMeasName)
                        .attr('y', yMeasName)
                        .attr('class',"galar")
                        .attr('font-size', "12pt")
                        .attr('stroke', 'black')
                        .text(altForm(count));

                    var xSprite = 30;
                    xSprite = xSprite + (130*j);
                    var xMeasSprite = (xName/16) + "em";

                    //y-position
                    var ySprite = 35;
                    ySprite = ySprite + (130*i);
                    var yMeasSprite = (ySprite/16) + "em";
                        
                    svg.append('image')
                      .attr('x', xMeasSprite)
                      .attr('y', yMeasSprite)
                      .attr('class',"galar")
                      .attr('font-size', "12pt")
                      .attr('stroke', 'black')
                      .attr('href','sprites/' + altFormlower(count) + '.png')
                        

                  count++; 
                      if (x + (130 * j)==1610) { x= 10; }
                  }
                  
                }
          });//end galar


      }); //end document ready
     
     

        var data = <?php echo $json_array; ?>;
        // console.log(data[1].Pokemon_Name);

        var width = "100%";
        var height = "822em";

  function altForm(x){
      if (data[x].Form != 'Normal'){
        var combined = data[x].Pokemon_Name + "-" + data[x].Form;
        return combined;
      }
      else{
        return data[x].Pokemon_Name;
      }
  }
  function altFormlower(x){
      if (data[x].Form != 'Normal'){
        var combined = data[x].Pokemon_Name + "-" + data[x].Form;
        combined = combined.replace(". ","-");
        return combined.toLowerCase();
      }
      else{
        var mon =data[x].Pokemon_Name.toLowerCase();
        mon = mon.replace(". ","-");
        return mon.toLowerCase();
      }
    }
  
    //All
        var svg = d3.select("#dex").append("svg").attr("id","all").attr("width", width).attr("height", height);
        var count = 0;
  // Add the path using this helper function
      for (let i = 0; i <= 100; i++) {
        for (let j = 0; j < 9; j++) {  
        
        if (count >= 908) { break; }
        
        //x-position
        var x = 10;
        x = x + (130*j);
        var xMeas = (x/16) + "em";

        //y-position
        var y = 10;
        y = y + (130*i);
        var yMeas = (y/16) + "em";

        //drawing the squares
        svg.append('rect')
          .attr('x', xMeas)
          .attr('y', yMeas)
          .attr('class',altFormlower(count))
          .attr('class',"all")
          .attr('width', (115/16) + "em")
          .attr('height',(115/16) + "em")
          .attr('stroke', '#375855')
          .attr('fill', '#5d938e')
          .attr("class", "rec")
          .attr("rx",10)
          .attr("ry",10);

        var xID = 55;
        xID = xID + (130*j);
        var xMeasID = (xID/16) + "em";

        //y-position
        var yID = 35;
        yID = yID + (130*i);
        var yMeasID = (yID/16) + "em";
        
        svg.append('text')
          .attr('x', xMeasID)
          .attr('y', yMeasID)
          .attr('class',"all")
          .attr('font-size', "12pt")
          .attr('stroke', 'black')
          .text(data[count].Pokemon_ID);

        //x-position
        var xName = 30;
        xName = xName + (130*j);
        var xMeasName = (xName/16) + "em";

        //y-position
        var yName = 115;
        yName = yName + (130*i);
        var yMeasName = (yName/16) + "em";
        
          svg.append('text')
            .attr('x', xMeasName)
            .attr('y', yMeasName)
            .attr('class',"all")
            .attr('font-size', "12pt")
            .attr('stroke', 'black')
            .text(altForm(count));

        var xSprite = 30;
        xSprite = xSprite + (130*j);
        var xMeasSprite = (xName/16) + "em";

        //y-position
        var ySprite = 35;
        ySprite = ySprite + (130*i);
        var yMeasSprite = (ySprite/16) + "em";
            
        svg.append('image')
          .attr('x', xMeasSprite)
          .attr('y', yMeasSprite)
          .attr('class',"all")
          .attr('font-size', "12pt")
          .attr('stroke', 'black')
          .attr('href','sprites/' + altFormlower(count) + '.png')
            

      count++; 
          if (x + (130 * j)==1610) { x= 10; }
      }
      
    }

  </script>
</body>
</html>