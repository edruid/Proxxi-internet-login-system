<form action="/Group/modify/<?=$group->id?>" method="post">
	<fieldset>
		<legend>Redigera grupp</legend>
		<table>
			<tr>
				<th>Namn</th>
				<td><input type="text" name="name" value="<?=$group->name?>" /></td>
			</tr>
		</table>
		<input type="submit" value="spara" />
	</fieldset>
</form>
<?php
	if($current_user->has_access('edit_group_access')) {
		self::_partial('GroupAccess/edit', array($group));
	}
?>
