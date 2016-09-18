{? $src = $data->src;
if(strpos($src, 'http://') === false) {
	$src = '/default/skin/' . pzk_app()->getPathByName() . '/images/' . $src;
}
?}
{? if(strpos($data->src, 'http://') === false) { ?}
<img id="{prop id}" class="{prop class}" src="/default/skin/<?php echo pzk_app()->getPathByName(); ?>/images/{prop src}" style="width: {prop width}; height: {prop height}; {prop style}" />
{? } else { ?}
<img id="{prop id}" class="{prop class}" src="{prop src}" style="width: {prop width}; height: {prop height}; {prop style}" />
{? } ?}