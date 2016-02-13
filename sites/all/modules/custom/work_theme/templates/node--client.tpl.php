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
   
    <div style="clear:both;" /></div>
    <br /><br />
  </div>

  <div id="task-right">
    <div class="tabs">
      <ul class="tabs primary task">
        <li class="active"><a href="#" data-show="log">Log</a></li>
        <li><a href="#" data-show="credentials">Credentials</a></li>
        <li><a href="#" id="assets-tab" data-show="assets">Assets</a></li>
        <li><a href="#" data-show="resources">Resources</a></li>
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
