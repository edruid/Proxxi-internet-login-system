<h1><?=$user->username?></h1>
<? if($current_user != null && $current_user->has_access('edit_user')): ?>
	<p>
		<a href="/User/edit/<?=$user->username?>">Redigera medlemsdata</a>
	</p>
<? endif ?>
<img src="<?=$user->avatar_url?>" alt="<?=$user?>" />
<table>
	<tr>
		<th>Namn</th>
		<td><?=$user?></td>
	</tr>
	<? if($user->has_setting('show_phone')): ?>
		<tr>
			<th>Telefonnummer</th>
			<td><?=$user->phone1?></td>
		</tr>
	<? endif ?>
	<? if($user->has_setting('show_email')): ?>
		<tr>
			<th>epostadress</th>
			<td><?=$user->email?></td>
		</tr>
	<? endif ?>
</table>
