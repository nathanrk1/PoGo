<?php
error_reporting(E_ALL & ~E_NOTICE);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Server Connection</title>
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
echo $sql;
exit();
$result = $conn->query($sql);
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
    ['Pokemon_ID', 'Pokemon_Name'],
    <?php
      while($row = $result->fetch_assoc()) {
    echo  "['".$row["Pokemon_Name"]."',".$row["Pokemon_ID"]."],\n";
      }
    ?>
     
    ]);

    var options = {
      title: 'Pokemon GO Pokedex',
      hAxis: {title: 'Pokemon Name', minValue: 0},
      vAxis: {title: 'Pokedex Number', minValue: 0},
      legend: 'none'
    };

    var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

    chart.draw(data, options);
  }
</script>               
  </body>
  <div id="chart_div" style="width: 900px; height: 500px;"></div>
</html>
