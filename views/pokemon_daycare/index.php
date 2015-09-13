
			<div class="tpp-app tpp-app-pokemon-daycare tpp-app-hidden"><?php
$this->render('pokemon_daycare/_general', array('count' => count($pokemon))); ?>

				<div class="table-responsive table-bordered table-pokemon pokemon-scrollable mtop20">
					<div class="tpp-app-table-div"><?php
foreach($pokemon as $p) { ?>
						<div>
<?php
	$this->render('pokemon/_info', array('p' => $p));
	$this->render('pokemon/_image', array('size' => 80, 'p' => $p));
	$this->render('pokemon/_level', array('p' => $p));
	$this->render('pokemon/_nickname', array('p' => $p));
	$this->render('pokemon/_moves', array('p' => $p));
?>
						</div> <?php
} ?>
					</div>
				</div>
			</div>