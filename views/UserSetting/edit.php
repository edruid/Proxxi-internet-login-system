<form action="/UserSetting/modify" method="post">
	<fieldset>
		<legend>Inställningar</legend>
		<ul>
			<? foreach($settings as $setting): ?>
				<li>
					<label>
						<input type="checkbox" name="<?=$setting->code_name?>"
								<?=UserSetting::count(array(
									'user_id' => $user->id,
									'setting_id' => $setting->id,
								)) > 0 ? 'checked="checked"' : ''?> />
						<?=$setting->name?>
					</label>
				</li>
			<? endforeach ?>
		</ul>
		<input type="submit" value="Spara inställningar" />
	</fieldset>
</form>
