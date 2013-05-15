<?php
//Connect to database
$con=mysqli_connect("localhost","root","","test");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
 
else
 {
 $timestamp = mktime(0, 0, 0, 8, 31, 2010);
 echo date("F Y", $timestamp);
 $val = date("Y-m-d", $timestamp )."T18:30:00";
 $result = mysqli_query($con,"SELECT * FROM content_field_date_event
WHERE field_date_event_value='$val'");
 $req = mysqli_fetch_array($result);
 $val1 = $req['vid'];
 $val2 = $req['nid'];
 $res1 = mysqli_query($con,"SELECT * FROM content_type_event
WHERE vid='$val1' AND nid = '$val2'");
 $rw = mysqli_fetch_array($res1);
 //print_r ($rw);
 //echo '<br/><br/>';
 $res2 = mysqli_query($con,"SELECT * FROM node
WHERE vid='$val1' AND nid= '$val2' AND type= 'event'");
 $rw2 = mysqli_fetch_array($res2);
 if($rw2) { echo $val1.' '.$val2.' '.$rw2['title'].' '.$rw['field_venue_value'].' '.$rw['field_time_value'].'<br/>';}
 
 }
 
 mysqli_close($con);
?>