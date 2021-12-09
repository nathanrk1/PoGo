<!DOCTYPE html>
<html>
<meta charset="utf-8">
<head>
    <meta charset="utf-8" />
    <title>Pokemon Histogram</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style type="text/css">
        body          { font-size: 16px; margin: 20px 20px; }
        .bar:hover    { fill: brown; }
        .axis--x path { display: none; }
        #polar        { position:absolute; left: 45em; }
        .histofilter  { position: absolute; top: 38em; left: 18.5em; }
        .apply_filter { position: absolute; top: 10em; left: 35em; }
        svg           { position: absolute; margin-top: 0.925em; }
        select        { margin-left: 3.750em; }
        .buttons      { display: inline-block; }
        #slider-range { position:absolute; width:12.500em; top: 10.5em; left: 6em; }
        #Type1        { position:absolute; top: 10em; }
        #Type2        { position:absolute; top: 10em; }
        div.tooltip   { position: absolute; text-align: center; font: 0.750em sans-serif; background: white; 
                      border-radius: 0.500em; pointer-events: none; width: 37.5em; height:37.5em; z-index: 2; }
        .tooltip.{
          position:absolute;
        }


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

    .button {
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
        background-color: white; 
        color: black; 
        border: 2px solid #426b67;
        width: 100px;
        height: 30px;
    }

    .button:hover {
        background-color: #426b67;
        color: white;
    }

    .dropbtn {
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        transition-duration: 0.4s;
        cursor: pointer;
        background-color: white; 
        color: black; 
        border: 2px solid #426b67;
        width: 100px;
        height: 30px;
    }

    .dropdown {
        position: relative;
        display: inline-block;
        color: black;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #426b67;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: #426b67;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {background-color: ##426b67}

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        background-color: ##426b67;
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
    $_SESSION['Type1'] = $_POST["Type1"];
    $_SESSION['Type2'] = $_POST["Type2"];

    $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats";

    //switch to dex sort
    if($_REQUEST["dex_Order"]){
      $_SESSION['Sort'] = "ID";
      $_SESSION['MinCP'] = $_POST["CPMin"];
        $_SESSION['MaxCP'] = $_POST["CPMax"];
        $_SESSION['Type1'] = $_POST["Type1"];
        $_SESSION['Type2'] = $_POST["Type2"];
        
        //normal filter
        if ($_SESSION['Type1'] == "- Type 1 -" & $_SESSION['Type2'] == "- Type 2 -"){
          //for id sort
          if($_SESSION['Sort'] == "ID"){
            $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
          }

          //for type sort
          if($_SESSION['Sort'] == "Type"){
            $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
          }

          //for CP sort
          if($_SESSION['Sort'] == "CP"){
            $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
          }

      }//end normal filter 

      //only Type 1
      if ($_SESSION['Type1'] != "- Type 1 -" & $_SESSION['Type2'] == "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end only Type1 filter 

      //only Type 2
      if ($_SESSION['Type1'] == "- Type 1 -" & $_SESSION['Type2'] != "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end only Type 2 filter 

      //Both Types
      if ($_SESSION['Type1'] != "- Type 1 -" & $_SESSION['Type2'] != "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end Both Types filter 
      
    }//end dex sort

    //switch to type sort
    if($_REQUEST["type_Order"]){
      $_SESSION['Sort'] = "Type";
      $_SESSION['MinCP'] = $_POST["CPMin"];
        $_SESSION['MaxCP'] = $_POST["CPMax"];
        $_SESSION['Type1'] = $_POST["Type1"];
        $_SESSION['Type2'] = $_POST["Type2"];
        
        //normal filter
        if ($_SESSION['Type1'] == "- Type 1 -" & $_SESSION['Type2'] == "- Type 2 -"){
          //for id sort
          if($_SESSION['Sort'] == "ID"){
            $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
          }

          //for type sort
          if($_SESSION['Sort'] == "Type"){
            $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
          }

          //for CP sort
          if($_SESSION['Sort'] == "CP"){
            $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
          }

      }//end normal filter 

      //only Type 1
      if ($_SESSION['Type1'] != "- Type 1 -" & $_SESSION['Type2'] == "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end only Type1 filter 

      //only Type 2
      if ($_SESSION['Type1'] == "- Type 1 -" & $_SESSION['Type2'] != "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end only Type 2 filter 

      //Both Types
      if ($_SESSION['Type1'] != "- Type 1 -" & $_SESSION['Type2'] != "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end Both Types filter 
    }//end type sort

    //switch to cp sort
    if($_REQUEST["CP_Order"]){
      $_SESSION['Sort'] = "CP";
      $_SESSION['MinCP'] = $_POST["CPMin"];
        $_SESSION['MaxCP'] = $_POST["CPMax"];
        $_SESSION['Type1'] = $_POST["Type1"];
        $_SESSION['Type2'] = $_POST["Type2"];
        
        //normal filter
        if ($_SESSION['Type1'] == "- Type 1 -" & $_SESSION['Type2'] == "- Type 2 -"){
          //for id sort
          if($_SESSION['Sort'] == "ID"){
            $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
          }

          //for type sort
          if($_SESSION['Sort'] == "Type"){
            $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
          }

          //for CP sort
          if($_SESSION['Sort'] == "CP"){
            $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
          }

      }//end normal filter 

      //only Type 1
      if ($_SESSION['Type1'] != "- Type 1 -" & $_SESSION['Type2'] == "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end only Type1 filter 

      //only Type 2
      if ($_SESSION['Type1'] == "- Type 1 -" & $_SESSION['Type2'] != "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end only Type 2 filter 

      //Both Types
      if ($_SESSION['Type1'] != "- Type 1 -" & $_SESSION['Type2'] != "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end Both Types filter 
      
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
            $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
          }

          //for type sort
          if($_SESSION['Sort'] == "Type"){
            $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
          }

          //for CP sort
          if($_SESSION['Sort'] == "CP"){
            $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
          }

      }//end normal filter 

      //only Type 1
      if ($_SESSION['Type1'] != "- Type 1 -" & $_SESSION['Type2'] == "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end only Type1 filter 

      //only Type 2
      if ($_SESSION['Type1'] == "- Type 1 -" & $_SESSION['Type2'] != "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
        }
      }//end only Type 2 filter 

      //Both Types
      if ($_SESSION['Type1'] != "- Type 1 -" & $_SESSION['Type2'] != "- Type 2 -"){
        //for id sort
        if($_SESSION['Sort'] == "ID"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP'].";";
        }

        //for type sort
        if($_SESSION['Sort'] == "Type"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Pokemon_Type ASC";
        }

        //for CP sort
        if($_SESSION['Sort'] == "CP"){
          $sql = "SELECT Data_ID, Form, Attack, Defense, Stamina, Catch_Rate, Buddy_Distance, Max_CP, Pokemon_ID, Pokemon_Name, Pokemon_Type FROM PokemonGOStats WHERE Pokemon_Type LIKE '%".$_SESSION['Type1']."%' AND Pokemon_Type LIKE '%".$_SESSION['Type2']."%' AND Max_CP BETWEEN ".$_SESSION['MinCP']." AND ".$_SESSION['MaxCP']." "."ORDER BY Max_CP ASC";
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.js"></script> 

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

<ul>
        <li><a id="home" href="index.html"><img src="images/aipomoutline.png" height="45em"/></a></li>
        <li><a href="Pokedex.php">Pokedex</a></li>
        <li><a href="summary.php">Dashboard</a></li>
    </ul>

<p style="left:5em; position:relative;">
  <label for="amount">CP Range:</label>
  <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
</p>
 
<div id="slider-range"></div>
<svg id="SVGdiv" width="800" height="440" style="left:55px;"></svg>
<div id="bars">
<form class="buttons" id="apply_filter" method="post" action="summary.php">
      <input class="button" onclick="callfunctions();" class="apply_filter" name="apply_filter" type="submit" value="Apply" style="top: 10em; left:46em; position:absolute;">
      <div class="histofilter">
        <input class="button" onclick="callfunctions();" name="dex_Order" type="submit" value="Pokemon ID">
        <input class="button" onclick="callfunctions();" name="type_Order" type="submit" value="Type" >
        <input class="button" onclick="callfunctions();" name="CP_Order" type="submit" value="Max CP">
      </div>

        <select name="Type2" id="Type2" class="dropbtn" style="top: 10em; left:39em; position:absolute;">
        <option id="type2base"  value="- Type 2 -">- Type 2 -</option><div class="dropdown-content">
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
        <div></select>

        <select name="Type1" id="Type1" class="dropbtn" style="top: 10em; left:32em; position:absolute;"><div class="dropdown-content">
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
        <div></select>

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
      //DETERMINES COLOR BASED ON PRIMARY TYPE
    function typeColor(x){
      if      (x =='Normal'   ){ return '#A8A77A' }
      else if (x == 'Fire'    ){ return '#EE8130' }
      else if (x == 'Water'   ){ return '#6390F0' }
      else if (x == 'Electric'){ return '#F7D02C' }
      else if (x == 'Grass'   ){ return '#7AC74C' }
      else if (x == 'Ice'     ){ return '#96D9D6' }
      else if (x == 'Fighting'){ return '#C22E28' }
      else if (x == 'Poison'  ){ return '#A33EA1' }
      else if (x == 'Ground'  ){ return '#E2BF65' }
      else if (x == 'Flying'  ){ return '#A98FF3' }
      else if (x == 'Psychic' ){ return '#F95587' }
      else if (x == 'Bug'     ){ return '#A6B91A' }
      else if (x == 'Rock'    ){ return '#B6A136' }
      else if (x == 'Ghost'   ){ return '#735797' }
      else if (x == 'Dragon'  ){ return '#6F35FC' }
      else if (x == 'Dark'    ){ return '#705746' }
      else if (x == 'Steel'   ){ return '#B7B7CE' }
      else if (x == 'Fairy'   ){ return '#D685AD' }
      else                     { return '#000'    }
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
              .attr("fill", function(d){ return typeColor(cleanType(d))})

          ////////////////////////////////////////////////////////////////////////////////////////////////
          /////////////////////////////////// TOOLTIP WITH RADAR CHART ///////////////////////////////////
          ///////////////////////////////////////////////////////////////////////////////////////////////


        //MOUSEOVER                                                 
        .on("mouseover", function(d) {		  
          tDiv.transition()		
              .duration(200)		
              .style("opacity", 1)
          tDiv.html("<div id='infoDiv'></div><div id='tipDiv'></div>")	    /// Tooltip location - h + w are determined in tooltip css
              .style("right", 15.250 + "em")		
              .style("top", 12 + "em");
              
          var tSvg = d3.select("#tipDiv")
              .append("svg")
              .attr("width", 37.5 + "em")
              .attr("height", 37.5 + "em")
              .style("left", 0)
              .style("top", 0)
              //.attr("transform", "scale(0.5,0.5)");

            
          //CONVERT CATCH RATE TO PERCENT
          function CatchRateConvert(x){
            if (x==100){
              return 100;
            }
            else{
              return x * 100;
            }
          }

          //LOAD DATA
          let features = ["Attack", "Defense", "Stamina"];
          let rdata    = [{Attack: parseInt(d.Attack), Defense: parseInt(d.Defense), Stamina: parseInt(d.Stamina)}];
          var point = {};

          //SCALE
          let radialScale = d3.scaleLinear()
            .domain([0,500])
            .range([0,250]);
          let ticks = [100,200,300,400,500];

          ticks.forEach(t =>
          tSvg.append("circle")
            .attr("cx", 230)
            .attr("cy", 240)
            .attr("fill", "none")
            .attr("stroke", "gray")
            .attr("r", radialScale(t)*.5)
          );

          ticks.forEach(t =>
          tSvg.append("text")
            .attr("x", 220)
            .attr("y", 240 - radialScale(t)*.5)
            .text(t.toString())
          );

          function angleToCoordinate(angle, value){
            let x = Math.cos(angle) * (.5* radialScale(value));
            let y = Math.sin(angle) * (.5*radialScale(value));
            return {"x": 230 + x, "y": 240 + y};
          }//END ANGLETOCOORDINATE

          for (var i = 0; i < features.length; i++) {
            let ft_name = features[i];
            let angle = (Math.PI / 2) + (2 * Math.PI * i / features.length);
            let line_coordinate = angleToCoordinate(angle, 500);
            let label_coordinate = angleToCoordinate(angle, 500.5);

            //draw axis line
            tSvg.append("line")
            .attr("x1", 230)
            .attr("y1", 240)
            .attr("x2", line_coordinate.x)
            .attr("y2", line_coordinate.y)
            .attr("stroke","black");

            //draw axis label
            tSvg.append("text")
            .attr("x", label_coordinate.x)
            .attr("y", label_coordinate.y)
            .text(ft_name);
          }//END FOR

          let line = d3.line()
            .x(d => d.x)
            .y(d => d.y);

          function getPathCoordinates(rdata_point){
            let coordinates = [];
            for (var i = 0; i < features.length; i++){
                let ft_name = features[i];
                let angle = (Math.PI / 2) + (2 * Math.PI * i / features.length);
                coordinates.push(angleToCoordinate(angle, rdata_point[ft_name]));
            }//END FOR
            return coordinates;
          }//END GETPATHCOORDINATES

          for (var i = 0; i < rdata.length; i ++){
            let d = rdata[i];
            let coordinates = getPathCoordinates(d);

            //DRAW PATH
            tSvg.append("path")
            .datum(coordinates)
            .attr("d",line)
            .attr("stroke-width", 3)
            .attr("stroke", "red")
            .attr("fill", "red")
            .attr("stroke-opacity", 1)
            .attr("opacity", 0.5);
            
          }//END FOR

          var iD = d3.select("#infoDiv")
              .append("svg")
              .attr("width", 37.500 + "em")
              .attr("height", 37.500 + "em")
              .style("left", 0)
              .style("top", 0)

            iD.append("text")
            .attr("x", 8.5 + "em")
            .attr("y", 1 + "em")
            .attr("fill", "black")
            .style("font-size", 27 +'px')
            .text(d.Pokemon_Name)
            .style("text-anchor", "middle");

            iD.append("text")
            .attr("x", 15.5 + "em")
            .attr("y", 4 + "em")
            .attr("fill", "black")
            .style("font-size", 15 +'px')
            .text("Buddy Distance: " + d.Buddy_Distance)
            .style("text-anchor", "middle");

            iD.append("text")
            .attr("x", 15.5 + "em")
            .attr("y", 5.25 + "em")
            .attr("fill", "black")
            .style("font-size", 15 +'px')
            .text("Catch Rate: " + CatchRateConvert(d.Catch_Rate))
            .style("text-anchor", "middle");

        })//END MOUSEOVER

        .on("mouseout", function(d) {
          tDiv.transition()		
            .duration(500)		
            .style("opacity", 0);

        });//END MOUSE OUT

    }); //END DOCUMENT READY	

    //TOOLTIP DIV
    var tDiv = d3.select("body").append("div")	
      .attr("class", "tooltip")		
      .attr("width", 37.500 + "em")
      .attr("height", 37.500 + "em")
      .style("opacity", 0);

    ////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////// POLAR CHART BEGIN ///////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////
    </script> 

    <canvas id="polar" width="400" height="400" style="left:925px;"></canvas> 
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

        //DETERMINES COLOR BASED ON PRIMARY TYPE
    function typeColor(x){
      if      (x =='Normal'   ){ return '#A8A77A' }
      else if (x == 'Fire'    ){ return '#EE8130' }
      else if (x == 'Water'   ){ return '#6390F0' }
      else if (x == 'Electric'){ return '#F7D02C' }
      else if (x == 'Grass'   ){ return '#7AC74C' }
      else if (x == 'Ice'     ){ return '#96D9D6' }
      else if (x == 'Fighting'){ return '#C22E28' }
      else if (x == 'Poison'  ){ return '#A33EA1' }
      else if (x == 'Ground'  ){ return '#E2BF65' }
      else if (x == 'Flying'  ){ return '#A98FF3' }
      else if (x == 'Psychic' ){ return '#F95587' }
      else if (x == 'Bug'     ){ return '#A6B91A' }
      else if (x == 'Rock'    ){ return '#B6A136' }
      else if (x == 'Ghost'   ){ return '#735797' }
      else if (x == 'Dragon'  ){ return '#6F35FC' }
      else if (x == 'Dark'    ){ return '#705746' }
      else if (x == 'Steel'   ){ return '#B7B7CE' }
      else if (x == 'Fairy'   ){ return '#D685AD' }
      else                     { return '#000'    }
    };

        function addAlpha(color, opacity) {
                // coerce values so ti is between 0 and 1.
                var _opacity = Math.round(Math.min(Math.max(opacity || 1, 0), 1) * 255);
                return color + _opacity.toString(16).toUpperCase();
              }
          // addAlpha('FF0000', 1); // returns 'FF0000FF'
          // addAlpha('FF0000', 0.5); // returns 'FF000080'
                
              var normal   = 0;
              var water    = 0;
              var electric = 0;
              var grass    = 0;
              var ice      = 0;
              var fighting = 0;
              var poison   = 0;
              var ground   = 0;
              var flying   = 0;
              var psychic  = 0;
              var bug      = 0;
              var rock     = 0;
              var ghost    = 0;
              var dragon   = 0;
              var steel    = 0;
              var fairy    = 0;

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

          var spiral = [// w  w w  . j  a  v  a  2s . c  om
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
          var ctx = document.getElementById("polar").getContext("2d");
          var myNewChart = new Chart(ctx).PolarArea(spiral);
        
    </script>  

    </body>
</html>