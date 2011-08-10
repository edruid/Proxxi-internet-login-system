<table>
	<thead>
		<tr>
			<th>Kommun</th>
			<th>Kön</th>
			<th>Ålder</th>
			<th>Antal</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($lokalbidrag as $row): ?>
			<tr>
				<td><?=$row['kommun'] ? 'Stockholm' : 'Övrigt'?></td>
				<td><?=$row['sex']?></td>
				<td><?=$row['ages']?></td>
				<td class="numeric"><?=$row['count']?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
<table>
	<caption>Närvarosammanställning</caption>
	<thead>
		<tr>
			<th>Kön</th>
			<th>Ålder</th>
			<th>Antal</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($attendance_grant as $row): ?>
			<tr>
				<td><?=$row['sex']?></td>
				<td><?=$row['ages']?></td>
				<td class="numeric"><?=$row['attendance']?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
