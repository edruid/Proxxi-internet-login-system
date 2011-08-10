<form action="/Attendance/group_make" method="post">
	<fieldset>
		<legend>Rapportera närvaro för <?=$group->name?></legend>
		Datum: <input type="text" name="date" value="<?=date('Y-m-d')?>" />
		<table>
			<thead>
				<tr>
					<th>Avatar</th>
					<th>Medlem</th>
					<th>Närvarande</th>
				</tr>
			</thead>
			<tbody>
				<? foreach($users as $user): ?>
					<tr>
						<td><img src="<?=$user->avatar_url?>" alt="<?=$user?>" /></td>
						<td>
							<a href="/User/view/<?=$user?>">
								<?=$user->first_name?> <?=$user->surname?>
							</a>
							<input type="hidden" name="user[]" value="<?=$user->username?>" />
						</td>
						<td><input type="checkbox" name="attending[]" /></td>
					</tr>
				<? endforeach ?>
			</tbody>
		</table>
		<input type="submit" value="Rapportera" />
	</fieldset>
</form>
