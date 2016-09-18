<?php 
$items 			= $data->getItems();
$parentItem 	= $data->getParentItem();
$allNews 		= $data->getAllNews();
$allQuestions 	= $data->getAllQuestions();
?>
<h2>Thư mục "{parentItem[name]}"</h2>
<div class="col-xs-1">
<a href="/admin_directory/index/{parentItem[parent]}">
	<div class="thumbnail text-center" style="height: 100px;">
		<span>..</span>
	</div>
</a>
</div>
{each $items as $item}
<div class="col-xs-1">
<a href="/admin_directory/index/{item[id]}">
	<div class="context-menu thumbnail text-center" data-itemId="{item[id]}" rel="{item[id]}" style="height: 100px;">
		<span>{? echo cut_words($item['name'], 8); ?}</span>
	</div>
</a>
</div>
{/each}

<div class="col-xs-1">
<a href="/admin_category/add?parent={parentItem[id]}&status=1&display=1&backHref=" onclick="window.location=$(this).attr('href') + encodeURI(window.location.href); return false;">
	<div class="thumbnail text-center" style="height: 100px;">
		<span>[+] Thêm mới</span>
	</div>
</a>
</div>


<div class="clearfix"></div>
<hr />
<h2>Tin tức mục "{parentItem[name]}"</h2>
{? if(count($allNews)):?}

{each $allNews as $item}
<div class="col-xs-2">
<a target="_blank" href="/admin_news/view/{item[id]}">
	<div class="thumbnail context-news text-center" rel="{item[id]}" style="height: 100px;">
		<span>{item[title]}</span>
	</div>
</a>
</div>
{/each}
{? endif; ?}

<div class="col-xs-2">
<a href="/admin_news/add?categoryId={parentItem[id]}&status=1&backHref=" onclick="window.location=$(this).attr('href') + encodeURI(window.location.href); return false;">
	<div class="thumbnail text-center" style="height: 100px;">
		<span>[+] Thêm mới</span>
	</div>
</a>
</div>

<div class="clearfix"></div>
<hr />
<h2>Câu hỏi mục "{parentItem[name]}"</h2>
<div class="question">
<a target="_blank" href="/admin_category/importQuestions/{parentItem[id]}">
	<div class="thumbnail text-center red">
		<span>Import câu hỏi</span>
	</div>
</a>
</div>


{? if(count($allQuestions)):?}
<div class="col-xs-2" style="height: 500px; overflow-x: hidden;">
{each $allQuestions as $item}
<div class="question">
<a target="_blank" href="/admin_question2/detail/{item[id]}"
		onclick="$('#questionDetail').load('/admin_question2/detailFull/{item[id]}'); return false;">
	<div class="context-question thumbnail text-left" rel="{item[id]}" style="height: 100px;">
		<span><strong>{item[id]} #{item[ordering]}. </strong>{? echo cut_words(strip_tags($item['name']), 20);?}</span>
	</div>
</a>
</div>
{/each}
</div>
<div class="col-xs-10">
	<div id="questionDetail">
	
	</div>
</div>
{? endif; ?}

<style type="text/css">
.label-success-important {
	background-color: #5cb85c !important;
}
</style>
	<link rel="stylesheet" href="/3rdparty/jquery/contextMenu/dist/jquery.contextMenu.min.css" type="text/css" media="screen">
    <script type="text/javascript" src="/3rdparty/jquery/contextMenu/dist/jquery.ui.position.min.js"></script>
    <script type="text/javascript" src="/3rdparty/jquery/contextMenu/dist/jquery.contextMenu.min.js"></script>
    <script type="text/javascript">
        items = {
          addChild: {name: 'Thêm thư mục con', icon: 'copy', callback: function(key, options) {
				window.location = '/admin_category/add?parent=' + $(this).attr('rel') + '&status=1&display=1&backHref=' + encodeURI(window.location.href);
              }},
		  edit: {name: 'Sửa', icon: 'edit', callback: function(key, options) {
				window.location = '/admin_category/edit/' + $(this).attr('rel') + '?backHref=' + encodeURI(window.location.href);
              }},
		  del: {name: 'Xóa', icon: 'delete', callback: function(key, options) {
				if(confirm('Bạn có chắc là muốn xóa thư mục ' + $(this).text())) {
					window.location = '/admin_category/del/' + $(this).attr('rel') + '?backHref=' + encodeURI(window.location.href);
				}
				
              }},
          importQuestions: {name: 'Nhập dữ liệu', icon: 'add', callback: function(key, options){
        	  window.location = '/admin_category/importQuestions/' + $(this).attr('rel');
              }}
        };

      $.contextMenu({
        selector: '.context-menu',
        items: items
      });
	  
	  newsItems = {
		  edit: {name: 'Sửa', icon: 'edit', callback: function(key, options) {
				window.location = '/admin_news/edit/' + $(this).attr('rel') + '?backHref=' + encodeURI(window.location.href);
              }},
		  del: {name: 'Xóa', icon: 'delete', callback: function(key, options) {
				if(confirm('Bạn có chắc là muốn xóa tin ' + $(this).text())) {
					window.location = '/admin_news/del/' + $(this).attr('rel') + '?backHref=' + encodeURI(window.location.href);
				}
				
              }}
	  };
	  
	  $.contextMenu({
        selector: '.context-news',
        items: newsItems
      });
	  
	  questionItems = {
		  detail: {
			  name: 'Chi tiết', icon: 'detail', callback: function(key, options) {
				$('#questionDetail').load('/admin_question2/detailFull/' + $(this).attr('rel'));
				
              }
		  },
		  edit: {name: 'Sửa', icon: 'edit', callback: function(key, options) {
				window.location = '/admin_question2/edit/' + $(this).attr('rel') + '?backHref=' + encodeURI(window.location.href);
              }},
		  answerEdit: {
			  name: 'Sửa Câu trả lời', icon: 'edit', callback: function(key, options) {
				window.location = '/admin_question2/detail/' + $(this).attr('rel') + '?backHref=' + encodeURI(window.location.href);
				
              }
		  },
		  del: {name: 'Xóa', icon: 'delete', callback: function(key, options) {
				if(confirm('Bạn có chắc là muốn xóa tin ' + $(this).text())) {
					window.location = '/admin_question2/del/' + $(this).attr('rel') + '?backHref=' + encodeURI(window.location.href);
				}
				
              }}
	  };
	  
	  $.contextMenu({
        selector: '.context-question',
        items: questionItems
      });
	  

      PzkCoreDirectory = {
		select: function(elem) {
			$('.label-success-important').removeClass('label-success-important');
			$(elem).find('>div').addClass('label-success-important');
		}
      };
    </script>