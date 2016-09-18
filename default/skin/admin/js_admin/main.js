

/**
 * @author Admin
 * 
 * Jan 17, 2015
 * 
 * Confirm Delete Item
 */
function confirm_delete(message) {
	
	if (confirm(message)) {
		
		return true;
	}
	return false;
}

function setTinymce(checkspelling) {
    var options = {
        selector: "textarea.tinymce",
        forced_root_block : "",
		statusbar: false,
        force_br_newlines : true,
        force_p_newlines : false,
        relative_url: false,
        remove_script_host: false,
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen media",
            "insertdatetime media table contextmenu paste textcolor"
        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | styleselect formatselect fontselect fontsizeselect | forecolor backcolor latex",
        entity_encoding : "raw",
        relative_urls: false,
        external_filemanager_path: BASE_URL +"/3rdparty/Filemanager/filemanager/",
        filemanager_title:"Quản lý file upload" ,

        external_plugins: { "filemanager" :BASE_URL +"/3rdparty/Filemanager/filemanager/plugin.min.js", "nanospell": BASE_URL+"/3rdparty/nanospell/plugin.js"},
        nanospell_server: "php",
        height: 250,
		setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        }
    };
    if(!checkspelling) {
        delete options.external_plugins.nanospell;
        delete options.nanospell_server;
    }
    tinymce.init(options);
}
function setInputTinymce(checkspelling) {
    var options = {
        selector: "textarea.tinymce_input",
        forced_root_block : "",
        force_br_newlines : false,
        force_p_newlines : false,
        relative_url: false,
        remove_script_host: false,
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen media",
            "insertdatetime media table contextmenu paste textcolor"
        ],
        toolbar: "forecolor backcolor",
        entity_encoding : "raw",
        relative_urls: false,
        external_filemanager_path: BASE_URL +"/3rdparty/Filemanager/filemanager/",
        filemanager_title:"Quản lý file upload" ,
        external_plugins: { "filemanager" :BASE_URL +"/3rdparty/Filemanager/filemanager/plugin.min.js", "nanospell": BASE_URL+"/3rdparty/nanospell/plugin.js"},
        nanospell_server: "php",
        height: 100
    };
    if(!checkspelling) {
        delete options.external_plugins.nanospell;
        delete options.nanospell_server;
    }
    tinymce.init(options);
}
