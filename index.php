<?php
  
//Get number of days in current month
if(isset($_POST["mon"]))
	$month = $_POST["mon"];
else
	$month = date('m');

if(isset($_POST["year"]))
	$year = $_POST["year"];
else
	$year = 2011;

$num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$in = 1;

//Connect to database
$con=mysqli_connect("localhost","root","","test");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

else{

		//I will have to pass javascript from here only
		echo '<script type="text/javascript">
					var cal_month = '.$month.';
					var cal_year = '.$year.';
					$(".live-tile, .flip-list").not(".exclude").liveTile({pauseOnHover:true});	
				</script>';
				
		$timestamp = mktime(0, 0, 0, $month, $in, $year);
		echo '<header>
        <div class="site-title"><p id="top-date">'.date("F Y",$timestamp).'</p></div>
    </header>';
		//Now the html elements being generated
		echo '<div class="tiles blue tile-group eight-wide">';
		while($in <= $num)
		{
			//Back-end stuff..............
			 $val = date("Y-m-d",mktime(0, 0, 0, $month, $in, $year))."T18:30:00";
			 $result = mysqli_query($con,"SELECT * FROM content_field_date_event WHERE field_date_event_value='$val'");
			 $req = mysqli_fetch_array($result);
			 $val1 = $req['vid'];
			 $val2 = $req['nid'];
			 $res1 = mysqli_query($con,"SELECT * FROM content_type_event WHERE vid='$val1' AND nid = '$val2'");
			 $rw = mysqli_fetch_array($res1); //Gets me the venue and time
			 $res2 = mysqli_query($con,"SELECT * FROM node WHERE vid='$val1' AND nid= '$val2' AND type= 'event'");
			 $rw2 = mysqli_fetch_array($res2); //Gets me the name of the event
			if ($rw2)
			{
				echo '<div class="live-tile" data-mode="flip" data-delay="'.rand(4000,6000).'">
						
						<div><p style="font:50px Verdana; color:white; text-align:center">'.$in.'</p></div>
						<div><p>'.$rw2['title'].'<br/>'.$rw['field_venue_value'].'<br/>'.$rw['field_time_value'].'<br/></p></div>
					</div>';
			}
			
			
			else if ($in % 8 == 0)
			{	
				echo '<div class="live-tile accent green exclude">
						
						<p style="font:50px Verdana; color:white; text-align:center">'.$in.'</p>
					</div>';
				echo '</div>'; //Close the old group
				echo '<div class="tiles blue tile-group eight-wide">'; //initialise a new row
			}
			else
			{
				echo '<div class="live-tile accent green exclude">
						
						<p style="font:50px Verdana; color:white; text-align:center">'.$in.'</p>
					</div>';
			}
			$in++;
		}
		echo '</div>'; //Close the last eight vala row
}
?>