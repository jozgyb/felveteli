<div class="fej">
	<h2> Híroldal</h2>
	<h4>Ha bármilyen híre van kérem ossza megvelünk!</h4>
</div>
<div class="hiroldal">
	<div class="hiroldal2">
		<form method="post" name="hirek">
			<fieldset>
				<legend>
					<h3>Hír Létrehozása</h3>
				</legend>
				<div class="sor"><textarea name="uzenet" placeholder="Üzenet" rows="5" cols="62"></textarea></div>
				<div class="sor"><input type=submit id="gomb" name="gomb" value="Küldés"></div>
			</fieldset>
		</form>
	</div>
	<div class="ho">
		<div class="hir">Hírek</div>
		<?php
		$i = 1;
		foreach ($viewData['uzenet'] as $uzenet) {
		?><div class="nevresz">
				<div class="kiir">
					<?php
					echo "Felhasználónév: " . $uzenet->felhasznalonev . "<br>";
					?>
				</div>
				<div class="tartalom2">
					<?php
					echo "Üzenet: <br>" . $uzenet->uzenet . "<br>";
					?> </div>
				<div class="kiir">
					<?php
					echo "Dátum: " . $uzenet->idobelyeg . "<br>";
					?></div>
				<div class="tartalom">
					<form method="post">
						<h5>Komment</h5>
						<textarea rows="2" cols="100" class="komment" name="komment"></textarea><input type="text" class="tuntes" name="tuntes" value="<?php echo $i;
																																						$i++; ?>"><input name="komigomb" class="komigomb" type="submit">
					</form>
				</div>
				<?php if (!empty($uzenet->kommentek)) { ?>
					<div class="komm">
						<?php
						echo "Kommentek: <br>";
						foreach ($uzenet->kommentek as $komment) {
						?><div class="komm1"><?php
												echo $komment . "<br>";
												?></div><?php
												}
													?>
					</div>
				<?php } ?>
			</div>
		<?php
		}
		?>


	</div>