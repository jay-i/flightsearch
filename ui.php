<?php


if(isset($_POST['search'])){



	$departure_city = $_POST['departure_city'];
	$destination_city = $_POST['destination_city'];
	$departure_date = $_POST['departure_date'];
	$return_date = $_POST['return_date'];
	$cabin = $_POST['cabin'];
	$no_of_adult = $_POST['no_of_adult'];
	$no_of_child = $_POST['no_of_child'];
	$no_of_infant = $_POST['no_of_infant'];
	
	

	if(empty($departure_city))
	{
		echo "<div style='color: tomato;'>Please enter Departure City</div>";
	}
	else if(empty($destination_city))
	{
		echo "<div style='color: tomato;'>Please enter Destination City</div>";
	}
	else if(empty($departure_date))
	{
		echo "<div style='color: tomato;'>Please enter Departure Date</div>";
	}
	else if(empty($return_date))
	{
		echo "<div style='color: tomato;'>Please enter Return Date</div>";
	}
	else if(empty($cabin))
	{
		echo "<div style='color: tomato;'>Please Select a Cabin</div>";
	}
	else if(empty($no_of_adult))
	{
		echo "<div style='color: tomato;'>Please enter Number of Adult </div>";
	}
	else if(empty($no_of_child))
	{
		echo "<div style='color: tomato;'>Please enter Number of Children </div>";
	}
	else if(empty($no_of_infant))
	{
		echo "<div style='color: tomato;'>Please enter Number of Infant </div>";
	}
	else
	{



echo "<pre>";
	print_r($_POST);
echo "</pre>";
	

	header('Access-Control-Allow-Origin: *');
	header('Content-Type: text/html');
	
$url = 'http://www.ije-api.tcore.xyz/v1/flight/search-flight';

$postdata = '{
    "header": {
        "cookie": "ayaeh33y1nw4yjtm3fdr0gzq"
    },
    "body": {
        "origin_destinations": [
            {
                "departure_city": "' . $departure_city . '",
                "destination_city": "' . $destination_city . '",
                "departure_date": "' . $departure_date . '",
                "return_date": "' . $return_date . '"
            }
        ],
        "search_param": {
            "no_of_adult": ' . $no_of_adult . ',
            "no_of_child": ' . $no_of_child . ',
            "no_of_infant": ' . $no_of_infant . ',
            "preferred_airline_code" : "",
            "calendar" : false,
            "cabin": "' . $cabin . '"
        }
    }
}';

addslashes($postdata);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$result = curl_exec($ch);
curl_close($ch);
//print_r ($result);

$response_array = json_decode($result, true);

	echo "<pre>";
		print_r($response_array);
	echo "</pre>";
	
	}
}else{
	?>

<?php 				
	$filetxtc = "";
	$myfile = fopen("flight.js", "r") or die("Unable to open file!");

	// Output one character until end-of-file
	while(!feof($myfile)) {
	 $filetxtc .= fgetc($myfile);
	}
	fclose($myfile);
		//$filetxtc = htmlspecialchars($filetxtc);	
	//echo $filetxtc;
	$all_flight_array = json_decode($filetxtc, true);
	echo "<pre>";
	//	print_r($all_flight_array);
	echo "</pre>";

////////////	
	function list_element($arr, $listed_array=array()){
    if(!isset($GLOBALS['listed_array'])){
		$GLOBALS['listed_array']=array();
		$GLOBALS['codes']=array();
	}
    global $listed_array;
    foreach($arr as $key => $value){
        if(is_array($value)){
            list_element($value, $listed_array);
        }else{
			if($key === 'code' && $value != ""){
					$codes[] = $value;
			}
			if($key === 'city_name' && $value != ""){
				if(!in_array($value, $listed_array)){
					$last_code_key = count($codes)-1;
					$last_code = $codes[$last_code_key];
					$listed_array[$last_code] = $value;
				}
			}
        }        
    }
	//unset($GLOBALS['listed_array']);
    return $listed_array;
}
//////////

$new_listed = list_element($all_flight_array['body']);
?>



<link rel="stylesheet" href="css/bootstrap.css">

<div class="container">
	<h1 class="text-center">Flight Search</h1>
<form action="" method="POST">

		<div class="form-group">
			<label for="departure_city">Departure City</label>
			<select name="departure_city" class="form-control">
				<option value="">Select Departure City</option>
				<?php 
					foreach($new_listed as $code=>$city_name){
						echo "<option value='$code'>$city_name ($code)</option>";
					}
				?>
			</select>
			
		</div>
		<div class="form-group">
			<label for="destination_city">Destination Cityy</label>
			<select name="destination_city" class="form-control">
				<option value="">Select Destination City</option>
				<?php 
					foreach($new_listed as $code=>$city_name){
						echo "<option value='$code'>$city_name ($code)</option>";
					}
				?>
			</select>
			
		</div>
		<div class="form-group">
			<label for="departure_date">Departure Date</label>
			<input type="date" name="departure_date" class="form-control">
			
		</div>

		<div class="form-group">
			<label for="return_date">Return Date</label>
			<input type="date" name="return_date" class="form-control">
			
		</div>

		<div class="form-group">
			<label for="cabin">Cabin</label>
			<select name="cabin" class="form-control">
			<option value="">Select Cabin</option>
			<option>All</option>
			<option>First</option>
			<option>Economy</option>
			<option>Business</option>
			</select>
			
		</div>

		<div class="form-group">
			<label for="no_of_adult">No of Adults (> 12 yo)</label>
			<input type="number" name="no_of_adult" class="form-control">
			
		</div>
		<div class="form-group">
			<label for="no_of_child">No of Children  (2 - 12 yo)</label>
			<input type="number" name="no_of_child" class="form-control">
			
		</div>
		<div class="form-group">
			<label for="no_of_infant">No of Infants (0 - 2 yo)</label>
			<input type="number" name="no_of_infant" class="form-control">
			
		</div>
		<div class="form-group">
		<button type="submit" name="search" class="btn btn-primary">SEARCH</button>
		</div>

</div>


</form>	

<?php
echo "<pre>";
//	print_r($new_listed);
echo "</pre>";
	
}
?>