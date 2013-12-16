<?php 
function TimeAgo($datefrom,$dateto=-1)
{
// Defaults and assume if 0 is passed in that
// its an error rather than the epoch

if($datefrom<=0) { return "A long time ago"; }
if($dateto==-1) { $dateto = time(); }

// Calculate the difference in seconds betweeen
// the two timestamps

$difference = $dateto - $datefrom;

// If difference is less than 60 seconds,
// seconds is a good interval of choice

if($difference < 60)
{
$interval = "s";
}

// If difference is between 60 seconds and
// 60 minutes, minutes is a good interval
elseif($difference >= 60 && $difference<60*60)
{
$interval = "n";
}

// If difference is between 1 hour and 24 hours
// hours is a good interval
elseif($difference >= 60*60 && $difference<60*60*24)
{
$interval = "h";
}

// If difference is between 1 day and 7 days
// days is a good interval
elseif($difference >= 60*60*24 && $difference<60*60*24*7)
{
$interval = "d";
}

// If difference is between 1 week and 30 days
// weeks is a good interval
elseif($difference >= 60*60*24*7 && $difference <
60*60*24*30)
{
$interval = "ww";
}

// If difference is between 30 days and 365 days
// months is a good interval, again, the same thing
// applies, if the 29th February happens to exist
// between your 2 dates, the function will return
// the 'incorrect' value for a day
elseif($difference >= 60*60*24*30 && $difference <
60*60*24*365)
{
$interval = "m";
}

// If difference is greater than or equal to 365
// days, return year. This will be incorrect if
// for example, you call the function on the 28th April
// 2008 passing in 29th April 2007. It will return
// 1 year ago when in actual fact (yawn!) not quite
// a year has gone by
elseif($difference >= 60*60*24*365)
{
$interval = "y";
}

// Based on the interval, determine the
// number of units between the two dates
// From this point on, you would be hard
// pushed telling the difference between
// this function and DateDiff. If the $datediff
// returned is 1, be sure to return the singular
// of the unit, e.g. 'day' rather 'days'

switch($interval)
{
case "m":
$months_difference = floor($difference / 60 / 60 / 24 /
29);
while (mktime(date("H", $datefrom), date("i", $datefrom),
date("s", $datefrom), date("n", $datefrom)+($months_difference),
date("j", $dateto), date("Y", $datefrom)) < $dateto)
{
$months_difference++;
}
$datediff = $months_difference;

// We need this in here because it is possible
// to have an 'm' interval and a months
// difference of 12 because we are using 29 days
// in a month

if($datediff==12)
{
$datediff--;
}

$res = ($datediff==1) ? "$datediff month ago" : "$datediff
months ago";
break;

case "y":
$datediff = floor($difference / 60 / 60 / 24 / 365);
$res = ($datediff==1) ? "$datediff year ago" : "$datediff
years ago";
break;

case "d":
$datediff = floor($difference / 60 / 60 / 24);
$res = ($datediff==1) ? "$datediff day ago" : "$datediff
days ago";
break;

case "ww":
$datediff = floor($difference / 60 / 60 / 24 / 7);
$res = ($datediff==1) ? "$datediff week ago" : "$datediff
weeks ago";
break;

case "h":
$datediff = floor($difference / 60 / 60);
$res = ($datediff==1) ? "$datediff hour ago" : "$datediff
hours ago";
break;

case "n":
$datediff = floor($difference / 60);
$res = ($datediff==1) ? "$datediff minute ago" :
"$datediff minutes ago";
break;

case "s":
$datediff = $difference;
$res = ($datediff==1) ? "$datediff second ago" :
"$datediff seconds ago";
break;
}
return $res;
}




function int_to_date($time)
{	
	date_default_timezone_set('Asia/Kolkata');
 	return date('j M Y h:i A',$time);
}


function getPostUrl($post_id)
{	
	$obj =& get_instance();
	$result =$obj->db->select('z.city, s.state, p.unique_post_token, p.title, p.local_post, p.post_zip_code, u.user_name')
							->from('post as p')
							->join('user as u','p.user_id = u.user_id','left')
							->join('usa_zip_codes as z','p.post_zip_code = z.zip_code','left')
							->join('state as s','z.state = s.abbreviation','left')
							->where('p.post_id',$post_id)
							->get();
	$info = $result->row_array();
	
	$title = str_replace('_','-',url_title($info['title'], '-', TRUE)); 
	$city = str_replace('_','-',url_title($info['city'], '-', TRUE)); 
	$state = str_replace('_','-',url_title($info['state'], '-', TRUE)); 
	$unique_post_token = $info['unique_post_token']; 

	//return site_url('post/view/'.$post_id);
	if($info['local_post'])
	{ 
		return site_url($info['user_name'].'/post/'.$city.'/'.$state.'/'.$unique_post_token.'-'.$title);
	}
	else
	{
		return site_url('/post/view/'.$post_id);
	}
}


function getContestUrl($contest_id, $type='')
{	
	//$type = 1 for running, $type = 0 for close
	$obj =& get_instance();
	$result =$obj->db->select('con.unique_contest_token, con.title')
							->from('contest as con')							
							->where('con.contest_id',$contest_id)
							->get();
	$info = $result->row_array();
	
	$title = str_replace('_','-',url_title($info['title'], '-', TRUE)); 	
	$unique_contest_token = $info['unique_contest_token']; 
	
	return site_url('/contest/'.$unique_contest_token.'-'.$title.'/'.$type);
}


