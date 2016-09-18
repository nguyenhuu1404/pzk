<page id="page">
	<home.head id="head" layout="home/head" charset="utf-8">
		<html.css src="/default/skin/nobel/ptnn/css/style.css" />
		<html.css src="/default/skin/nobel/ptnn/css/user.css" />
		<themes.themes />
		<html.css src="/3rdparty/bootstrap3/css/bootstrap.min.css" />
		<html.js src="/3rdparty/jquery/jquery-1.11.1.min.js" />
		<html.js src="/js/components.js" />
		<html.js src="/3rdparty/bootstrap3/js/bootstrap.min.js" />
		<html.js src="/3rdparty/Validate/dist/jquery.validate.js" />
		<html.js src="/js/loadding.js" />
    </home.head>
	<home.top id="top" layout="home/top"/>
	<home.search id="search" layout="home/search">
		<user.account.user id="userAccountUser" layout="user/account/user" />
		<user.account.dialog id="userAccountDialog" cacheable="false" cacheParams="id,layout" />
	</home.search>
	
	<core.db.list table="categories" layout="home/menu" cacheable="false" cacheParams="id,parentId"/>
	<home.left id="left" layout="home/left"/>
	<home.right id="right" layout="home/right">
		
		<cms.newsletter.newsletter  layout="cms/newsletter/newsletter"  />
	
		<cms.AQs.AQshome  layout="cms/AQs/AQshome" />
		
	</home.right>
	<home.footer layout="home/footer"/>
	
</page>
