<div class="row carousel-holder">

	<div class="col-md-12">
		<div id="{prop id}" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				{? foreach($data->children as $index => $child):?}
				<li data-target="#{prop id}" data-slide-to="{index}"></li>
				{? endforeach;?}
			</ol>
			<div class="carousel-inner">
			{? foreach($data->children as $child):?}
				<div class="item">
					{? $child->display(); ?}
				</div>
			{? endforeach;?}
			</div>
			<a class="left carousel-control" href="#{prop id}" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="right carousel-control" href="#{prop id}" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div>
	</div>

</div>