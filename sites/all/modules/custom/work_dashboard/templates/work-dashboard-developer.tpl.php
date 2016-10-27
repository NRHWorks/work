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
            print "You have no time scheduled.  Please check out your tickets and fill in your schedule.";
          }
        ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div id="dashboard-tickets" class="item first">
      <div class="title">My Tickets</div>
      <div class="content">
        <?php
          if (count($tickets) > 0) {
            foreach ($tickets as $k => $t) {
              if ($k < 7) {
                print ($k+1) . ". {$t->title}<br>";
              }
            }
          } else {
            print "You have no tickets assigned.";
          }

          if (count($tickets) > 6) {
            print "<a href='/tickets'>View all tickets&raquo;</a>";
          }
        ?>
      </div>
    </div>

    <div id="dashboard-sprints" class="item">
      <div class="title">My Sprints</div>
      <div class="content">
        <?php
          if (count($sprints) > 0) {
            foreach ($sprints as $k => $s) {
              $status = taxonomy_term_load($s->field_sprint_status['und'][0]['tid']);
              print ($k+1) . ". {$s->title} - {$status->name}<br>";
            }
          } else {
            print "You are not assigned to any sprints.";
          }
        ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div id="dashboard-projets" class="item first">
      <div class="title">My Projects</div>
      <div class="content">
        <?php
          if (count($projects) > 0) {
            foreach ($projects as $k => $p) {
              print ($k+1) . ". {$p->title}<br>";
            }
          } else {
            print "You are not assigned to any projects.";
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
</div>
