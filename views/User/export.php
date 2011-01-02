<table>
	<thead>
		<tr>
			<th>Förnamn</th>
			<th>Efternamn</th>
			<th>Personnummer</th>
			<th>Medlemsavgift</th>
			<th>Medlemskaps början</th>
			<th>Medlemskaps slut</th>
			<th>Kön</th>
			<th>C/O</th>
			<th>Gatuadress</th>
			<th>Postnummer</th>
			<th>Postort</th>
			<th>Land</th>
			<th>e-post</th>
			<th>Telefonnummer</th>
			<th>Alt. telefonnummer</th>
		</tr>
	</thead>
	<tbody>
		<? foreach($memberships as $membership): ?>
			<? $user = $membership->User ?>
			<tr>
				<td><?=$user->first_name?></td>
				<td><?=$user->surname?></td>
				<td><?=$user->personnummer?></td>
				<td><?=$user->member_fee($date)?></td>
				<td><?=$membership->start?></td>
				<td><?=$membership->end?></td>
				<td><?=$user->Sex=='male'?'Man':'Kvinna'?></td>
				<td><?=$user->co?></td>
				<td><?=$user->street_address?></td>
				<td><?=$user->area_code?></td>
				<td><?=$user->area?></td>
				<td>Sverige</td>
				<td><?=$user->email?></td>
				<td><?=$user->phone1?></td>
				<td><?=$user->phone2?></td>
			</tr>
		<? endforeach ?>
	</tbody>
</table>
			
