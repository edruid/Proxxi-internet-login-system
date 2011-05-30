<h1><?=$access?></h1>
<p>Namn i koden: <?=$access->code_name?></p>
<table>
	<thead>
		<tr>
			<th>Grupp</th>
			<th>Giltigt till</th>
		<tr>
	</thead>
	<tbody>
		<? foreach($access->GroupAccess as $group_access): ?>
			<tr>
				<td><a href="/Group/view<?=$group_access->group_id?>"><?=$group_access->Group?></a></td>
				<td>
					<? if($group_access->permanent): ?>
						Permanent
					<? else: ?>
						<?=$group_access->valid_until?>
					<? endif ?>
				</td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
