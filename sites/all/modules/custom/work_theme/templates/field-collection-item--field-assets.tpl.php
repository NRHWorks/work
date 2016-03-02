<?php

  // Print thumbnail if the file is an image.
  $thumbnail = "";

  if ($content['field_asset']["#items"][0]["filemime"] == "image/jpeg" ||
      $content['field_asset']["#items"][0]["filemime"] == "image/png" ||
      $content['field_asset']["#items"][0]["filemime"] == "image/gif" ) {

    $img_url = file_create_url($content['field_asset']["#items"][0]['uri']);
    $thumbnail
      = "<a href ='" . $img_url . "' target='_blank'><img src='" . $img_url .
      "' width=200 /></a>";
  }
?>

<div class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <div class="content"<?php print $content_attributes; ?>>
    <?php
      print render($content);
      print $thumbnail;
    ?>
  </div>
</div>
