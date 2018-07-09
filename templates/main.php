<?php
script('ownnotes','handlebars-v4.0.11');
style('ownnotes', 'style');  // adds ownnotes/css/style.css
script('ownnotes','script');
?>
<div id="app">
	<div id="app-navigation">
		<?php print_unescaped($this->inc('part.navigation')); ?>
	</div>

	<div id="app-content">
		<div id="app-content-wrapper">
			<?php print_unescaped($this->inc('part.content')); ?>
		</div>
	</div>

</div>
