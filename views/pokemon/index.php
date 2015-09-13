<?php $i = 1; ?>
			<div class="tpp-app tpp-app-pokemon-party"><?php
$this->render('pokemon/_general', array('owned' => $owned, 'seen' => $seen)); ?>

				<div class="table-responsive table-bordered table-pokemon pokemon-scrollable" id="table-pokemon">
					<div class="tpp-app-table-div" id="tpp-app-table-div-pokemon"><?php
foreach($pokemon as $p) { ?>
						<div class="tpp-app-table-div-pokemon-pokemon-<?php print $i;?>">
<?php
	$i = $i + 1;
	$this->render('pokemon/_info', array('p' => $p));
	$this->render('pokemon/_image', array('p' => $p));
	$this->render('pokemon/_level', array('p' => $p));
	$this->render('pokemon/_nickname', array('p' => $p));
	$this->render('pokemon/_hold_item', array('p' => $p));
	$this->render('pokemon/_moves', array('p' => $p));
	$this->render('pokemon/_ability', array('p' => $p));
	$this->render('pokemon/_nature', array('p' => $p));
	$this->render('pokemon/_characteristic', array('p' => $p));
	$this->render('pokemon/_next_move', array('p' => $p));
	$this->render('pokemon/_evolution', array('p' => $p));
?>
						</div><?php
} ?>
					</div>
				</div>
			</div>