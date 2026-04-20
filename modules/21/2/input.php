<div class="row">
	<div class="col-xs-4">
		<input type="checkbox" name="REX_INPUT_VALUE[1]" value="true" <?= 'REX_VALUE[1]' === 'true' ? ' checked="checked"' : '' /** @phpstan-ignore-line */ ?> class="form-control d2u_helper_toggle" />
	</div>
	<div class="col-xs-8">
		Reihenfolge umkehren (neueste Events zuerst)<br />
	</div>
</div>
<div class="row">
	<div class="col-xs-12">&nbsp;</div>
</div>
<div class="row">
	<div class="col-xs-4">
		Anzuwendender Media Manager Typ bei Event-Bildern:
	</div>
	<div class="col-xs-8">
		<select name="REX_INPUT_VALUE[2]" class="form-control">
			<option value="">Originalbild</option>
			<?php
				$sql = rex_sql::factory();
				$result = $sql->setQuery('SELECT name FROM ' . rex::getTablePrefix() . 'media_manager_type ORDER BY status, name');
				for ($i = 0; $i < $result->getRows(); ++$i) {
					$name = $result->getValue('name');
					echo '<option value="'. $name .'"';
					if ('REX_VALUE[2]' === $name) { /** @phpstan-ignore-line */
						echo ' selected="selected"';
					}
					echo '>'. $name .'</option>';
					$result->next();
				}
			?>
		</select>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">&nbsp;</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<p>Alle weiteren Änderungen bitte im <a href="index.php?page=d2u_history/history">D2U History</a> vornehmen.</p>
	</div>
</div>