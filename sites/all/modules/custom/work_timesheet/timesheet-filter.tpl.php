<?php 
  if (!isset($_GET['filter'])) { $_GET['filter'] = null; $_GET['start'] = null; $_GET['stop'] = null; }

?>

<style>
  .selected {
    background-color: #FFC;
  }
</style>
<table>
  <tr>
    <th>&nbsp;</th>
    <th colspan="5" style="text-align:center;">Filter By</th>
  </tr>
  <tr>
    <th>Group By:</th>
    <th>Day:</th>
    <th>Week:</th>
    <th>Pay Period:</th>
    <th>Month:</th>
    <th>Year:</th>
  </tr>
  <tr>
    <td>
      <form>
        <?php
          $get = "?filter={$_GET['filter']}&start={$_GET['start']}&stop={$_GET['stop']}";
        ?>

        <input type="radio" name="group" value="no-group"   onclick="window.location='/timesheet<?php print $get; ?>'"           <?php if (arg(1) == '') {          print 'checked'; } ?> />   No Group<br />
        <input type="radio" name="group" value="client"     onclick="window.location='/timesheet/client<?php print $get; ?>'"    <?php if (arg(1) == 'client') {    print 'checked'; } ?> />     Client<br />
        <input type="radio" name="group" value="developer"  onclick="window.location='/timesheet/developer<?php print $get; ?>'" <?php if (arg(1) == 'developer') { print 'checked'; } ?> />  Developer<br />
        <input type="radio" name="group" value="project"    onclick="window.location='/timesheet/project<?php print $get; ?>'"   <?php if (arg(1) == 'project') {   print 'checked'; } ?> />    Project<br />
      </form>
    </td>
    <td <?php if ($_GET['filter'] == 'day') { print 'class="selected"'; }  ?>>
      <form>
        <select  onchange="window.location=jQuery(this).val();">
          <option value="?filter=none&start=0&stop=9">-- select --</option>
          <?php $day = -1;
                while (date('Y-m-d', (time() - ($day * 24 * 60 * 60))) > '2015-11-01') : 
                  $day += 1;        
          ?>
                <option   <?php if (($_GET['filter'] == 'day') && ($_GET['start'] == date('Y-m-d', (time() - ($day * 24 * 60 * 60))))) { print ' selected '; }  ?> 
                          value="?filter=day&start=<?php print date('Y-m-d', (time() - ($day * 24 * 60 * 60))); ?>&stop=<?php print date('Y-m-d', (time() - (($day - 1) * 24 * 60 * 60))); ?>"><?php print date('M d Y', (time() - ($day * 24 * 60 * 60)));  ?></option>
          <?php endwhile; ?>
        </select>
      </form>
    </td>
    <td <?php if ($_GET['filter'] == 'week') { print 'class="selected"'; }  ?>>
      <form>
        <select  onchange="window.location=jQuery(this).val();">
          <option  value="?filter=none&start=0&stop=9">-- select --</option>
          <?php $day = -1;
                while (date('Y-m-d', (time() - ($day * 24 * 60 * 60))) > '2015-11-01') : 
                  $day += 1;        
          ?>
                <?php if (date('D', (time() - ($day * 24 * 60 * 60))) == 'Mon') : ?>
                  <option <?php if (($_GET['filter'] == 'week') && ($_GET['start'] == date('Y-m-d', (time() - ($day * 24 * 60 * 60))))) { print ' selected '; }  ?>  
                          value="?filter=week&start=<?php print date('Y-m-d', (time() - ($day * 24 * 60 * 60))); ?>&stop=<?php print date('Y-m-d', (time() - (($day - 7) * 24 * 60 * 60))); ?>"><?php print date('M d Y', (time() - ($day * 24 * 60 * 60))) . ' - ' . date('M d Y', (time() - (($day - 6) * 24 * 60 * 60)));  ?></option>
                <?php endif; ?>
          <?php endwhile; ?>
        </select>
      </form>
    </td>
    <td <?php if ($_GET['filter'] == 'period') { print 'class="selected"'; }  ?>>
      <form>
        <select onchange="window.location=jQuery(this).val();">
          <option  value="?filter=none&start=0&stop=9">-- select --</option>
          <?php 
                $start_payday = strtotime('November 14 2015');
                $next_payday = $start_payday;
                
                $paydays = array();
                $paydays[] = date('M-d-Y', $start_payday);

            
                while ($next_payday < time()) {
                  $next_payday += (14 * 24 * 60 * 60);
                  $paydays[] = date('M-d-Y', $next_payday);     
                }

                $day = -1;
                while (date('Y-m-d', (time() - ($day * 24 * 60 * 60))) > '2015-11-01') : 
                  $day += 1;        
          ?>

            <?php if (in_array(date('M-d-Y', (time() - ($day * 24 * 60 * 60))), $paydays)) : ?>
              <option <?php if (($_GET['filter'] == 'period') && ($_GET['start'] == date('Y-m-d', (time() - ($day * 24 * 60 * 60))))) { print ' selected '; }  ?>
                      value="?filter=period&start=<?php print date('Y-m-d', (time() - ($day * 24 * 60 * 60))); ?>&stop=<?php print date('Y-m-d', (time() - (($day - 14) * 24 * 60 * 60))); ?>"><?php print date('M d Y', (time() - ($day * 24 * 60 * 60))) . ' - ' . date('M d Y', (time() - (($day - 13) * 24 * 60 * 60)));  ?></option>
            <?php endif; ?>

          <?php endwhile; ?>
        </select>
      </form>
    </td>
    <td <?php if ($_GET['filter'] == 'month') { print 'class="selected"'; }  ?>>
      <form>
        <select  onchange="window.location=jQuery(this).val();">
          <option  value="?filter=none&start=0&stop=9">-- select --</option>
          <?php $day = -1;
                while (date('Y-m-d', (time() - ($day * 24 * 60 * 60))) > '2015-11-01') : 
                  $day += 1;        
          ?>
            <?php if (date('j', (time() - ($day * 24 * 60 * 60))) == 1) : ?>
                <option <?php if (($_GET['filter'] == 'month') && ($_GET['start'] == date('Y-m', (time() - ($day * 24 * 60 * 60))))) { print ' selected '; }  ?>
                        value="?filter=month&start=<?php print date('Y-m', (time() - ($day * 24 * 60 * 60))); ?>&stop=<?php print date('Y-', (time() - (($day) * 24 * 60 * 60))) . (date('m', (time() - (($day) * 24 * 60 * 60))) + 1); ?>"><?php print date('M Y', (time() - ($day * 24 * 60 * 60)));  ?></option>
            <?php endif; ?>
          <?php endwhile; ?>
        </select>
      </form>
    </td>
    <td <?php if ($_GET['filter'] == 'year') { print 'class="selected"'; }  ?>>
      <form>
        <select  onchange="window.location=jQuery(this).val();">
          <option  value="?filter=none&start=0&stop=9">-- select --</option>
          <?php $day = -1;
                while (date('Y-m-d', (time() - ($day * 24 * 60 * 60))) > '2015-11-01') : 
                  $day += 1;        
          ?>
              <?php if (($day == 0) || (date('z', (time() - ($day * 24 * 60 * 60))) == 364)) : ?>
                <option <?php if (($_GET['filter'] == 'year') && ($_GET['start'] == date('Y', (time() - ($day * 24 * 60 * 60))))) { print ' selected '; }  ?>
                        value="?filter=year&start=<?php print date('Y', (time() - ($day * 24 * 60 * 60))); ?>&stop=<?php print (date('Y', (time() - (($day) * 24 * 60 * 60))) + 1); ?>"><?php print date('Y', (time() - ($day * 24 * 60 * 60)));  ?></option>
              <?php endif; ?>
          <?php endwhile; ?>
        </select>
      </form>
    </td>
  </tr>
</table>
