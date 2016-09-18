Function.prototype.pzkImpl = function(props) {
	this.prototype = $.extend(this.prototype || {}, props);
	return this;
};

Function.prototype.pzkExt = function(props) {
	var that = this;
	var func = function() {
		that.apply(this, arguments);
	};
	func.prototype = $.extend({}, this.prototype || {}, props);
	return func;
};

String.pzkImpl({
	ucfirst : function() {
		return this.substr(0, 1).toUpperCase() + this.substr(1);
	},
	isCss: function() {
		var re = /(?:\.([^.]+))?$/;
		return re.exec(this)[1] == 'css';
	},
	isJs: function() {
		var re = /(?:\.([^.]+))?$/;
		return re.exec(this)[1] == 'js';
	},
	trim: function() {
		return $.trim(this);
	},
	replaceAll: function(search, replacement) {
		var target = this;
		return target.split(search).join(replacement);
	},
	explode: function(delim) {
		return this.split(delim);
	},
	explodetrim: function(delim) {
		var arr = this.explode(delim);
		for(var i = 0; i < arr.length; i++) {
			arr[i] = arr[i].trim();
		}
		return arr;
	}
});

Array.pzkImpl({
	chunk: function(chunkSize) {
		var R = [];
		for (var i=0; i<this.length; i+=chunkSize)
			R.push(this.slice(i,i+chunkSize));
		return R;
	}
});

function prettyDate(now, time) {
	var date = new Date(time || ""), diff = (((new Date(now)).getTime() - date
			.getTime()) / 1000), day_diff = Math.floor(diff / 86400);

	if (isNaN(day_diff) || day_diff < 0 || day_diff >= 31)
		return;

	return day_diff == 0
			&& (diff < 60 && "vừa mới" || diff < 120 && "1 phút trước"
					|| diff < 3600 && Math.floor(diff / 60) + " phút trước"
					|| diff < 7200 && "1 giờ trước" || diff < 86400
					&& Math.floor(diff / 3600) + " giờ trước") || day_diff == 1
			&& "Hôm qua" || day_diff < 7 && day_diff + " ngày trước"
			|| day_diff < 31 && Math.ceil(day_diff / 7) + " tuần trước";
}

if(1 && (window.location.href.indexOf('admin_') === -1) && (window.location.host.indexOf('nextnobels.com') !== -1)) $(document).bind("contextmenu", function(e) {
	e.preventDefault();
});

// We also check for a text selection if ctrl/command are pressed along
// w/certain keys
if(1 && (window.location.href.indexOf('admin_') === -1) && (window.location.host.indexOf('nextnobels.com') !== -1)) $(document).keydown(function(ev) {
	// capture the event for a variety of browsers
	ev = ev || window.event;
	// catpure the keyCode for a variety of browsers
	kc = ev.keyCode || ev.which;
	// check to see that either ctrl or command are being pressed along w/any
	// other keys
	if ((ev.ctrlKey || ev.metaKey) && kc) {
		// these are the naughty keys in question. 'x', 'c', and 'c'
		// (some browsers return a key code, some return an ASCII value)
		if (kc == 99 || kc == 67 || kc == 88) {
			return false;
		}
	}
});

$(document).bind('keydown', function(e) {
  if(e.ctrlKey && (e.which == 83)) {
    e.preventDefault();
    return false;
  }
});

jQuery.fn.serializeForm = function() {
	var arr = this.serializeArray();
	var rslt = {};
	var indexJ = {};
	for (var i = 0; i < arr.length; i++) {
		var elem = arr[i];
		if (elem.name.indexOf('[') == -1) {
			rslt[elem.name] = elem.value;
		} else {
			elem.name = elem.name.replace(/\]\[/g, '.');
			elem.name = elem.name.replace(/\[/g, '.');
			elem.name = elem.name.replace(/\]/g, '');
			// console.log(elem.name);
			var parts = elem.name.split('.');

			var cur = rslt;

			for (var j = 0; j < parts.length - 1; j++) {
				if (typeof indexJ[j] == 'undefined')
					indexJ[j] = 0;
				var part = parts[j];
				if (part == '') {
					part = indexJ[j];
					indexJ[j]++;
				}
				if (typeof cur[part] == 'undefined') {
					cur[part] = {};
					indexJ[j + 1] = 0;
				}
				cur = cur[part];
			}
			if (typeof indexJ[parts.length - 1] == 'undefined')
				indexJ[parts.length - 1] = 0;
			var part = parts[parts.length - 1];
			if (part == '') {
				part = indexJ[parts.length - 1];
				indexJ[parts.length - 1]++;
			}
			cur[part] = elem.value;
		}
	}
	return rslt;
};

pzk = {
	page : 'index',
	elements : {},
	onloads: {},
	beforeloads: {},
	onload: function(elementId, callback) {
		if(typeof this.onloads[elementId] === 'undefined') {
			this.onloads[elementId] = [];
		}
		this.onloads[elementId].push(callback);
	},
	beforeload: function(elementId, callback) {
		if(typeof this.beforeloads[elementId] === 'undefined') {
			this.beforeloads[elementId] = [];
		}
		this.beforeloads[elementId].push(callback);
	},
	runOnload: function() {
		for(var elementId in this.onloads) {
			var elem = pzk.elements[elementId];
			var onloads = this.onloads[elementId];
			for(var i = 0; i < onloads.length; i++) {
				var callback = onloads[i];
				callback.call(elem);
			}
		}
	},
	service : function(service, data, callback, options) {
		$.ajax($.extend({
			url : '/service/run/' + service,
			data : data,
			success : callback
		}, options));
	},
	load : function(urls, callback, nocache) {
		var loaded = false;
		if (typeof urls == 'string') {
			urls = [ urls ];
		}
		if (typeof nocache == 'undefined')
			nocache = false; // default don't refresh
		$.when($.each(urls, function(i, url) {
			if (nocache)
				url += '?_ts=' + new Date().getTime(); // refresh?
			if (pzk._urls.indexOf(url) == -1) {
				$.ajax({
					url: 		url, 
					async: 		false,
					success: 	function(resp) {
						if (pzk.ext(url) == 'css') {
							$('<link>', {
								rel : 'stylesheet',
								type : 'text/css',
								'href' : url
							}).appendTo('head');
						} else if (pzk.ext(url) == 'js') {
							/*
							$('<script>', {
								type : 'text/javascript',
								'src' : url
							}).appendTo('head');*/
							eval(resp);
							if(callback)
								callback();
						}
						pzk._urls.push(url);
					}
				});
			}
		})).then(function() {
			
			if (0 && typeof callback == 'function')
				callback();
		});
	},
	ext : function(url) {
		var re = /(?:\.([^.]+))?$/;
		return re.exec(url)[1];
	},
	_urls : []
};
PzkObj = (function(props) {
	$.extend(this, props || {});
})
		.pzkImpl({
			init : function() {
			},
			$ : function(selector) {
				if (typeof selector == 'undefined')
					return $('#' + this.id);
				return $(selector, '#' + this.id);
			},
			toJson : function() {
				var rs = {};
				for ( var k in this) {
					if ((typeof this[k] != 'function')
							&& (typeof this[k] != 'object')) {
						rs[k] = this[k];
					}
				}
				return rs;
			}
		});

PzkController = function(props) {
	$.extend(this, props || {});
};

function pzk_init(instances) {
	for (var i = 0; i < instances.length; i++) {
		var props = instances[i];
		var inst = null;
		eval('inst = new ' + props['className'].ucfirst() + '(props);');
		pzk.elements[inst.id] = inst;
		eval('pzk_' + inst.id + ' = inst;');
		if(typeof pzk.beforeloads[inst.id] !== 'undefined') {
			var beforeloads = pzk.beforeloads[inst.id];
			for(var i = 0; i < beforeloads.length; i++) {
				var beforeload = beforeloads[i];
				beforeload.call(inst);
			}
		}
		inst.init();
	}
}

function setTinymce() {
	if(tinymce) {
		tinymce.init({
			selector: "textarea.tinymce",
			forced_root_block : "",
			force_br_newlines : true,
			force_p_newlines : false,
			relative_url: false,
			remove_script_host: false,
			plugins: [
				"advlist autolink lists link image charmap print preview anchor",
				"searchreplace visualblocks code fullscreen media",
				"insertdatetime media table contextmenu paste textcolor template"
			],

			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | styleselect formatselect fontselect fontsizeselect | forecolor backcolor | template",
			entity_encoding : "raw",
			relative_urls: false,
			external_filemanager_path: "/3rdparty/Filemanager/filemanager/",
			filemanager_title:"Quản lý file upload" ,
			external_plugins: { "filemanager" :"/3rdparty/Filemanager/filemanager/plugin.min.js"},
			height: 250,
			content_css: '/3rdparty/bootstrap3/css/bootstrap.min.css',
			templates: '/3rdparty/tinymce/plugins/tinymce-templates-bootstrap-templates/tinymce-templates-bootstrap-templates.php'
		});
	} else {
		pzk.load([BASE_URL + '/3rdparty/tinymce/js/tinymce/tinymce.min.js'], function() {
			tinymce.init({
				selector: "textarea.tinymce",
				forced_root_block : "",
				force_br_newlines : true,
				force_p_newlines : false,
				relative_url: false,
				remove_script_host: false,
				plugins: [
					"advlist autolink lists link image charmap print preview anchor",
					"searchreplace visualblocks code fullscreen media",
					"insertdatetime media table contextmenu paste textcolor template"
				],

				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | styleselect formatselect fontselect fontsizeselect | forecolor backcolor | template",
				entity_encoding : "raw",
				relative_urls: false,
				external_filemanager_path: "/3rdparty/Filemanager/filemanager/",
				filemanager_title:"Quản lý file upload" ,
				external_plugins: { "filemanager" :"/3rdparty/Filemanager/filemanager/plugin.min.js"},
				height: 250,
				content_css: '/3rdparty/bootstrap3/css/bootstrap.min.css',
				templates: '/3rdparty/tinymce/plugins/tinymce-templates-bootstrap-templates/tinymce-templates-bootstrap-templates.php'
			});	
		});	
	}
	
	
}

function ajaxindicatorstart(text,formname)
{
	if(jQuery('#'+formname).find('#resultLoading').attr('id') != 'resultLoading'){
	jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src="'+BASE_URL+'/default/skin/test/media/ajax-loader.gif"><div>'+text+'</div></div><div class="bg"></div></div>');
	}
	
	jQuery('#resultLoading').css({
		'width':'100%',
		'height':'100%',
		'position':'fixed',
		'z-index':'10000000',
		'top':'0',
		'left':'0',
		'right':'0',
		'bottom':'0',
		'margin':'auto'
	});	
	
	jQuery('#resultLoading .bg').css({
		'background':'#000000',
		'opacity':'0.7',
		'width':'100%',
		'height':'100%',
		'position':'absolute',
		'top':'0'
	});
	
	jQuery('#resultLoading>div:first').css({
		'text-align': 'center',
		'position': 'fixed',
		'top':'140px',
		'left':'0',
		'right':'0',
		'bottom':'0',
		'margin':'auto',
		'font-size':'16px',
		'z-index':'10',
		'color':'#ffffff'
		
	});

	jQuery('#resultLoading .bg').height('100%');
	jQuery('#resultLoading').fadeIn(300);
	jQuery('#'+formname).css('cursor', 'wait');
}

function ajaxindicatorstop(formname)
{
	jQuery('#resultLoading .bg').height('100%');
	jQuery('#resultLoading').fadeOut(300);
	jQuery('#'+formname).css('cursor', 'default');
}

// Simple JavaScript Templating
// John Resig - http://ejohn.org/ - MIT Licensed
(function(){
  var cache = {};
 
  this.tmpl = function tmpl(str, data){
    // Figure out if we're getting a template, or if we need to
    // load the template - and be sure to cache the result.
    var fn = !/\W/.test(str) ?
      cache[str] = cache[str] ||
        tmpl(document.getElementById(str).innerHTML) :
     
      // Generate a reusable function that will serve as a template
      // generator (and which will be cached).
      new Function("obj",
        "var p=[],print=function(){p.push.apply(p,arguments);};" +
       
        // Introduce the data as local variables using with(){}
        "with(obj){p.push('" +
       
        // Convert the template into pure JavaScript
        str
          .replace(/[\r\t\n]/g, " ")
          .split("<%").join("\t")
          .replace(/((^|%>)[^\t]*)'/g, "$1\r")
          .replace(/\t=(.*?)%>/g, "',$1,'")
          .split("\t").join("');")
          .split("%>").join("p.push('")
          .split("\r").join("\\'")
      + "');}return p.join('');");
   
    // Provide some basic currying to the user
    return data ? fn( data ) : fn;
  };
})();

$.fn.tmpl = function(str, data) {
	if(str.indexOf('#') === 0) {
		str = $(str).html();
	}
	var parsed = tmpl(str, data);
	this.html(parsed);
};

var originalBG = $(".nav a").css("background-color");

$('.nav li:not(".active") a')
.mousemove(function(e) {

    x  = e.pageX - this.offsetLeft;
    y  = e.pageY - this.offsetTop;
    xy = x + " " + y;

    bgWebKit = "-webkit-gradient(radial, " + xy + ", 0, " + xy + ", 100, from(rgba(255,255,255,0.8)), to(rgba(255,255,255,0.0))), " + originalBG;
    bgMoz    = "-moz-radial-gradient(" + x + "px " + y + "px 45deg, circle, " + lightColor + " 0%, " + originalBG + " " + gradientSize + "px)";

    $(this)
      .css({ background: bgWebKit })
      .css({ background: bgMoz });

}).mouseleave(function() {
        $(this).css({ background: originalBG });
});

$(function() {
	$('.btncon .btn-custom:first').click(function() {
		var isLoggedIn = false;
		$.ajax({
			url: '/home/checkIsLoggedIn',
			async: false,
			success: function(resp) {
				if(resp == '1') {
					isLoggedIn = true;
				} else {
					isLoggedIn = false;
				}
			}
		});
		if(isLoggedIn) {
			return true;
		} else {
			alert('Bạn cần đăng nhập mới được dùng thử');
			return false;
		}
		
	});
});
var question_audios = {};
var current_sound = null;
var current_sound_url = null;
function read_question(elem, url) {
	if(current_sound) {
		current_sound.pause();
		current_sound.currentTime = 0;
		current_sound.onended();
	}
	if(current_sound_url == url) {
		current_sound_url = null;
		return ;
	} else {
		current_sound_url = url;
	}
	$(elem).removeClass('glyphicon-volume-up').addClass('glyphicon-volume-off');
	if(typeof question_audios[url] == 'undefined') {
		sound = new Audio(url);
		sound.loop = false;	
		question_audios[url] = sound;
		sound.onended = function() {
			$(elem).removeClass('glyphicon-volume-off').addClass('glyphicon-volume-up');
		};
	}
	current_sound = question_audios[url];
	question_audios[url].play();
}

function postToIframe(data,url,target){
    $('body').append('<form action="'+url+'" method="post" target="'+target+'" id="postToIframe"></form>');
    $.each(data,function(n,v){
        $('#postToIframe').append('<input type="hidden" name="'+n+'" />');
		$('#postToIframe').find('input[name='+n+']').val(v);
    });
    $('#postToIframe').submit().remove();
}

$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

function nl2br(str) {
	return str.replaceAll("\n", '<br />');
}

RegExp.pzkImpl({
	execAll: function(string) {
		var match = null;
		var matches = new Array();
		while (match = this.exec(string)) {
			var matchArray = [];
			for (i in match) {
				if (parseInt(i) == i) {
					matchArray.push(match[i]);
				}
			}
			matches.push(matchArray);
		}
		var result = [];
		if(matches.length) {
			var numOfRs = matches[0].length;
			for(var j = 0; j < numOfRs; j++) {
				result.push([]);
			}
			for(var i = 0; i < matches.length; i++) {
				for(var k = 0; k < numOfRs; k++) {
					result[k].push(matches[i][k]);
				}
			}
		}
		return result;
	}
}); 

String.pzkImpl({
	matchAll: function(rg) {
		return rg.execAll(this);
	}
});

$.fn.binds = function(events, handler) {
	var evts = events.explodetrim(',');
	var that = this;
	$.each(evts, function(index, evt) {
		that.bind(evt, handler);
	});
};

function define(str, value) {
	window[str]		= 	value;
}


function setInputTinymceClient() {
	
	if(tinymce) {
		tinymce.init({
			selector: "textarea.tinymce_input",
			forced_root_block : "",
			force_br_newlines : true,
			force_p_newlines : false,
			relative_url: false,
			remove_script_host: false,
			
			toolbar: "forecolor backcolor",
			entity_encoding : "raw",
			relative_urls: false,
			external_filemanager_path: "/3rdparty/Filemanager/filemanager/",
			filemanager_title:"Quản lý file upload" ,
			external_plugins: { "filemanager" :"/3rdparty/Filemanager/filemanager/plugin.min.js"},
			height: 100,
			content_css: '/3rdparty/bootstrap3/css/bootstrap.min.css'
		});
	} else {
		pzk.load([BASE_URL + '/3rdparty/tinymce/js/tinymce/tinymce.min.js'], function() {
			tinymce.init({
				selector: "textarea.tinymce_input",
				forced_root_block : "",
				force_br_newlines : true,
				force_p_newlines : false,
				relative_url: false,
				remove_script_host: false,
				

				toolbar: "forecolor backcolor",
				entity_encoding : "raw",
				relative_urls: false,
				external_filemanager_path: "/3rdparty/Filemanager/filemanager/",
				filemanager_title:"Quản lý file upload" ,
				external_plugins: { "filemanager" :"/3rdparty/Filemanager/filemanager/plugin.min.js"},
				height: 100,
				content_css: '/3rdparty/bootstrap3/css/bootstrap.min.css'
			});	
		});	
	}
	
	
}





function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };

$(document).ready(function(){
	if(window.location.pathname.indexOf('trytest') !== -1)
		$(document).on("keydown", disableF5);
});

/*js table*/

function tableitemize() {
	if($('table.tableitem').length){
		$('table.tableitem').each(function(index, tableitem){
			var $tableitem = $(tableitem);
			var headertext = [],
			headers = $tableitem.find("th"),
			tablerows = $tableitem.find("th"),
			tablebody = $tableitem.find("tbody");

			for(var i = 0; i < headers.length; i++) {
			  var current = $(headers[i]);
			  headertext.push(current.text().replace(/\r?\n|\r/,""));
			} 
			if(tablebody){
				if(tablebody.rows) {
					for (var i = 0, row; row = tablebody.rows[i]; i++) {
					  for (var j = 0, col; col = row.cells[j]; j++) {
						col.setAttribute("data-th", headertext[j]);
					  } 
					}
				}
			}	
		});
		
	}	
}
function addImageReposive() {
	
	$(".choice .ptnn-title img").each(function() {
		if($(this).width() > 100) {
			$(this).addClass('img-responsive');
		}
	});

	$(".choice table tr td img").each(function() {
		if($(this).width() > 100) {
			$(this).addClass('img-responsive');
		}
	});

	$(".popover-content img").each(function() {
		if($(this).width() > 100) {
			$(this).addClass('img-responsive');
		}
	});

	$(".choice img").each(function() {
		if($(this).width() > 100) {
			$(this).addClass('img-responsive');
		}
	});

	
}
$(document).ready(function() {
	tableitemize();
	addImageReposive();
});

(function ($, window) {

    $.fn.contextMenu = function (settings) {

        return this.each(function () {

            // Open context menu
            $(this).on("contextmenu", function (e) {
                // return native menu if pressing control
                if (e.ctrlKey) return;
                
                //open menu
                var $menu = $(settings.menuSelector)
                    .data("invokedOn", $(e.target))
                    .show()
                    .css({
                        position: "absolute",
                        left: getMenuPosition(e.clientX, 'width', 'scrollLeft'),
                        top: getMenuPosition(e.clientY, 'height', 'scrollTop')
                    })
                    .off('click')
                    .on('click', 'a', function (e) {
                        $menu.hide();
                
                        var $invokedOn = $menu.data("invokedOn");
                        var $selectedMenu = $(e.target);
                        
                        settings.menuSelected.call(this, $invokedOn, $selectedMenu);
                    });
                
                return false;
            });

            //make sure menu closes on any click
            $('body').click(function () {
                $(settings.menuSelector).hide();
            });
        });
        
        function getMenuPosition(mouse, direction, scrollDir) {
            var win = $(window)[direction](),
                scroll = $(window)[scrollDir](),
                menu = $(settings.menuSelector)[direction](),
                position = mouse + scroll;
                        
            // opening menu would pass the side of the page
            if (mouse + menu > win && menu < mouse) 
                position -= menu;
            
            return position;
        }    

    };
})(jQuery, window);

window.mobileAndTabletcheck = function() {
  var check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
}

window.mobilecheck = function() {
  var check = false;
  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
  return check;
}

function translateTl(that) {
	$(that).next().toggle();
}

