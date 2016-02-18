<?php 
global $t;
$t = $tasks;
$date = $t[0];
$month = date('m', strtotime($date));
$year = date('Y', strtotime($date));
?>

<?php print theme('schedule_menu'); ?>
<div>
  <input name='assigned_to_me' type='checkbox' onchange='schedule.assigned_to_me_toggle();'></input>
  <span>Only show tasks that are assigned to me</span>
</div>
<div style="clear:both; margin-bottom: 20px;">
<h1>
  <div style = "float: left; width: 50px;">
    <a href="/schedule/month/<?php echo date('Y-m-d', strtotime('first day of last month', strtotime($date)));?>" ><<</a>
  </div>
  <div style = "float: left; margin-left: 350px;"> 
    <?php echo date( 'M Y', strtotime($date)) ?>
  </div>
  <div style = "float: right; width:50px">
    <a href="/schedule/month/<?php echo date('Y-m-d', strtotime('first day of next month', strtotime($date)));?>" >>></a>
  </div>
</h1>
<br style="clear: left;" />
</div>

<?php
global $t;
print build_calendar($month, $year);

function tasks_for_day($day) {
  global $t;
  global $user;
  $data = $t[1];
  $today_events = array();
  
  foreach($data as $val) {
    if($val->field_date_value == $day) {
      if (isset($today_events[$val->np_nid])) {
        $today_events[$val->np_nid]['tasks'][] = $val;
      }
      else {
        $today_events[$val->np_nid] = array(
          'project_title' => $val->np_title,
          'tasks' => array($val)
        );
      }
      
    }
  }
  
  $info = "";
  foreach ($today_events as $project_nid => $cell_content) {
    $info .= "<div class='monthly-schedule-project-item'><strong>" .
      l($cell_content['project_title'], drupal_get_path_alias("node/".$project_nid)) .
      "</strong><ul>";
      
    foreach($cell_content['tasks'] as $task) {
      $info .= "<li ";
      if ($task->name != $user->name){
        $info .=" class='not-assigned-to-me'";
      }
      $info .=">" .
        l("#" . $task->nid, drupal_get_path_alias("node/".$task->nid)) .
        " (".$task->name.")</li>";
    }
    $info .="</ul></div>";
  }

  return $info;  
} 

function build_calendar($month,$year) {

     // Create array containing abbreviations of days of week.
     $daysOfWeek = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Sunday');

     // What is the first day of the month in question?
     $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

     // How many days does this month contain?
     $numberDays = date('t',$firstDayOfMonth);

     // Retrieve some information about the first day of the
     // month in question.
     $dateComponents = getdate($firstDayOfMonth);

     // What is the name of the month in question?
     $monthName = $dateComponents['month'];

     // What is the index value (0-6) of the first day of the
     // month in question.
     $dayOfWeek = $dateComponents['wday'];

     // Create the table tag opener and day headers

     $calendar = "<table class='calendar' style='width:100%'>";
     $calendar .= "<tr>";

     // Create the calendar headers

     foreach($daysOfWeek as $day) {
          $calendar .= "<th class='header' style='width:12%'>$day</th>";
     } 

     // Create the rest of the calendar

     // Initiate the day counter, starting with the 1st.

     $currentDay = 1;

     $calendar .= "</tr><tr>";

     // The variable $dayOfWeek is used to
     // ensure that the calendar
     // display consists of exactly 7 columns.

     if ($dayOfWeek > 0) { 
          $calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>"; 
     }
     
     $month = str_pad($month, 2, "0", STR_PAD_LEFT);
  
     while ($currentDay <= $numberDays) {

          // Seventh column (Saturday) reached. Start a new row.

          if ($dayOfWeek == 7) {

               $dayOfWeek = 0;
               $calendar .= "</tr><tr>";

          }
          
          $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
          
          $date = "$year-$month-$currentDayRel";
          $link = l($currentDay, "schedule/day/$year-$month-$currentDayRel");
          $calendar .= "<td valign='top' class='day' rel='$date' style='padding:5px; height:100px;'>
                        $link <br />
                        " . tasks_for_day($date . ' 00:00:00') . "
                        </td>";
 
          $currentDay++;
          $dayOfWeek++;

     }
     
     

     // Complete the row of the last week in month, if necessary

     if ($dayOfWeek != 7) { 
     
          $remainingDays = 7 - $dayOfWeek;
          $calendar .= "<td colspan='$remainingDays'>&nbsp;</td>"; 

     }
     
     $calendar .= "</tr>";

     $calendar .= "</table>";

     return $calendar;

}

