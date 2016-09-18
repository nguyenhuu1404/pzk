{? 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?}
<script src="/3rdparty/uploadify/jquery.uploadify.min.js"
	type="text/javascript"></script>
<link rel="stylesheet" href="/3rdparty/uploadify/uploadify.css"
	type="text/css" />
<div class="col-xs-{xssize} col-md-{mdsize}">
   <div   class="form-group clearfix">
	<b>{data.getLabel()}</b><br /> <br />
      <?php if($data->getUploadtype() == 'image') { ?>
      <img id="{data.getIndex()}{rand}_image" src="{data.getValue()}"
		height="80px" width="auto">
      <?php } ?>
      <input id="{data.getIndex()}{rand}_value" name="{data.getIndex()}"
		value="{data.getValue()}" type="hidden" /> <input type="file"
		name="{data.getIndex()}" id="{data.getIndex()}{rand}" multiple="true" />
	<a href="javascript:$('#{data.getIndex()}{rand}').uploadify('upload')">Upload
		Files</a>
</div>
</div>

<script type="text/javascript">
      <?php $timestamp = $_SERVER['REQUEST_TIME'];?>
      setTimeout(function() {
          $('#{data.getIndex()}{rand}').uploadify({
              'formData'     : {
                  'timestamp' : '<?php echo $timestamp;?>',
                  'token'     : '<?php echo md5(SECRETKEY . $timestamp);?>',
                  'uploadtype' : '<?php echo $data->getUploadtype(); ?>'
              },
              'swf'      : BASE_URL+'/3rdparty/uploadify/uploadify.swf',
              'uploader' : BASE_URL+'/3rdparty/uploadify/uploadify.php',
              'folder' : BASE_URL+'/3rdparty/uploads/videos',
              'auto' : false,
              'onUploadSuccess' : function(file, data, response) {
                  var src = data;
                  $('#{data.getIndex()}{rand}_value').val(src);
                  <?php if($data->getUploadtype() == 'image') { ?>
                  $('#{data.getIndex()}{rand}_image').attr('src', src);
                  <?php } ?>
              }


          });
      }, 100);
  </script>