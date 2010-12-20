<form action="/Membership/make/<?=$user->username?>" method="post">
	<fieldset>
		<legend>Medlemskap</legend>
		<table>
			<tr>
				<th>Medlem till</th>
				<td><input type="text" name="end" value="<?=$membership!=null?$membership->end:''?>" /></td>
			</tr>
		</table>
		<input type="submit" value="Uppdatera medlemskap" />
	</fieldset>
</form>
<fieldset class="hidden">
	<legend>Tidigare medlemskap</legend>
	<table>
		<thead>
			<tr>
				<th>Från</th>
				<th>Till</th>
			</tr>
		</thead>
		<tbody>
			<? foreach($current_user->Membership(array('@order' => 'end:desc')) as $membership): ?>
				<tr>
					<td><?=$membership->start?></td>
					<td><?=$membership->end?></td>
				</tr>
			<? endforeach ?>
		</tbody>
	</table>
</fieldset>
