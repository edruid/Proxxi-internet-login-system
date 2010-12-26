<table>
	<? if(isset($caption)): ?>
		<caption><?=$caption?></caption>
	<? endif ?>
	<thead>
		<tr>
			<th>Avatar</th>
			<th>Förnamn</th>
			<th>Efternamn</th>
			<th>Användarnamn</th>
			<th>Inloggade datorer</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($users as $user): ?>
			<tr>
				<td><img src="<?=$user->avatar_url?>" alt="<?=$user?>" /></td>
				<td><?=$user->first_name?></td>
				<td><?=$user->surname?></td>
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
