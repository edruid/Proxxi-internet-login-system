<ul>
	<? foreach($settings as $setting): ?>
		<li>
			<label>
				<input type="checkbox" name="setting/<?=$setting->code_name?>"
					<? if(ClientData::defaults('setting/'.$setting->code_name)): ?>
						checked="checked"
					<? endif ?>
				/>
				<?=$setting->name?>
			</label>
		</li>
	<? endforeach ?>
</ul>
