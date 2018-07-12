<?php
script('ownnotes','handlebars-v4.0.11');
style('ownnotes','style');
script('ownnotes','script');
style('ownnotes','test');

?>
<div id="app">
	<div id="app-navigation">
		<?php print_unescaped($this->inc('part.navigation')); ?>
	</div>

	<div id="app-content">
		<div id="app-content-wrapper">
			<?php print_unescaped($this->inc('part.test')); ?>
		</div>
	</div>

</div>

<!--<div id="app">-->
<!--	<div id="app-navigation">-->
<!--		--><?php //print_unescaped($this->inc('part.filter'));?>
<!--	</div>-->
<!--</div>-->