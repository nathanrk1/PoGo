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

<head> 
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.js"></script> 
   </head> 
   <body> 
      <canvas id="myChart" width="400" height="400"></canvas> 
      <script>
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

    function addAlpha(color, opacity) {
      // coerce values so ti is between 0 and 1.
      var _opacity = Math.round(Math.min(Math.max(opacity || 1, 0), 1) * 255);
      return color + _opacity.toString(16).toUpperCase();
    }
// addAlpha('FF0000', 1); // returns 'FF0000FF'
// addAlpha('FF0000', 0.5); // returns 'FF000080'
      
    var normal = 0;

    var water = 0;

    var electric = 0;

    var grass = 0;

    var ice = 0;

    var fighting = 0;

    var poison = 0;

    var ground = 0;

    var flying = 0;

    var psychic = 0;

    var bug = 0;

    var rock = 0;

    var ghost = 0;

    var dragon = 0;
       
    var steel = 0;

    var fairy = 0;

    for(i=0; i<data.length; i++){
      var item = data[i];

      //normal
      if(cleanType1(item) == "Normal"){
        normal = normal + 1;
      }
      if(cleanType2(item) == "Normal"){
        normal = normal + 1;
      }

      //water
      if(cleanType1(item) == "Water"){
        water = water + 1;
      }
      if(cleanType2(item) == "Water"){
        water = water + 1;
      }

      //electric
      if(cleanType1(item) == "Electric"){
        electric = electric + 1;
      }
      if(cleanType2(item) == "Electric"){
        electric = electric + 1;
      }

      //grass
      if(cleanType1(item) == "Grass"){
        grass = grass + 1;
      }
      if(cleanType2(item) == "Grass"){
        grass = grass + 1;
      }

      //ice
      if(cleanType1(item) == "Ice"){
        ice = ice + 1;
      }
      if(cleanType2(item) == "Ice"){
        ice = ice + 1;
      }
      
      //fighting
      if(cleanType1(item) == "Fighting"){
        fighting = fighting + 1;
      }
      if(cleanType2(item) == "Fighting"){
        fighting = fighting + 1;
      }

      //poison
      if(cleanType1(item) == "Poison"){
        poison = poison + 1;
      }
      if(cleanType2(item) == "Poison"){
        poison = poison + 1;
      }

      //ground
      if(cleanType1(item) == "Ground"){
        ground = ground + 1;
      }
      if(cleanType2(item) == "Ground"){
        ground = ground + 1;
      }

      //flying
      if(cleanType1(item) == "Flying"){
        flying = flying + 1;
      }
      if(cleanType2(item) == "Flying"){
        flying = flying + 1;
      }

      //psychic
      if(cleanType1(item) == "Psychic"){
        psychic = psychic + 1;
      }
      if(cleanType2(item) == "Psychic"){
        psychic = psychic + 1;
      }

        //bug
       if(cleanType1(item) == "Bug"){
        bug = bug + 1;
      }
      if(cleanType2(item) == "Bug"){
        bug = bug + 1;
      }

      //rock
      if(cleanType1(item) == "Rock"){
        rock = rock + 1;
      }
      if(cleanType2(item) == "Rock"){
        rock = rock + 1;
      }

      //ghost
      if(cleanType1(item) == "Ghost"){
        ghost = ghost + 1;
      }
      if(cleanType2(item) == "Ghost"){
        ghost = ghost + 1;
      }

      //dragon
      if(cleanType1(item) == "Dragon"){
        dragon = dragon + 1;
      }
      if(cleanType2(item) == "Dragon"){
        dragon = dragon + 1;
      }

      //steel
      if(cleanType1(item) == "Steel"){
        steel = steel + 1;
      }
      if(cleanType2(item) == "Steel"){
        steel = steel + 1;
      }

      //fairy
      if(cleanType1(item) == "Fairy"){
        fairy = fairy + 1;
      }
      if(cleanType2(item) == "Fairy"){
        fairy = fairy + 1;
      }

    };

     // typearray.push({ 
        //     "name" : item.Data_ID, // data id
        //     "color": typeColor(cleanType1(item)), //type
        //     "value": item.Max_CP, //max cp
        //     "label": item.Pokemon_Name //pokemon name
        // })

      // Get the context of the canvas element we want to select
var data = [// w  w w  . j  a  v  a  2s . c  om
    {
        value: normal,
        color:typeColor('Normal'),
        highlight: addAlpha(typeColor('Normal'),.6),
        label: "Normal"
    },
    {
        value: water,
        color: typeColor('Water'),
        highlight: addAlpha(typeColor('Water'),.6),
        label: "Water"
    },
    {
        value: electric,
        color: typeColor('Electric'),
        highlight: addAlpha(typeColor('Electric'),.6),
        label: "Electric"
    },
    {
        value: grass,
        color: typeColor('Grass'),
        highlight: addAlpha(typeColor('Grass'),.6),
        label: "Grass"
    },
    {
        value: ice,
        color: typeColor('Ice'),
        highlight: addAlpha(typeColor('Ice'),.6),
        label: "Ice"
    },
    {
        value: fighting,
        color:typeColor('Fighting'),
        highlight: addAlpha(typeColor('Fighting'),.6),
        label: "Fighting"
    },
    {
        value: poison,
        color: typeColor('Poison'),
        highlight: addAlpha(typeColor('Poison'),.6),
        label: "Poison"
    },
    {
        value: ground,
        color: typeColor('Ground'),
        highlight: addAlpha(typeColor('Ground'),.6),
        label: "Ground"
    },
    {
        value: flying,
        color: typeColor('Flying'),
        highlight: addAlpha(typeColor('Flying'),.6),
        label: "Flying"
    },
    {
        value: psychic,
        color: typeColor('Psychic'),
        highlight: addAlpha(typeColor('Psychic'),.6),
        label: "Psychic"
    },
    {
        value: bug,
        color: typeColor('Bug'),
        highlight: addAlpha(typeColor('Bug'),.6),
        label: "Bug"
    },
    {
        value: rock,
        color:typeColor('Rock'),
        highlight: addAlpha(typeColor('Rock'),.6),
        label: "Rock"
    },
    {
        value: ghost,
        color: typeColor('Ghost'),
        highlight: addAlpha(typeColor('Ghost'),.6),
        label: "Ghost"
    },
    {
        value: dragon,
        color: typeColor('Dragon'),
        highlight: addAlpha(typeColor('Dragon'),.6),
        label: "Dragon"
    },
    {
        value: steel,
        color: typeColor('Steel'),
        highlight: addAlpha(typeColor('Steel'),.6),
        label: "Steel"
    },
    {
        value: fairy,
        color: typeColor('Fairy'),
        highlight: addAlpha(typeColor('Fairy'),.6),
        label: "Fairy"
    }
];
var ctx = document.getElementById("myChart").getContext("2d");
var myNewChart = new Chart(ctx).PolarArea(data);
    
      </script>  
   </body>