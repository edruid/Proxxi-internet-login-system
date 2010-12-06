<form action="/Attendance/make" method="post">
	<fieldset>
		<legend>Rapportera närvaro</legend>
		<table>
			<tr>
				<th>Användarnamn</th>
				<td><input type="text" name="username" /></td>
			</tr>
			<tr>
				<th>Dag</th>
				<td><input type="text" name="day" value="<?=date('Y-m-d')?>"/></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Rapportera" /></td>
			</tr>
		</table>
	</fieldset>
</form>
