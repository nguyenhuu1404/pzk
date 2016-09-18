<?php 
$rand 		= rand(1, 100);
$xssize 	= pzk_or($data->getXssize(), 12);
$mdsize 		= pzk_or($data->getMdsize(), 12);
?>
<script src="/3rdparty/uploadify/jquery.uploadify.min.js"
	type="text/javascript"></script>
<link rel="stylesheet" href="/3rdparty/uploadify/uploadify.css"
	type="text/css" />
<div class="col-xs-<?php echo isset($xssize)?$xssize: '';?> col-md-<?php echo isset($mdsize)?$mdsize: '';?>">
   <div   class="form-group clearfix">
	<b><?php echo isset($data)?$data->getLabel(): '';?></b><br /> <br />
      <?php if($data->getUploadtype() == 'image') { ?>
      <img id="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>_image" src="<?php echo isset($data)?$data->getValue(): '';?>"
		height="80px" width="auto">
      <?php } ?>
      <input id="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>_value" name="<?php echo isset($data)?$data->getIndex(): '';?>"
		value="<?php echo isset($data)?$data->getValue(): '';?>" type="hidden" /> <input type="file"
		name="<?php echo isset($data)?$data->getIndex(): '';?>" id="<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>" multiple="true" />
	<a href="javascript:$('#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>').uploadify('upload')">Upload
		Files</a>
</div>
</div>

<script type="text/javascript">
      <?php $timestamp = $_SERVER['REQUEST_TIME'];?>
      setTimeout(function() {
          $('#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>').uploadify({
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
                  $('#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>_value').val(src);
                  <?php if($data->getUploadtype() == 'image') { ?>
                  $('#<?php echo isset($data)?$data->getIndex(): '';?><?php echo isset($rand)?$rand: '';?>_image').attr('src', src);
                  <?php } ?>
              }


          });
      }, 100);
  </script>