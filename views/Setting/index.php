<p><a href="/Setting/create">Skapa ny inställning</a></p>
<table>
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Inställning</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($settings as $setting): ?>
			<tr>
				<td><a href="/Setting/edit/<?=$setting->code_name?>"><img src="/gfx/edit.png" alt="Redigera" /></a></td>
				<td><?=$setting?>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
