<h1>filter</h1>
<div id = filterInfo></div>

<script id="Filter-tpl" type="text/x-handlebars-template">
	<h1 id="Filter">{{filter}}</h1>
	{{#each sections}}
	<li>
	{{name}}
	</li>
	{{/each}}
</script>
