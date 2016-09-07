<?php
  // We hide the comments and links now so that we can render them later.
  hide($content['comments']);
  hide($content['links']);

?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?> style="position:relative">

  <div id="task-left">
    <div id="task-project">
    <strong>Client:</strong>
    <?php
      $client = node_load($node->field_client['und'][0]['nid']);
      print l($client->title, 'node/' . $client->nid);
    ?>
    </div>

    <div id="users-container"><?php print render($content['field_users']); ?></div><br /> 

    <?php print render($content['body']); ?><br />
    
    <?php 
      /*** MOVE TO MODULE ***/

      $bt_nid = db_query("SELECT entity_id FROM {field_data_field_project} WHERE field_project_nid = :nid AND bundle = 'browser_test'", array(':nid' => $node->nid))->fetchField();

      if (isset($bt_nid) && ($bt_nid != null)) :
      $bt = node_load($bt_nid);

      $browsers = taxonomy_get_tree(3);

      $t = array();
      $res_count = 0;
      foreach ($browsers as $k => $v) {
        $term = taxonomy_term_load($v->tid);


        $t[$v->tid]['browser'] = $v->name;

        $resolutions = array();
        foreach ($term->field_resolution['und'] as $res_term) {
          $res_term = taxonomy_term_load($res_term['tid']);

          $resolutions[$res_term->tid] = $res_term->name;
          $res_count += 1;
        }

        $t[$v->tid]['resolutions'] = $resolutions;

      }

      $pages = array();
      
      foreach($bt->field_pages['und'] as $k => $p) {
        $entity = entity_load('field_collection_item', array($p['value']));
        $page = array_pop($entity);

        $pages[$k] = $page->field_page['und'][0]['value'];
      }

      $passed_count = 0;
      $failed_count = 0;
      $needs_tested = 0;

      foreach ($pages as $k => $p) {
        foreach ($t as $k => $v) {
          foreach ($v['resolutions'] as $kk => $vv) {
            $status = work_browser_test_get_status($bt->nid, $p, $k, $kk);

            if ($status == 'Needs Tested') {
              $needs_tested += 1;
            }
            if ($status == 'Passed') {
              $passed_count += 1;
            }
            if ($status == 'Failed' || $status == 'Failed-Ticket') {
              $failed_count += 1;
            }
          }
        }
      }
    ?>

    <div id="node-browser-test" style="position:absolute; bottom:10px;">
      <table style="font-size:12px; width:400px;" cellpadding="5">
        <tr>
          <th>Browser Test</th>
          <td colspan="2" style="font-size:14px; text-align:center; font-weight:bold;"><?php print l($bt->title, 'node/' . $bt->nid); ?></td>
        </tr>
        <tr>
          <th>Total Tests</th>
          <td colspan="2" style="text-align:right;"><?php print (count($pages) * $res_count); ?></td>
        </tr>
        <tr>
          <th width="50%">Passed</th>
          <td width="25%" style="text-align:right;"><?php print $passed_count; ?></td>
          <td width="25%" style="text-align:right;"><?php print number_format($passed_count / (count($pages) * $res_count) * 100, 2); ?>%</td>
        </tr>
        <tr>
          <th>Failed</th>
          <td style="text-align:right;"><?php print $failed_count; ?></td>
          <td style="text-align:right;"><?php print number_format($failed_count / (count($pages) * $res_count) * 100, 2); ?>%</td>
        </tr>
        <tr>
          <th>Needs Re-Tested</th>
          <td style="text-align:right;"><?php print $needs_tested; ?></td>
          <td style="text-align:right;"><?php print number_format($needs_tested / (count($pages) * $res_count) * 100, 2); ?>%</td>
        </tr>
        <tr>
          <th>Untested</th>
          <td style="text-align:right;"><?php print (count($pages) * $res_count) - $passed_count - $failed_count - $needs_tested; ?></td>
          <td style="text-align:right;"><?php print number_format(((count($pages) * $res_count) - $passed_count - $failed_count - $needs_tested) / (count($pages) * $res_count) * 100, 2); ?>%</td>
        </tr>
      </table>
    </div>
    <?php endif; ?>

    <div style="clear:both;" /></div>
    <br /><br />
  </div>

  <?php
    $credentials_count = 0;
    $assets_count = 0;
    $resources_count = 0;

    if (isset($node->field_credentials['und'])) { $credentials_count += count($node->field_credentials['und']); }
    if (isset($node->field_assets['und'])) { $assets_count += count($node->field_assets['und']); }
    if (isset($node->field_resources['und'])) { $resources_count += count($node->field_resources['und']); }
  ?>

  <div id="task-right">
    <div class="tabs">
      <ul class="tabs primary task">
        <li class="active"><a href="#" data-show="log">Log</a></li>
        <li><a href="#" data-show="credentials">Credentials (<?php print $credentials_count; ?>)</a></li>
        <li><a href="#" id="assets-tab" data-show="assets">Assets (<?php print $assets_count; ?>)</a></li>
        <li><a href="#" data-show="resources">Resources (<?php print $resources_count;?>)</a></li>
      </ul>
    </div>
    


    <div id="credentials-wrapper" class="right-wrapper">
      <div id="credentials-container"><?php print render($content['field_credentials']); ?></div>
      <a href="#" id="add-credentials" onclick="jQuery('#node-add-credentials').toggle(); return false;" class="form-link">Add Credentials</a>
      <div id="node-add-credentials" class="hidden-form"> 
        <form action="#" 
              id="credentials-form"
              onsubmit="  jQuery('#credentials-container').load('/projects/update-credentials/add', {data: jQuery('#credentials-form').serialize()},function(){work_log.update_log(<?php print $node->nid;?>);});
                          jQuery('#node-add-credentials').hide();
                          reset_height();
                          return false;">
          <input type="hidden" id="nid" name="nid" value="<?php print $node->nid; ?>" />

          <input type="text" id="description" name="description"  size="50" placeholder="Description"  /><br /><br />
          <input type="text" id="path"        name="path"         size="50" placeholder="Path"         /><br /><br />
          <input type="text" id="username"    name="username"     size="50" placeholder="Username"     /><br /><br />
          <input type="text" id="password"    name="password"     size="50" placeholder="Password"     /><br /><br />
          
          <input type="submit" value="Add Credential"/>
        </form>
      </div>  

      <div style="clear:both"></div>
 
    </div>

    <div id="assets-wrapper" class="right-wrapper">
      <?php print render($content['field_assets']); ?>
      <a href="#" id="add-asset" onclick="jQuery('#node-add-asset').toggle(); return false;" class="form-link">Add Asset</a>
      <div id="node-add-asset" class="hidden-form">
        <form action="/projects/update-assets/add" id="asset-form" method="post" enctype="multipart/form-data">
          <input type="hidden" id="nid" name="nid" value="<?php print $node->nid; ?>" />

          <input type="text" id="asset" name="asset" size="50" placeholder="Asset" data-init="Asset" class="init" /><br /><br />
          <input type="file" id="file" name="file" size="50" class="init" /><br /><br />
          
          <input type="submit" value="Add Asset"/>
        </form>
      </div>
    </div>

    <div id="resources-wrapper" class="right-wrapper">
      <div id="resources-container"><?php print render($content['field_resources']); ?></div>
      <a href="#" id="add-resource" onclick="jQuery('#node-add-resource').toggle(); return false;" class="form-link">Add Resource</a>
      <div id="node-add-resource" class="hidden-form">
        <form action="#" 
              id="resource-form" 
              onsubmit="  jQuery('#resources-container').load('/projects/update-resources/add', {data: jQuery('#resource-form').serialize()},function(){work_log.update_log(<?php print $node->nid;?>);});
                          jQuery('#node-add-resource').hide(); 
                          reset_height();
                          return false;">
          <input type="hidden" id="nid" name="nid" value="<?php print $node->nid; ?>" />
          <input type="text" id="resource" name="resource" size="50" placeholder="Resource" data-init="Resource" class="init" /><br /><br />
          <input type="text" id="URL" name="url" size="50" placeholder="URL" data-init="URL" class="init" /><br /><br />
          <input type="submit" value="Add Comment"/>
        </form>
      </div>
    </div>
    
    
    <div id="log-wrapper" class="right-wrapper">
      <?php print work_log_view($node->nid);?>
    </div>
    
    

    <div style="clear:both"></div><br /><br />
  </div>

  <div id="node-users-div">
    <?php 
    
      $result = db_query("SELECT uid, name FROM {users}");

      foreach ($result as $r) {
          print " <a  href='#' 
                      onclick=' jQuery(\"#node-users-div\").hide(); 
                                jQuery(\"#users-container\").load(\"/projects/update-users/add/{$node->nid}/{$r->uid}\", function(){work_log.update_log({$node->nid});})'>
                      {$r->name}
                  </a>\n";

      }
    ?>
  </div>

</div>


<?php if (isset($_GET['assets'])) : ?>
<script>
  (function ($) {
    $(document).ready(function() {
      $('#assets-tab').click();
    });
  }(jQuery));
</script>
<?php endif; ?>

