<h1><?=$group?></h1>
<table>
	<caption>Gruppmedlemmar</caption>
	<thead>
		<tr>
			<th>Namn</th>
			<th>Användarnamn</th>
			<th>Inloggade datorer</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($users as $user): ?>
			<tr>
				<td><?=$user?></td>
				<td><a href="/User/view/<?=$user->username?>"><?=$user->username?></a></td>
				<td>
					<? foreach($user->Session as $their_session): ?>
						<div><?=$their_session?></div>
					<? endforeach ?>
				</td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
