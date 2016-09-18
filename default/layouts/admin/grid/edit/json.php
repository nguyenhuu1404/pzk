{? 
$rand = rand(1, 100);?}
<div class="form-group clearfix">
        <label for="{data.getIndex()}{rand}">{data.getLabel()}</label>
        <div id="{data.getIndex()}{rand}-json-editor" class="json-editor"></div>
		<input type="hidden" name="{data.getIndex()}" id="{data.getIndex()}{rand}" />
    </div>
	<link rel="stylesheet" href="/3rdparty/FlexiJsonEditor/jsoneditor.css"/>
	<script type="text/javascript" src="/3rdparty/FlexiJsonEditor/json2.js"></script>
	<script type="text/javascript" src="/3rdparty/FlexiJsonEditor/jquery.jsoneditor.js"></script>
    <script type="text/javascript">
		<?php if($data->getValue()): ?>
			var {data.getIndex()}{rand}json = {data.getValue()};
		<?php else: ?>
			<?php if($data->getIsArray()): ?>
			var {data.getIndex()}{rand}json = [];
			<?php else: ?>
			var {data.getIndex()}{rand}json = {};
			<?php endif; ?>
		<?php endif; ?>
function {data.getIndex()}{rand}printJSON() {
    $('#{data.getIndex()}{rand}').val(JSON.stringify({data.getIndex()}{rand}json));

}

function {data.getIndex()}{rand}updateJSON(data) {
    {data.getIndex()}{rand}json = data;
    {data.getIndex()}{rand}printJSON();
}

function {data.getIndex()}showPath(path) {
    $('#{data.getIndex()}-path').text(path);
}

$(document).ready(function() {

    $('#{data.getIndex()}{rand}').change(function() {
        var val = $('#{data.getIndex()}{rand}').val();

        if (val) {
            try { {data.getIndex()}{rand}json = JSON.parse(val); }
            catch (e) { alert('Error in parsing json. ' + e); }
        } else {
            {data.getIndex()}{rand}json = {};
        }
        
        $('#{data.getIndex()}{rand}-json-editor').jsonEditor({data.getIndex()}{rand}json, { change: {data.getIndex()}{rand}updateJSON, propertyclick: {data.getIndex()}{rand}showPath });
    });

    $('#expander').click(function() {
        var editor = $('#{data.getIndex()}{rand}-json-editor');
        editor.toggleClass('expanded');
        $(this).text(editor.hasClass('expanded') ? 'Collapse' : 'Expand all');
    });
    
    {data.getIndex()}{rand}printJSON();
    $('#{data.getIndex()}{rand}-json-editor').jsonEditor({data.getIndex()}{rand}json, { change: {data.getIndex()}{rand}updateJSON, propertyclick: {data.getIndex()}{rand}showPath });
});
    </script>