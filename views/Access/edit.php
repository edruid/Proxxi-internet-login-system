<form action="/Access/modify/<?=$access->code_name?>" method="post">
	<fieldset>
		<legend>Access</legend>
		<table>
			<tr>
				<th>Kodnamn</th>
				<td><?=$access->code_name?></td>
			</tr>
			<tr>
				<th>Namn</th>
				<td><input type="text" name="name" value="<?=$access->name?>" /></td>
			</tr>
		</table>
		<input type="submit" value="Spara" />
	</fieldset>
</form>
