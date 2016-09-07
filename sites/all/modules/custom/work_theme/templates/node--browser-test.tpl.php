<script>
  jQuery(document).ready( function() {
    jQuery('#main').width('100%');
  });
</script>

<div id="width-toggle">
  <i class="demo-icon icon-resize-full" onclick="if (jQuery('#main').width() == 960) { jQuery('#main').width('100%'); } else { jQuery('#main').width('960'); }"></i> 
</div>

<?php 
  $browsers = taxonomy_get_tree(3);

  $t = array();
  foreach ($browsers as $k => $v) {
    $term = taxonomy_term_load($v->tid);


    $t[$v->tid]['browser'] = $v->name;

    $resolutions = array();
    foreach ($term->field_resolution['und'] as $res_term) {
      $res_term = taxonomy_term_load($res_term['tid']);


      $resolutions[$res_term->tid] = $res_term->name;
    }

    $t[$v->tid]['resolutions'] = $resolutions;
  }
?>

<?php 
  $pages = array();
  
  foreach($node->field_pages['und'] as $k => $p) {
    $entity = entity_load('field_collection_item', array($p['value']));
    $page = array_pop($entity);

    $pages[$k] = $page->field_page['und'][0]['value'];
  }
?>

<?php drupal_add_js('misc/tableheader.js'); ?>

<strong><a href="/node/<?php print $node->field_project['und'][0]['nid']; ?>"> &lt;&lt; Back to Project</a></strong>

<table class="sticky-enabled">
  <thead>
  <tr>
    <td style="width:260px;">&nbsp;</td>
    <?php 
      foreach ($t as $k => $v) {
        print "<th colspan='" . count($v['resolutions']) . "'>{$v['browser']}</th>";
      }
    ?>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <?php 
      $count = 0;
      foreach ($t as $k => $v) {
        foreach ($v['resolutions'] as $kk => $vv) {
          $count += 1;
          print "<th class='resolution col-$count'><span class='vert-text'>$vv</span></th>";
        }
      }
    ?>
  </tr>
  </thead>
  <?php 
    foreach ($pages as $k => $p) {
      $count = 0;
      print "<tr class='hover-color'>";
      print "<td><strong>$p</strong></td>";
  
      foreach ($t as $k => $v) {
        foreach ($v['resolutions'] as $kk => $vv) {

          $count += 1;
          $status = work_browser_test_get_status($node->nid, $p, $k, $kk);

          switch ($status) {
            case 'Passed' :
              print '<td class="pass browser_test col-'.$count.'" data-col="'.$count.'">
                        <i  class="icon-ok-1"       
                            data-nid="' . $node->nid . '" 
                            data-page="' . $p . '" 
                            data-browser="' . $k . '" 
                            data-resolution="' . $kk . '" 
                            data-status="Needs Tested">
                        </i>
                    </td>';
              break;

            case 'Failed' :
              print '<td class="fail browser_test col-'.$count.'" data-col="'.$count.'">
                        <i  class="icon-cancel"     
                            data-nid="' . $node->nid . '" 
                            data-page="' . $p . '" 
                            data-browser="' . $k . '" 
                            data-resolution="' . $kk . '" 
                            data-status="Needs Tested">
                        </i>
                    </td>';
              break;

            case 'Needs Tested' :
              print '<td class="in-progress browser_test col-'.$count.'" data-col="'.$count.'">
                        <i  class="icon-ok-circled"  
                            data-nid="' . $node->nid . '" 
                            data-page="' . $p . '" 
                            data-browser="' . $k . '" 
                            data-resolution="' . $kk . '" 
                            data-status="Passed" 
                            style="color:green;" id="$k-$kk"></i><br />
                        <i  class="icon-cancel-circled" 
                            data-nid="' . $node->nid . '" 
                            data-page="' . $p . '" 
                            data-browser="' . $k . '" 
                            data-resolution="' . $kk . '" 
                            data-status="Failed" 
                            style="color:red;">
                        </i><br />
                        <i  class="icon-ticket" 
                            data-nid="' . $node->nid . '" 
                            data-page="' . $p . '" 
                            data-browser="' . $k . '" 
                            data-resolution="' . $kk . '" 
                            data-status="Failed-Ticket" 
                            style="color:blue;">
                        </i>
                      </td>';
              break;

            default:
              print '<td class="needs-tested browser_test col-'.$count.'" data-col="'.$count.'">
                        <i  class="icon-ok-circled"  
                            data-nid="' . $node->nid . '" 
                            data-page="' . $p . '" 
                            data-browser="' . $k . '" 
                            data-resolution="' . $kk . '" 
                            data-status="Passed" 
                            style="color:green;" id="$k-$kk"></i><br />
                        <i  class="icon-cancel-circled" 
                            data-nid="' . $node->nid . '" 
                            data-page="' . $p . '" 
                            data-browser="' . $k . '" 
                            data-resolution="' . $kk . '" 
                            data-status="Failed" 
                            style="color:red;">
                        </i><br />
                        <i  class="icon-ticket" 
                            data-nid="' . $node->nid . '" 
                            data-page="' . $p . '" 
                            data-browser="' . $k . '" 
                            data-resolution="' . $kk . '" 
                            data-status="Failed-Ticket" 
                            style="color:blue;">
                        </i>
                      </td>';
          }
        }
      }

      print "</tr>";
    }
  ?>
</table>
