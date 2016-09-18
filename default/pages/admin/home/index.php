<page id="page">
	
	<html.head id="head" layout="admin/home/head" charset="utf-8">
		<plugin.jquery />
		<plugin.validate />
		<plugin.bootstrap theme="true" />
		<plugin.bootstrap.select2 />
		<plugin.tinymce />
		<plugin.jqueryui />
		<plugin.jqueryui.timepicker />
		<plugin.jqueryui.daterangepicker />
		<html.js src="/js/components.js" />
    </html.head>
    <html.body id="body">
		<home.menu layout="admin/home/menu" />
		<home.content layout="admin/home/content">
			<home.right id="right" layout="admin/home/right" />
			<home.left id="left" layout="admin/home/left" />
		</home.content>
		<home.footer layout="admin/home/footer" />
	</html.body>
</page>