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
    $sql = "SELECT Form, Pokemon_ID, Pokemon_Name, 'Max_CP' FROM PokemonGOMaxCP";
    // echo ($sql);
    // // exit();
    $result = $conn->query($sql);

    while($row = mysqli_fetch_assoc($result))
    $transfer[] = $row; 
    $json_array = json_encode($transfer);
  ?>
  
  <div id="rect">
      <svg></svg>
  </div>
      
  <script src="https://d3js.org/d3.v7.min.js"></script>
  <script src="js/jquery-3.6.0.min.js"></script>
  <script>

        var data = <?php echo $json_array; ?>;
        // console.log(data[1].Pokemon_Name);


        var height = "168.75em";
        var width = "100%";
        
        var svg = d3.select("#rect").append("svg").attr("width", width).attr("height", height);
        var count = 0;
  // Add the path using this helper function
      for (let i = 0; i <= 20; i++) {
        for (let j = 0; j < 9; j++) {  
        
        
        //console.log(count)
        if (count >= 178) { break; }
              
        var x = 10;
        x = x + (130*j);
        var xMeas = (x/16) + "em"

        var y = 10;
        y = y + (130*i);
        var yMeas = (y/16) + "em"

        svg.append('rect')
          .attr('x', xMeas)
          .attr('y', yMeas)
          .attr('width', (115/16) + "em")
          .attr('height',(115/16) + "em")
          .attr('stroke', 'black')
          .attr('fill', '#69a3b2');

      count++; 
          if (x + (130 * j)==1610) { x= 10; }
      }
      
    }
  </script>
</body>
</html>