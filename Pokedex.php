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
      
  </div>
      
  <script src="https://d3js.org/d3.v7.min.js"></script>
  <script src="js/jquery-3.6.0.min.js"></script>
  <script>

        var data = <?php echo $json_array; ?>;
        // console.log(data[1].Pokemon_Name);

    
        var height = "168.75em";
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
        combined.replace(". ","-");
        return combined.toLowerCase();
      }
      else{
        var mon =data[x].Pokemon_Name.toLowerCase();
        mon.replace(". ","-");
        return data[x].Pokemon_Name.toLowerCase();
      }
    }
  
  //kanto
        var svg = d3.select("#dex").append("svg").attr("width", width).attr("height", height);
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
          .attr('class',"kanto")
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
            .attr('class',"kanto")
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
          .attr('class',"kanto")
          .attr('font-size', "12pt")
          .attr('stroke', 'black')
          .attr('href','sprites/' + altFormlower(count) + '.png')
            

      count++; 
          if (x + (130 * j)==1610) { x= 10; }
      }
      
    }

//johto
// var height = "100em";
//   var svg = d3.select("#dex").append("svg").attr("width", width).attr("height", height);
//         var count = 179;
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
//           .attr('class',data[count].Pokemon_Name.toLowerCase())
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
//             .text(data[count].Pokemon_Name);

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
//           .attr('href','sprites/' + (data[count].Pokemon_Name.toLowerCase() + '.png'))
            

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
  </script>
</body>
</html>