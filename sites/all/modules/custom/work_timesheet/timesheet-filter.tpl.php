<?php 
  if (isset($_GET['group']))     $group    = $_GET['group'];
  if (isset($_GET['invoiced']))  $invoiced = $_GET['invoiced'];
  if (isset($_GET['paid']))      $paid     = $_GET['paid'];
  if (isset($_GET['filter']))    $filter   = $_GET['filter'];
  if (isset($_GET['start']))     $start    = $_GET['start'];

  if (!isset($group))     $group = 'no-group';
  if (!isset($invoiced))  $invoiced = 'all';
  if (!isset($paid))      $paid = 'all';

  if (!isset($filter)) {
    $filter = 'month';
    $start =  date('Y-m');
  }

?>

<style>
  .selected {
    background-color: #FFC;
  }
</style>
<table>
  <tr>
    <th>&nbsp;</th>
    <th colspan="7" style="text-align:center;">Filter By</th>
  </tr>
  <tr>
    <?php if ($version == 'admin' || $version == 'developer') : ?>
      <th>Group By:</th>
    <?php endif; ?>
    <?php if ($version == 'admin' || $version == 'developer') : ?>
      <th>Paid:</th>
    <?php endif; ?>
    <?php if ($version == 'admin' || $version == 'client') : ?>
      <th>Invoiced:</th>
    <?php endif; ?>
    <th>Day:</th>
    <th>Week:</th>
    <th>Pay Period:</th>
    <th>Month:</th>
    <th>Year:</th>
  </tr>
  <tr>
    <?php if ($version == 'admin' || $version == 'developer') : ?>
    <td valign="top">
      <?php $get = ''; foreach ($_GET as $k => $v) { if (!in_array($k, array('q', 'group'))) {$get .= "&$k=$v";} } $get .= "&group="; ?>
      <form>
        <input type="radio" name="group" value="no-group"   onclick="window.location='/timesheet/<?php print $version; ?>/?<?php print $get . 'no-group'; ?>'"   <?php if ($group == 'no-group')  { print 'checked'; } ?> /> No Group<br />
        <input type="radio" name="group" value="client"     onclick="window.location='/timesheet/<?php print $version; ?>/?<?php print $get . 'client'; ?>'"     <?php if ($group == 'client')    { print 'checked'; } ?> /> Client<br />
        <?php if ($version == 'admin') : ?>
          <input type="radio" name="group" value="developer"  onclick="window.location='/timesheet/<?php print $version; ?>/?<?php print $get . 'developer'; ?>'"  <?php if ($group == 'developer') { print 'checked'; } ?> /> Developer<br />
        <?php endif; ?>
        <input type="radio" name="group" value="project"    onclick="window.location='/timesheet/<?php print $version; ?>/?<?php print $get . 'project'; ?>'"    <?php if ($group == 'project')   { print 'checked'; } ?> /> Project<br />
      </form>
    </td>
    <?php endif; ?>
    <?php if ($version == 'admin' || $version == 'developer') : ?>
    <td valign="top">
      <?php $get = ''; foreach ($_GET as $k => $v) { if (!in_array($k, array('q', 'paid'))) {$get .= "&$k=$v";} } $get .= "&paid="; ?>
      <form>
        <input type="radio" name="paid" value="all"      onclick="window.location='/timesheet/<?php print $version; ?>/?<?php print $get . 'all'; ?>'"       <?php if ($paid == 'all') {      print 'checked'; } ?> /> All<br />
        <input type="radio" name="paid" value="not-paid" onclick="window.location='/timesheet/<?php print $version; ?>/?<?php print $get . 'not-paid'; ?>'"  <?php if ($paid == 'not-paid') { print 'checked'; } ?> /> Not Paid<br />
        <input type="radio" name="paid" value="paid"     onclick="window.location='/timesheet/<?php print $version; ?>/?<?php print $get . 'paid'; ?>'"      <?php if ($paid == 'paid') {     print 'checked'; } ?> /> Paid<br />
      </form>
    </td>
    <?php endif; ?>
    <?php if ($version == 'admin' || $version == 'client') : ?>
    <td valign="top">
      <?php $get = ''; foreach ($_GET as $k => $v) { if (!in_array($k, array('q', 'invoiced'))) {$get .= "&$k=$v";} } $get .= "&invoiced="; ?>
      <form>
        <input type="radio" name="invoiced" value="all"          onclick="window.location='/timesheet/<?php print $version; ?>/?<?php print $get . 'all'; ?>'"          <?php if ($invoiced == 'all') {           print 'checked'; } ?> /> All<br />
        <input type="radio" name="invoiced" value="Not Invoiced" onclick="window.location='/timesheet/<?php print $version; ?>/?<?php print $get . 'Not Invoiced'; ?>'" <?php if ($invoiced == 'Not Invoiced') {  print 'checked'; } ?> /> Waiting<br />
        <input type="radio" name="invoiced" value="Invoiced"     onclick="window.location='/timesheet/<?php print $version; ?>/?<?php print $get . 'Invoiced'; ?>'"     <?php if ($invoiced == 'Invoiced') {      print 'checked'; } ?> /> Invoiced<br />
        <input type="radio" name="invoiced" value="Pending"      onclick="window.location='/timesheet/<?php print $version; ?>/?<?php print $get . 'Pending'; ?>'"      <?php if ($invoiced == 'Pending') {       print 'checked'; } ?> /> Pending<br />
        <input type="radio" name="invoiced" value="Paid"         onclick="window.location='/timesheet/<?php print $version; ?>/?<?php print $get . 'Paid'; ?>'"         <?php if ($invoiced == 'Paid') {          print 'checked'; } ?> /> Paid<br />
      </form>
    </td>
    <?php endif; ?>
    <?php $get = ''; foreach ($_GET as $k => $v) { if (!in_array($k, array('q', 'start', 'stop', 'filter'))) {$get .= "&$k=$v";} } ?>
    <td <?php if ($filter == 'day') { print 'class="selected"'; }  ?>>
      <form>
        <select  onchange="window.location=jQuery(this).val();">
          <option value="/timesheet/<?php print $version; ?>/?<?php print $get; ?>&filter=none&start=0&stop=9">-- select --</option>
          <?php $day = -1;
                while (date('Y-m-d', (time() - ($day * 24 * 60 * 60))) > '2015-11-01') : 
                  $day += 1;        
          ?>
                <option   <?php if (($filter == 'day') && ($start == date('Y-m-d', (time() - ($day * 24 * 60 * 60))))) { print ' selected '; }  ?> 
                          value="/timesheet/<?php print $version; ?>/?<?php print $get; ?>&filter=day&start=<?php print date('Y-m-d', (time() - ($day * 24 * 60 * 60))); ?>&stop=<?php print date('Y-m-d', (time() - (($day - 1) * 24 * 60 * 60))); ?>"><?php print date('M d Y', (time() - ($day * 24 * 60 * 60)));  ?></option>
          <?php endwhile; ?>
        </select>
      </form>
    </td>
    <td <?php if ($filter == 'week') { print 'class="selected"'; }  ?>>
      <form>
        <select  onchange="window.location=jQuery(this).val();">
          <option  value="/timesheet/<?php print $version; ?>/?<?php print $get; ?>&filter=none&start=0&stop=9">-- select --</option>
          <?php $day = -1;
                while (date('Y-m-d', (time() - ($day * 24 * 60 * 60))) > '2015-11-01') : 
                  $day += 1;        
          ?>
                <?php if (date('D', (time() - ($day * 24 * 60 * 60))) == 'Mon') : ?>
                  <option <?php if (($filter == 'week') && ($start == date('Y-m-d', (time() - ($day * 24 * 60 * 60))))) { print ' selected '; }  ?>  
                          value="/timesheet/<?php print $version; ?>/?<?php print $get; ?>&filter=week&start=<?php print date('Y-m-d', (time() - ($day * 24 * 60 * 60))); ?>&stop=<?php print date('Y-m-d', (time() - (($day - 7) * 24 * 60 * 60))); ?>"><?php print date('M d', (time() - ($day * 24 * 60 * 60))) . ' - ' . date('M d Y', (time() - (($day - 6) * 24 * 60 * 60)));  ?></option>
                <?php endif; ?>
          <?php endwhile; ?>
        </select>
      </form>
    </td>
    <td <?php if ($filter == 'period') { print 'class="selected"'; }  ?>>
      <form>
        <select onchange="window.location=jQuery(this).val();">
          <option  value="/timesheet/<?php print $version; ?>/?<?php print $get; ?>&filter=none&start=0&stop=9">-- select --</option>
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
              <option <?php if (($filter == 'period') && ($start == date('Y-m-d', (time() - ($day * 24 * 60 * 60))))) { print ' selected '; }  ?>
                      value="/timesheet/<?php print $version; ?>/?<?php print $get; ?>&filter=period&start=<?php print date('Y-m-d', (time() - ($day * 24 * 60 * 60))); ?>&stop=<?php print date('Y-m-d', (time() - (($day - 14) * 24 * 60 * 60))); ?>"><?php print date('M d', (time() - ($day * 24 * 60 * 60))) . ' - ' . date('M d Y', (time() - (($day - 13) * 24 * 60 * 60)));  ?></option>
            <?php endif; ?>

          <?php endwhile; ?>
        </select>
      </form>
    </td>
    <td <?php if ($filter == 'month') { print 'class="selected"'; }  ?>>
      <form>
        <select  onchange="window.location=jQuery(this).val();">
          <option  value="/timesheet/<?php print $version; ?>/?<?php print $get; ?>&filter=none&start=0&stop=9">- select -</option>
          <?php $day = -1;
                while (date('Y-m-d', (time() - ($day * 24 * 60 * 60))) > '2015-11-01') : 
                  $day += 1;        
          ?>
            <?php if (date('j', (time() - ($day * 24 * 60 * 60))) == 1) : ?>
                <option <?php if (($filter == 'month') && ($start == date('Y-m', (time() - ($day * 24 * 60 * 60))))) { print ' selected '; }  ?>
                        value="/timesheet/<?php print $version; ?>/?<?php print $get; ?>&filter=month&start=<?php print date('Y-m', (time() - ($day * 24 * 60 * 60))); ?>&stop=<?php print date('Y-', (time() - (($day) * 24 * 60 * 60))) . sprintf("%02d",(date('m', (time() - (($day) * 24 * 60 * 60))) + 1)); ?>"><?php print date('M Y', (time() - ($day * 24 * 60 * 60)));  ?></option>
            <?php endif; ?>
          <?php endwhile; ?>
        </select>
      </form>
    </td>
    <td <?php if ($filter == 'year') { print 'class="selected"'; }  ?>>
      <form>
        <select  onchange="window.location=jQuery(this).val();">
          <option  value="/timesheet/<?php print $version; ?>/?<?php print $get; ?>&filter=none&start=0&stop=9">- select -</option>
          <?php $day = -1;
                while (date('Y-m-d', (time() - ($day * 24 * 60 * 60))) > '2015-11-01') : 
                  $day += 1;        
          ?>
              <?php if (($day == 0) || (date('z', (time() - ($day * 24 * 60 * 60))) == 364)) : ?>
                <option <?php if (($filter == 'year') && ($start == date('Y', (time() - ($day * 24 * 60 * 60))))) { print ' selected '; }  ?>
                        value="/timesheet/<?php print $version; ?>/?<?php print $get; ?>&filter=year&start=<?php print date('Y', (time() - ($day * 24 * 60 * 60))); ?>&stop=<?php print (date('Y', (time() - (($day) * 24 * 60 * 60))) + 1); ?>"><?php print date('Y', (time() - ($day * 24 * 60 * 60)));  ?></option>
              <?php endif; ?>
          <?php endwhile; ?>
        </select>
      </form>
    </td>
  </tr>
</table>
