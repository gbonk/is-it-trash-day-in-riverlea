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

function riverlea_trash_schedule( $atts, $content = null ) {

  $today = new DateTime();
  $tomorrow = new DateTime("tomorrow");

  $content .= "<p>";
  $content .= "Today is " . date("m/d/Y") . ", a " . date("l") . "<br>";
  $content .= "Is today a Monday?  " . b2t(is_monday( $today ) ). "<br>";
  $content .= "Is today a holiday?  " . b2t(is_holiday( $today ) ). "<br>";
  $content .= "Is today trash day?  " . b2t(is_trash_day($today) ). "<br>";
  $content .= "Is tomorrow trash day?  " . b2t(is_trash_day($tomorrow) ). "<br>";

  $day_str = "";

  if ( is_trash_day($today) )
  {
    $day_str = "TODAY, ";
  }
  else if ( is_trash_day($tomorrow) )
  {
    $day_str = "TOMORROW, ";
  }

  $content .= "The next trash day is  " . $day_str . next_trash_day()->format('l, m-d') . "<br>";

  $content .= "</p>";

  return $content;
}


add_shortcode('riverlea_trash', 'riverlea_trash_schedule');

function b2t($a_bool)
{
  if ( $a_bool)
  {
    return "Yes";
  }
  if ( ! $a_bool)
  {
    return "No";
  }

  return "?";
}


function next_trash_day() {

  $the_date = new DateTime();

  $is_trash_day = is_trash_day($the_date);

  while ( ! $is_trash_day )
  {
      $the_date->add(new DateInterval('P1D'));

      $is_trash_day = is_trash_day($the_date);
  }

  return $the_date;
}


function is_trash_day( $a_date )
{
  $today = $a_date;

  $yesterday = clone $a_date;
  $yesterday->sub(new DateInterval('P1D'));

  if ( is_monday($today) and is_holiday($today) )
  {
    return true;
  }
  if ( is_tuesday($today) and is_holiday($yesterday) )
  {
    return true;
  }

  return false;
}

function is_monday($a_date) {

  return ( ($a_date->format('D')) == 'Mon');
}

function is_tuesday($a_date) {

  return ( ($a_date->format('D')) == 'Tue');
}

function is_holiday($a_date) {

  $month_day = $a_date->format('m-d');

  // January: New Years - Yes; MLK - NO
  $new_years = "01-01";
  // February: Presidents Day - NO
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

  return  (($month_day == $new_years) or ($month_day == $presidents_day) or ($month_day == $memorial_day) or ($month_day==$july_fourth) or
  ($month_day==$labor_day) or ($month_day==$thanksgiving_day) or ($month_day==$christmas));
}

?>
