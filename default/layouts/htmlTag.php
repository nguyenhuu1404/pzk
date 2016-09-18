<?php if($data->tagName == 'br') { echo '<br />'; } else { ?>
<{prop tagName} <?php if (strpos($data->id, 'unique') === FALSE){ echo 'id="'.$data->id.'"';} ?>{attr name} {attr type} {attr class} {attr style} {attr value} {attr selected} {attr href} {attr src}>{prop text}{children all}</{prop tagName}>
<?php } ?>