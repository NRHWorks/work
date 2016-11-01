<div id="dashboard">
  <?php if (count($messages) > 0) : ?>
  <div id="dashboard-messages">
    <?php print $messages; ?>
  </div>
  <?php endif; ?>

  <div class="row">
    <div id="dashboard-todo" class="item first">
      <div class="title">My To Do</div>
      <div class="content">
        <?php
          $count = 0;

          if (count($todo) > 0) {
            foreach ($todo as $t) {
              $count += 1;
              print "$count. $t <br />";
            }
          } else {
            print "You have nothing to do.";
          }
        ?>
      </div>
    </div>
    <div id="dashboard-schedule" class="item">
      <div class="title">My Schedule</div>
      <div class="content">
        <?php
          if (count($schedule) > 0) {
            foreach ($schedule as $s) {
              print "<span style='display:inline-block; width:175px;'>" . date('D, F j', strtotime($s->field_date_value)) .
                    " " . $s->field_schedule_time_value .
                    "</span><strong>{$s->np_title}:</strong> " . l($s->title, 'node/' . $s->nid)  . "<br /><br />";
            }
          } else {
            print "You have no time scheduled.  Please check out your stories and fill in your schedule.";
          }
        ?>
      </div>
    </div>
    <div id="dashboard-time" class="item">
      <div class="title">My Time</div>
      <div class="content">
        <?php print $time; ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div id="dashboard-stories" class="item first">
      <div class="title">My Stories</div>
      <div class="content">
        <?php
          if (count($stories) > 0) {

            print "<table>
                    <tr>
                      <th></th>
                      <th>Story</th>
                      <th>Sprint</th>
                      <th>Project</th>
                      <th>Status</th>
                      <th>Due Date</th>
                    </tr>";

            $count = 0;
            foreach ($stories as $spr => $pr) {
              $spr_obj = node_load($spr);

              foreach ($pr as $pnid => $str_arr) {
                $prj_obj = node_load($pnid);

                foreach ($str_arr as $s) {
                  $count += 1;


                  $status = taxonomy_term_load($s->field_status['und'][0]['tid']);
                  $due = date('D, M j', strtotime($s->field_due_date['und'][0]['value']));

                  print " <tr>
                            <td>$count. </td>
                            <td>" . l($s->title, 'node/' . $s->nid) . "</td>
                            <td>" . l($spr_obj->title, 'node/' . $spr_obj->nid) . "</td>
                            <td>" . l($prj_obj->title, 'node/' . $prj_obj->nid) . "</td>
                            <td>{$status->name}</td>
                            <td>$due</td>
                          </tr>";
                }
              }
            }

            print "</table>";

          } else {
            print "You have no stories assigned.";
          }
        ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div id="dashboard-projects" class="item first">
      <div class="title">My Active Projects</div>
      <div class="content">
        <?php
          if (count($projects) > 0) {
            $count = 0;
            foreach ($projects as $k => $p) {
              $count += 1;
              print $count . ". " .l($p->title, 'node/' . $p->nid) . "<br>";
            }
          } else {
            print "You are not assigned to any projects.";
          }
        ?>
      </div>
    </div>
    <div id="dashboard-sprints" class="item">
      <div class="title">My Active Sprints</div>
      <div class="content">
        <?php
          if (count($sprints) > 0) {
            foreach ($sprints as $k => $s) {
              $status = taxonomy_term_load($s->field_sprint_status['und'][0]['tid']);
              print ($k+1) . ". " . l($s->title, 'node/' . $s->nid) . " ({$status->name})<br>";
            }
          } else {
            print "You are not assigned to any sprints.";
          }
        ?>
      </div>
    </div>
  </div>
</div>
