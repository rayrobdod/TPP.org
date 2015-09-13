
			<div class="tpp-app tpp-app-item tpp-app-hidden"><?php
$this->render('item/_general', array('count' => count($items))); ?>

				<div class="tpp-app-item-list"> <?php
foreach($items as $type => $column) {

	$this->render('item/_item', array('type' => $type, 'items' => $column));
} ?>
				</div>

			</div>