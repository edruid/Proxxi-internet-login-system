<form action="/Setting/make" method="post">
	<fieldset>
		<legend onclick="toggle_hidden(this.parentNode);">Skapa Inställning</legend>
		<table>
			<tr title="Namnet på inställningen som syns mot användarna">
				<th>Namn</th>
				<td><input type="text" name="name" /></td>
			</tr>
			<tr title="Namnet som används i koden för att kontrollera om rättigheten finns.">
				<th>Kodnamn</th>
				<td><input type="text" name="code_name" /></td>
			</tr>
		</table>
		<input type="submit" value="Skapa ny inställning" />
	</fieldset>
</form>
