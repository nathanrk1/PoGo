<!DOCTYPE html>
<meta charset="utf-8" />
<style>
  path {
    stroke: #fff;
  }
</style>
<body>

<!-- connect to database -->
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

    //setting the data to sql
    $sql = "SELECT Data_ID, Form, Pokemon_ID, Pokemon_Name, Max_CP, Pokemon_Type FROM PokemonGOStats";

    //make the recursive statement for the hierarchy or something


    // echo ($sql);
    // // exit();
    $result = $conn->query($sql);

    while($row = mysqli_fetch_assoc($result))
    $transfer[] = $row; 
    $json_array = json_encode($transfer);
    
  ?>
  <script src="https://d3js.org/d3.v4.min.js"></script>
  <script>

    var width = 960,
      height = 700,
      radius = Math.min(width, height) / 2 - 10;

    var formatNumber = d3.format(",d");

    var x = d3.scaleLinear().range([0, 2 * Math.PI]);

    var y = d3.scaleSqrt().range([0, radius]);

    var color = d3.scaleOrdinal(d3.schemeCategory20);

    var partition = d3.partition();

    var arc = d3
      .arc()
      .startAngle(function (d) {
        return Math.max(0, Math.min(2 * Math.PI, x(d.x0)));
      })
      .endAngle(function (d) {
        return Math.max(0, Math.min(2 * Math.PI, x(d.x1)));
      })
      .innerRadius(function (d) {
        return Math.max(0, y(d.y0));
      })
      .outerRadius(function (d) {
        return Math.max(0, y(d.y1));
      });
      var data= <?php echo $json_array; ?>;
    
    //cleaning the type data for graph
    function cleanType1(x){
      var tempType = x.Pokemon_Type.split(', ');
      var tempTypeFinal1 = tempType[0].replace("[","").replace("'","").replace("'","").replace("]","");
      return tempTypeFinal1;
    }

    function cleanType2(x){
      var commasearch = x.Pokemon_Type.search(",");

      if(commasearch == -1){
        return "";
      }
      else{
      var tempType = x.Pokemon_Type.split(', ');
      var tempTypeFinal2 = tempType[1].replace("[","").replace("'","").replace("'","").replace("]","");
      return tempTypeFinal2;
      }
    }

    var typearray = []; 

    for(i=0; i<data.length; i++){
      var item = data[i];   
      typearray.push({ 
          "name" : item.Data_ID,
          "children"  : [{
              "Type1": cleanType1(item),
              "Type2": cleanType2(item)}]
        });
      };

    var svg = d3
      .select("body")
      .append("svg")
      .attr("width", width)
      .attr("height", height)
      .append("g")
      .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

    // d3.json(
    //   "https://gist.githubusercontent.com/mbostock/4348373/raw/85f18ac90409caa5529b32156aa6e71cf985263f/flare.json",
    //   function (error, root) {  
    //     if (error) throw error;
        root = d3.hierarchy(typearray);
        console.log(root);
        root.sum(function (d) {
          return d.size;
        });
        svg
          .selectAll("path")
          .data(partition(root).descendants())
          .enter()
          .append("path")
          .attr("d", arc)
          .style("fill", function (d) {
            return color((d.children ? d : d.parent).data.name);
          })
          .on("click", click)
          .append("title")
          .text(function (d) {
            return d.data.name + "\n" + formatNumber(d.value);
          });
    //   }
    // );

    function click(d) {
      svg
        .transition()
        .duration(750)
        .tween("scale", function () {
          var xd = d3.interpolate(x.domain(), [d.x0, d.x1]),
            yd = d3.interpolate(y.domain(), [d.y0, 1]),
            yr = d3.interpolate(y.range(), [d.y0 ? 20 : 0, radius]);
          return function (t) {
            x.domain(xd(t));
            y.domain(yd(t)).range(yr(t));
          };
        })
        .selectAll("path")
        .attrTween("d", function (d) {
          return function () {
            return arc(d);
          };
        });
    }

    d3.select(self.frameElement).style("height", height + "px");
  </script>
</body>
