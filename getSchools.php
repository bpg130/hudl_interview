<?php

$mysqli = new mysqli('localhost','root','','hudl_interview');

if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
else { 

	//select each school from the database
	$res = $mysqli->query("Select * from schools");
	$data = array();
	while( $row = $res->fetch_assoc()){

		$school_name = $row["school_name"];

		$data[] = ["school_name"=> $row["school_name"], "lat"=>$row["lat"], "lng"=>$row["lng"]];

	}
	//foreach school in school get all of there athletes 
	foreach ($data as &$school){
		$res = $mysqli->query("select * from players where school_name = '" . $school["school_name"]."'");
		$players = array();
		while ($row_1 = $res->fetch_assoc()){
			
			$players[] = ["player_name"=>$row_1["player_name"], "grad_year"=>$row_1["grad_year"], "player_link"=>$row_1["player_link"]];
		
		}
		$school["players"] = $players;
	}
	
	echo json_encode($data);
}

?>