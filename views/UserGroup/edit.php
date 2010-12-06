<form action="/UserGroup/modify" method="post">
	<fieldset>
		<legend>Rättighetsgrupper</legend>
		<ul>
			<? foreach($groups as $group): ?>
				<li>
					<label>
						<input type="checkbox" name="<?=$group->id?>"
								<?=$user->in_group($group) > 0 ?
								'checked="checked"' :
								''?>
								<?=$group->may_grant($current_user)?
								'':
								'disabled="disabled"'
								?>/>
						<?=$group->name?>
					</label>
				</li>
			<? endforeach ?>
		</ul>
		<input type="submit" value="Spara rättigheter" />
	</fieldset>
</form>
