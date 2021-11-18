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

  $result = $conn->query($sql);

  ?>