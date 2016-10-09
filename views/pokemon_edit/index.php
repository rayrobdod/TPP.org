			<table class="pokemon_input">
				<tr>
					<th>Species</th>
					<th>Name</th>
					<th>Level</th>
					<th>Nickname</th>
					<th>Status</th>
					<th></th>
				</tr>
				
				<?php
foreach($pokemon as $p) { ?>
				<tr>
					<form method="POST" action="index.php" >
						<input type="hidden" name="id" value="<?= $p->id;  ?>" />
					<td><input type="text" name="pokemon" value="<?= $p->pokemon;  ?>" />
					<td><input type="text" name="name" value="<?= $p->name;  ?>" />
					<td><input type="number" name="level" min="0" max="255" value="<?= $p->level;  ?>" />
					<td><input type="text" name="nickname" value="<?= $p->nickname;  ?>" />
					<td><select name="status" method="POST" action="submit.php">
						<option value="1" <?= ($p->value == 1 ? "selected" : ""); ?>>In party</option>
						<option value="2" <?= ($p->value == 2 ? "selected" : ""); ?>>In box</option>
						<option value="3" <?= ($p->value == 3 ? "selected" : ""); ?>>Released</option>
						<option value="4" <?= ($p->value == 4 ? "selected" : ""); ?>>Traded</option>
						<option value="5" <?= ($p->value == 5 ? "selected" : ""); ?>>Evolved</option>
						<option value="6" <?= ($p->value == 6 ? "selected" : ""); ?>>Daycare</option>
						<option value="7" <?= ($p->value == 7 ? "selected" : ""); ?>>Hatched</option>
						<option value="8" <?= ($p->value == 8 ? "selected" : ""); ?>>Lost</option>
					</select></td>
					<td><input type="submit" name="pokemon-row" value="Submit Changes" />
					</form>
				</tr>
				<?php
}
?>