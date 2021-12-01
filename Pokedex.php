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
      background-image:linear-gradient(white,red);
      width:100%;
    }

    /* Button CSS */
    .glitch,
    .glitch:after {
      width: 150px;
      height: 76px;
      line-height: 78px;
      font-size: 20px;
      font-family: 'Bebas Neue', sans-serif;
      background: linear-gradient(45deg, transparent 5%, #FF013C 5%);
      border: 0;
      color: #fff;
      letter-spacing: 3px;
      box-shadow: 6px 0px 0px #00E6F6;
      outline: transparent;
      position: relative;
      user-select: none;
      -webkit-user-select: none;
      touch-action: manipulation;
    }

    .glitch:after {
      --slice-0: inset(50% 50% 50% 50%);
      --slice-1: inset(80% -6px 0 0);
      --slice-2: inset(50% -6px 30% 0);
      --slice-3: inset(10% -6px 85% 0);
      --slice-4: inset(40% -6px 43% 0);
      --slice-5: inset(80% -6px 5% 0);
      
      content: 'ALTERNATE TEXT';
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(45deg, transparent 3%, #00E6F6 3%, #00E6F6 5%, #FF013C 5%);
      text-shadow: -3px -3px 0px #F8F005, 3px 3px 0px #00E6F6;
      clip-path: var(--slice-0);
    }

    .glitch:hover:after {
      animation: 1s glitch;
      animation-timing-function: steps(2, end);
    }

    @keyframes glitch {
      0% {
        clip-path: var(--slice-1);
        transform: translate(-20px, -10px);
      }
      10% {
        clip-path: var(--slice-3);
        transform: translate(10px, 10px);
      }
      20% {
        clip-path: var(--slice-1);
        transform: translate(-10px, 10px);
      }
      30% {
        clip-path: var(--slice-3);
        transform: translate(0px, 5px);
      }
      40% {
        clip-path: var(--slice-2);
        transform: translate(-5px, 0px);
      }
      50% {
        clip-path: var(--slice-3);
        transform: translate(5px, 0px);
      }
      60% {
        clip-path: var(--slice-4);
        transform: translate(5px, 10px);
      }
      70% {
        clip-path: var(--slice-2);
        transform: translate(-10px, 10px);
      }
      80% {
        clip-path: var(--slice-5);
        transform: translate(20px, -10px);
      }
      90% {
        clip-path: var(--slice-1);
        transform: translate(-10px, 0px);
      }
      100% {
        clip-path: var(--slice-1);
        transform: translate(0);
      }
    }

    @media (min-width: 768px) {
      .glitch,
      .glitch:after {
        width: 200px;
        height: 86px;
        line-height: 88px;
      }
    }

    #group2{
      padding-top:1em;
      padding-bottom:1em;
      }
    }
    /* End Button CSS */

    .kanto{
      display:none;
    }
    .johto{
      display:none;
    }
    .hoenn{
      display:none;
    }
    .sinnoh{
      display:none;
    }
    .unova{
      display:none;
    }
    .kalos{
      display:none;
    }
    .runknown{
      display:none;
    }
    .galar{
      display:none;
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
    $sql = "SELECT Form, Pokemon_ID, Pokemon_Name, 'Max_CP' FROM PokemonGOStats";
    // echo ($sql);
    // // exit();
    $result = $conn->query($sql);

    while($row = mysqli_fetch_assoc($result))
    $transfer[] = $row; 
    $json_array = json_encode($transfer);
  ?>
  <div id="dex" class="rect">
     <div id="group1">
        <button id="showall" class="glitch" role="button">All Pokemon</button>
        <button id="b_kanto" class="glitch" role="button">Kanto</button>
        <button id="b_johto" class="glitch" role="button">Johto</button>
        <button id="b_hoenn" class="glitch" role="button">Hoenn</button>
        <button id="b_sinnoh" class="glitch" role="button">Sinnoh</button>
        <button id="b_unova" class="glitch" role="button">Unova</button>
      </div>
      <div id="group2">
        <button id="b_kalos" class="glitch" role="button">Kalos</button>
        <button id="b_runknown" class="glitch" role="button">Unknown</button>
        <button id="b_galar" class="glitch" role="button">Galar</button>
      </div>
  </div>
      
  <script src="https://d3js.org/d3.v7.min.js"></script>
  <script src="js/jquery-3.6.0.min.js"></script>
  <script>

        var data = <?php echo $json_array; ?>;
        // console.log(data[1].Pokemon_Name);

        var width = "100%";

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
  
  //kanto
  //       var height = "168.75em";
  //       var svg = d3.select("#dex").append("svg").attr("width", width).attr("height", height);
  //       var count = 0;
  // // Add the path using this helper function
  //     for (let i = 0; i <= 20; i++) {
  //       for (let j = 0; j < 9; j++) {  
        
  //       if (count >= 178) { break; }
        
  //       //x-position
  //       var x = 10;
  //       x = x + (130*j);
  //       var xMeas = (x/16) + "em";

  //       //y-position
  //       var y = 10;
  //       y = y + (130*i);
  //       var yMeas = (y/16) + "em";

  //       //drawing the squares
  //       svg.append('rect')
  //         .attr('x', xMeas)
  //         .attr('y', yMeas)
  //         .attr('class', altFormlower(count))
  //         .attr('class',"kanto")
  //         .attr('width', (115/16) + "em")
  //         .attr('height',(115/16) + "em")
  //         .attr('stroke', 'black')
  //         .attr('fill', '#69a3b2');

  //       var xID = 55;
  //       xID = xID + (130*j);
  //       var xMeasID = (xID/16) + "em";

  //       //y-position
  //       var yID = 35;
  //       yID = yID + (130*i);
  //       var yMeasID = (yID/16) + "em";
        
  //       svg.append('text')
  //         .attr('x', xMeasID)
  //         .attr('y', yMeasID)
  //         .attr('class',"kanto")
  //         .attr('font-size', "12pt")
  //         .attr('stroke', 'black')
  //         .attr('fill', '#69a3b2')
  //         .text(data[count].Pokemon_ID);


  //       var xName = 30;
  //       xName = xName + (130*j);
  //       var xMeasName = (xName/16) + "em";

  //       //y-position
  //       var yName = 115;
  //       yName = yName + (130*i);
  //       var yMeasName = (yName/16) + "em";
        
  //         svg.append('text')
  //           .attr('x', xMeasName)
  //           .attr('y', yMeasName)
  //           .attr('class',"kanto")
  //           .attr('font-size', "12pt")
  //           .attr('stroke', 'black')
  //           .attr('fill', '#69a3b2')
  //           .text(altForm(count));

  //       var xSprite = 30;
  //       xSprite = xSprite + (130*j);
  //       var xMeasSprite = (xName/16) + "em";

  //       //y-position
  //       var ySprite = 35;
  //       ySprite = ySprite + (130*i);
  //       var yMeasSprite = (ySprite/16) + "em";
            
  //       svg.append('image')
  //         .attr('x', xMeasSprite)
  //         .attr('y', yMeasSprite)
  //         .attr('class',"kanto")
  //         .attr('font-size', "12pt")
  //         .attr('stroke', 'black')
  //         .attr('href','sprites/' + altFormlower(count) + '.png')
            

  //     count++; 
  //         if (x + (130 * j)==1610) { x= 10; }
  //     }
      
  //   }

//johto
// var height = "100em";
//   var svg = d3.select("#dex").append("svg").attr("width", width).attr("height", height);
//         var count = 178;
//   // Add the path using this helper function
//       for (let i = 0; i <= 20; i++) {
//         for (let j = 0; j < 9; j++) {  
        
//         if (count >= 279) { break; }
        
//         //x-position
//         var x = 10;
//         x = x + (130*j);
//         var xMeas = (x/16) + "em";

//         //y-position
//         var y = 10;
//         y = y + (130*i);
//         var yMeas = (y/16) + "em";

//         //drawing the squares
//         svg.append('rect')
//           .attr('x', xMeas)
//           .attr('y', yMeas)
//           .attr('class',altFormlower(count))
//           .attr('class',"johto")
//           .attr('width', (115/16) + "em")
//           .attr('height',(115/16) + "em")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2');

//         var xID = 55;
//         xID = xID + (130*j);
//         var xMeasID = (xID/16) + "em";

//         //y-position
//         var yID = 35;
//         yID = yID + (130*i);
//         var yMeasID = (yID/16) + "em";
        
//         svg.append('text')
//           .attr('x', xMeasID)
//           .attr('y', yMeasID)
//           .attr('class',"johto")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2')
//           .text(data[count].Pokemon_ID);


//         var xName = 30;
//         xName = xName + (130*j);
//         var xMeasName = (xName/16) + "em";

//         //y-position
//         var yName = 115;
//         yName = yName + (130*i);
//         var yMeasName = (yName/16) + "em";
        
//           svg.append('text')
//             .attr('x', xMeasName)
//             .attr('y', yMeasName)
//             .attr('class',"johto")
//             .attr('font-size', "12pt")
//             .attr('stroke', 'black')
//             .attr('fill', '#69a3b2')
//             .text(altForm(count));

//         var xSprite = 30;
//         xSprite = xSprite + (130*j);
//         var xMeasSprite = (xName/16) + "em";

//         //y-position
//         var ySprite = 35;
//         ySprite = ySprite + (130*i);
//         var yMeasSprite = (ySprite/16) + "em";
            
//         svg.append('image')
//           .attr('x', xMeasSprite)
//           .attr('y', yMeasSprite)
//           .attr('class',"johto")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('href','sprites/' + altFormlower(count) + '.png')
            

//       count++; 
//           if (x + (130 * j)==1610) { x= 10; }
//       }
      
//     }

//Hoenn
// var height = "130em";
// var svg = d3.select("#dex").append("svg").attr("width", width).attr("height", height);
//         var count = 279;
//   // Add the path using this helper function
//       for (let i = 0; i <= 20; i++) {
//         for (let j = 0; j < 9; j++) {  
        
//         if (count >= 422) { break; }
        
//         //x-position
//         var x = 10;
//         x = x + (130*j);
//         var xMeas = (x/16) + "em";

//         //y-position
//         var y = 10;
//         y = y + (130*i);
//         var yMeas = (y/16) + "em";

//         //drawing the squares
//         svg.append('rect')
//           .attr('x', xMeas)
//           .attr('y', yMeas)
//           .attr('class',altFormlower(count))
//           .attr('class',"hoenn")
//           .attr('width', (115/16) + "em")
//           .attr('height',(115/16) + "em")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2');

//         var xID = 55;
//         xID = xID + (130*j);
//         var xMeasID = (xID/16) + "em";

//         //y-position
//         var yID = 35;
//         yID = yID + (130*i);
//         var yMeasID = (yID/16) + "em";
        
//         svg.append('text')
//           .attr('x', xMeasID)
//           .attr('y', yMeasID)
//           .attr('class',"hoenn")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2')
//           .text(data[count].Pokemon_ID);


//         var xName = 30;
//         xName = xName + (130*j);
//         var xMeasName = (xName/16) + "em";

//         //y-position
//         var yName = 115;
//         yName = yName + (130*i);
//         var yMeasName = (yName/16) + "em";
        
//           svg.append('text')
//             .attr('x', xMeasName)
//             .attr('y', yMeasName)
//             .attr('class',"hoenn")
//             .attr('font-size', "12pt")
//             .attr('stroke', 'black')
//             .attr('fill', '#69a3b2')
//             .text(altForm(count));

//         var xSprite = 30;
//         xSprite = xSprite + (130*j);
//         var xMeasSprite = (xName/16) + "em";

//         //y-position
//         var ySprite = 35;
//         ySprite = ySprite + (130*i);
//         var yMeasSprite = (ySprite/16) + "em";
            
//         svg.append('image')
//           .attr('x', xMeasSprite)
//           .attr('y', yMeasSprite)
//           .attr('class',"hoenn")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('href','sprites/' + altFormlower(count) + '.png')
            

//       count++; 
//           if (x + (130 * j)==1610) { x= 10; }
//       }
      
//     }

//Sinnoh
// var height = "130em";
// var svg = d3.select("#dex").append("svg").attr("width", width).attr("height", height);
//         var count = 422;
//   // Add the path using this helper function
//       for (let i = 0; i <= 20; i++) {
//         for (let j = 0; j < 9; j++) {  
        
//         if (count >= 542) { break; }
        
//         //x-position
//         var x = 10;
//         x = x + (130*j);
//         var xMeas = (x/16) + "em";

//         //y-position
//         var y = 10;
//         y = y + (130*i);
//         var yMeas = (y/16) + "em";

//         //drawing the squares
//         svg.append('rect')
//           .attr('x', xMeas)
//           .attr('y', yMeas)
//           .attr('class',altFormlower(count))
//           .attr('class',"sinnoh")
//           .attr('width', (115/16) + "em")
//           .attr('height',(115/16) + "em")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2');

//         var xID = 55;
//         xID = xID + (130*j);
//         var xMeasID = (xID/16) + "em";

//         //y-position
//         var yID = 35;
//         yID = yID + (130*i);
//         var yMeasID = (yID/16) + "em";
        
//         svg.append('text')
//           .attr('x', xMeasID)
//           .attr('y', yMeasID)
//           .attr('class',"sinnoh")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2')
//           .text(data[count].Pokemon_ID);


//         var xName = 30;
//         xName = xName + (130*j);
//         var xMeasName = (xName/16) + "em";

//         //y-position
//         var yName = 115;
//         yName = yName + (130*i);
//         var yMeasName = (yName/16) + "em";
        
//           svg.append('text')
//             .attr('x', xMeasName)
//             .attr('y', yMeasName)
//             .attr('class',"sinnoh")
//             .attr('font-size', "12pt")
//             .attr('stroke', 'black')
//             .attr('fill', '#69a3b2')
//             .text(altForm(count));

//         var xSprite = 30;
//         xSprite = xSprite + (130*j);
//         var xMeasSprite = (xName/16) + "em";

//         //y-position
//         var ySprite = 35;
//         ySprite = ySprite + (130*i);
//         var yMeasSprite = (ySprite/16) + "em";
            
//         svg.append('image')
//           .attr('x', xMeasSprite)
//           .attr('y', yMeasSprite)
//           .attr('class',"sinnoh")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('href','sprites/' + altFormlower(count) + '.png')
            

//       count++; 
//           if (x + (130 * j)==1610) { x= 10; }
//       }
      
//     }

//Unova
// var height = "165em";
// var svg = d3.select("#dex").append("svg").attr("width", width).attr("height", height);
//         var count = 542;
//   // Add the path using this helper function
//       for (let i = 0; i <= 20; i++) {
//         for (let j = 0; j < 9; j++) {  
        
//         if (count >= 718) { break; }
        
//         //x-position
//         var x = 10;
//         x = x + (130*j);
//         var xMeas = (x/16) + "em";

//         //y-position
//         var y = 10;
//         y = y + (130*i);
//         var yMeas = (y/16) + "em";

//         //drawing the squares
//         svg.append('rect')
//           .attr('x', xMeas)
//           .attr('y', yMeas)
//           .attr('class',altFormlower(count))
//           .attr('class',"unova")
//           .attr('width', (115/16) + "em")
//           .attr('height',(115/16) + "em")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2');

//         var xID = 55;
//         xID = xID + (130*j);
//         var xMeasID = (xID/16) + "em";

//         //y-position
//         var yID = 35;
//         yID = yID + (130*i);
//         var yMeasID = (yID/16) + "em";
        
//         svg.append('text')
//           .attr('x', xMeasID)
//           .attr('y', yMeasID)
//           .attr('class',"unova")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2')
//           .text(data[count].Pokemon_ID);


//         var xName = 30;
//         xName = xName + (130*j);
//         var xMeasName = (xName/16) + "em";

//         //y-position
//         var yName = 115;
//         yName = yName + (130*i);
//         var yMeasName = (yName/16) + "em";
        
//           svg.append('text')
//             .attr('x', xMeasName)
//             .attr('y', yMeasName)
//             .attr('class',"unova")
//             .attr('font-size', "12pt")
//             .attr('stroke', 'black')
//             .attr('fill', '#69a3b2')
//             .text(altForm(count));

//         var xSprite = 30;
//         xSprite = xSprite + (130*j);
//         var xMeasSprite = (xName/16) + "em";

//         //y-position
//         var ySprite = 35;
//         ySprite = ySprite + (130*i);
//         var yMeasSprite = (ySprite/16) + "em";
            
//         svg.append('image')
//           .attr('x', xMeasSprite)
//           .attr('y', yMeasSprite)
//           .attr('class',"unova")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('href','sprites/' + altFormlower(count) + '.png')
            

//       count++; 
//           if (x + (130 * j)==1610) { x= 10; }
//       }
      
//     }

//Kalos
// var height = "82em";
// var svg = d3.select("#dex").append("svg").attr("width", width).attr("height", height);
//         var count = 718;
//   // Add the path using this helper function
//       for (let i = 0; i <= 20; i++) {
//         for (let j = 0; j < 9; j++) {  
        
//         if (count >= 808) { break; }
        
//         //x-position
//         var x = 10;
//         x = x + (130*j);
//         var xMeas = (x/16) + "em";

//         //y-position
//         var y = 10;
//         y = y + (130*i);
//         var yMeas = (y/16) + "em";

//         //drawing the squares
//         svg.append('rect')
//           .attr('x', xMeas)
//           .attr('y', yMeas)
//           .attr('class',altFormlower(count))
//           .attr('class',"kalos")
//           .attr('width', (115/16) + "em")
//           .attr('height',(115/16) + "em")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2');

//         var xID = 55;
//         xID = xID + (130*j);
//         var xMeasID = (xID/16) + "em";

//         //y-position
//         var yID = 35;
//         yID = yID + (130*i);
//         var yMeasID = (yID/16) + "em";
        
//         svg.append('text')
//           .attr('x', xMeasID)
//           .attr('y', yMeasID)
//           .attr('class',"kalos")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2')
//           .text(data[count].Pokemon_ID);


//         var xName = 30;
//         xName = xName + (130*j);
//         var xMeasName = (xName/16) + "em";

//         //y-position
//         var yName = 115;
//         yName = yName + (130*i);
//         var yMeasName = (yName/16) + "em";
        
//           svg.append('text')
//             .attr('x', xMeasName)
//             .attr('y', yMeasName)
//             .attr('class',"kalos")
//             .attr('font-size', "12pt")
//             .attr('stroke', 'black')
//             .attr('fill', '#69a3b2')
//             .text(altForm(count));

//         var xSprite = 30;
//         xSprite = xSprite + (130*j);
//         var xMeasSprite = (xName/16) + "em";

//         //y-position
//         var ySprite = 35;
//         ySprite = ySprite + (130*i);
//         var yMeasSprite = (ySprite/16) + "em";
            
//         svg.append('image')
//           .attr('x', xMeasSprite)
//           .attr('y', yMeasSprite)
//           .attr('class',"kalos")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('href','sprites/' + altFormlower(count) + '.png')
            

//       count++; 
//           if (x + (130 * j)==1610) { x= 10; }
//       }
      
//     }

//Region Unknown
// var height = "8em";
// var svg = d3.select("#dex").append("svg").attr("width", width).attr("height", height);
//         var count = 808;
//   // Add the path using this helper function
//       for (let i = 0; i <= 20; i++) {
//         for (let j = 0; j < 9; j++) {  
        
//         if (count >= 810) { break; }
        
//         //x-position
//         var x = 10;
//         x = x + (130*j);
//         var xMeas = (x/16) + "em";

//         //y-position
//         var y = 10;
//         y = y + (130*i);
//         var yMeas = (y/16) + "em";

//         //drawing the squares
//         svg.append('rect')
//           .attr('x', xMeas)
//           .attr('y', yMeas)
//           .attr('class',altFormlower(count))
//           .attr('class',"runkown")
//           .attr('width', (115/16) + "em")
//           .attr('height',(115/16) + "em")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2');

//         var xID = 55;
//         xID = xID + (130*j);
//         var xMeasID = (xID/16) + "em";

//         //y-position
//         var yID = 35;
//         yID = yID + (130*i);
//         var yMeasID = (yID/16) + "em";
        
//         svg.append('text')
//           .attr('x', xMeasID)
//           .attr('y', yMeasID)
//           .attr('class',"runknown")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2')
//           .text(data[count].Pokemon_ID);


//         var xName = 30;
//         xName = xName + (130*j);
//         var xMeasName = (xName/16) + "em";

//         //y-position
//         var yName = 115;
//         yName = yName + (130*i);
//         var yMeasName = (yName/16) + "em";
        
//           svg.append('text')
//             .attr('x', xMeasName)
//             .attr('y', yMeasName)
//             .attr('class',"runknown")
//             .attr('font-size', "12pt")
//             .attr('stroke', 'black')
//             .attr('fill', '#69a3b2')
//             .text(altForm(count));

//         var xSprite = 30;
//         xSprite = xSprite + (130*j);
//         var xMeasSprite = (xName/16) + "em";

//         //y-position
//         var ySprite = 35;
//         ySprite = ySprite + (130*i);
//         var yMeasSprite = (ySprite/16) + "em";
            
//         svg.append('image')
//           .attr('x', xMeasSprite)
//           .attr('y', yMeasSprite)
//           .attr('class',"runknown")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('href','sprites/' + altFormlower(count) + '.png')
            

//       count++; 
//           if (x + (130 * j)==1610) { x= 10; }
//       }
      
//     }

//Galar
// var height = "90em";
// var svg = d3.select("#dex").append("svg").attr("width", width).attr("height", height);
//         var count = 810;
//   // Add the path using this helper function
//       for (let i = 0; i <= 20; i++) {
//         for (let j = 0; j < 9; j++) {  
        
//         if (count >= 908) { break; }
        
//         //x-position
//         var x = 10;
//         x = x + (130*j);
//         var xMeas = (x/16) + "em";

//         //y-position
//         var y = 10;
//         y = y + (130*i);
//         var yMeas = (y/16) + "em";

//         //drawing the squares
//         svg.append('rect')
//           .attr('x', xMeas)
//           .attr('y', yMeas)
//           .attr('class',altFormlower(count))
//           .attr('class',"galar")
//           .attr('width', (115/16) + "em")
//           .attr('height',(115/16) + "em")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2');

//         var xID = 55;
//         xID = xID + (130*j);
//         var xMeasID = (xID/16) + "em";

//         //y-position
//         var yID = 35;
//         yID = yID + (130*i);
//         var yMeasID = (yID/16) + "em";
        
//         svg.append('text')
//           .attr('x', xMeasID)
//           .attr('y', yMeasID)
//           .attr('class',"galar")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('fill', '#69a3b2')
//           .text(data[count].Pokemon_ID);


//         var xName = 30;
//         xName = xName + (130*j);
//         var xMeasName = (xName/16) + "em";

//         //y-position
//         var yName = 115;
//         yName = yName + (130*i);
//         var yMeasName = (yName/16) + "em";
        
//           svg.append('text')
//             .attr('x', xMeasName)
//             .attr('y', yMeasName)
//             .attr('class',"galar")
//             .attr('font-size', "12pt")
//             .attr('stroke', 'black')
//             .attr('fill', '#69a3b2')
//             .text(altForm(count));

//         var xSprite = 30;
//         xSprite = xSprite + (130*j);
//         var xMeasSprite = (xName/16) + "em";

//         //y-position
//         var ySprite = 35;
//         ySprite = ySprite + (130*i);
//         var yMeasSprite = (ySprite/16) + "em";
            
//         svg.append('image')
//           .attr('x', xMeasSprite)
//           .attr('y', yMeasSprite)
//           .attr('class',"galar")
//           .attr('font-size', "12pt")
//           .attr('stroke', 'black')
//           .attr('href','sprites/' + altFormlower(count) + '.png')
            

//       count++; 
//           if (x + (130 * j)==1610) { x= 10; }
//       }
      
//     }

//All
var height = "1500em";
var svg = d3.select("#dex").append("svg").attr("width", width).attr("height", height);
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
          .attr('stroke', 'black')
          .attr('fill', '#69a3b2');

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
          .attr('fill', '#69a3b2')
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
            .attr('fill', '#69a3b2')
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