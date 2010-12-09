<h1>Närvaro <?=$date?></h1>
<table>
	<thead>
		<tr>
			<th>Namn</th>
			<th>Användarnamn</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? foreach($users as $user): ?>
			<tr>
				<td><?=$user?></td>
				<td><a href="/User/view/<?=$user->username?>"><?=$user->username?></a></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
