<?php
/*
Plugin Name: Trash Day
Description: Determine if a date is trash date.
Version: 1.0
Author: Gregory Bonk
*/

/*
Example Usage

Is today Trash Day ?

[riverlea_trash]

*/

function riverlea_is_trash_today( $atts, $content = null ) {

  $today = (new DateTime())->format('m-d');

  $content .= "<p>";
  $content .= "Today is " . date("m/d/Y") . ", a " . date("l") . "<br>";
  $content .= "Is today a Monday?  " . is_monday() . "<br>";
  $content .= "Is today a holiday?  " . is_holiday( $today ) . "<br>";
  $content .= "Is today trash day?  " . riverlea_well_is_it() . "<br>";
  $content .= "</p>";

  return $content;
}


add_shortcode('riverlea_trash', 'riverlea_is_trash_today');

function riverlea_well_is_it()
{

  $today = (new DateTime())->format('m-d');
  $yesterday = (new DateTime("yesterday"))->format('m-d');

  if ( (is_monday() == "Yes") and (is_holiday($today)=="No") )
  {
    return "Yes";
  }
  if ( (is_tuesday() == "Yes") and (is_holiday($yesterday)=="Yes") )
  {
    return "Yes";
  }

  return "NO!";
}



function is_monday() {

  if(date('D') == 'Mon')
  {
    return "Yes";
  }
  else {
    return "No";
  }

}

function is_tuesday() {

  if(date('D') == 'Tue')
  {
    return "Yes";
  }
  else {
    return "No";
  }

}

function is_holiday($a_date_string) {

  // January: New Years - Yes; MLK - NO
  $new_years = "01-01";
  // February: Presidents Day - NO
  $presidents_day = (new DateTime("third monday of february this year"))->format('m-d');
  // May:  Memorial Day - Yes
  $memorial_day = (new DateTime("last monday of may this year"))->format('m-d');
  // July:  July 4th - Yes
  $july_fourth = "07-04";
  // September:  Labor Day - Yes
  $labor_day = (new DateTime("first monday of september this year"))->format('m-d');
  // November:  Thanksgiving Day - Yes
  $thanksgiving_day = (new DateTime("fourth thursday of november this year"))->format('m-d');
  // December:  Christmas Day - Yes
  $christmas = "12-25";

  if (($a_date_string == $new_years) or ($a_date_string == $presidents_day) or ($a_date_string == $memorial_day) or ($a_date_string==$july_fourth) or
  ($a_date_string==$labor_day) or ($a_date_string==$thanksgiving_day) or ($a_date_string==$christmas)) {

    return "Yes";
  }
  else {
    return "No";
  }
}

?>
