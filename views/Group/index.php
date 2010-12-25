<h1>Grupper</h1>
<? if($session && $current_user->has_access('edit_group')): ?>
	<p>
		<a href="/Group/create">Skapa ny grupp</a>
	</p>
<? endif ?>
<table>
	<? foreach($groups as $group): ?>
		<tr>
			<? if($session && $current_user->has_access('edit_group')): ?>
				<td><a href="/Group/edit/<?=$group->id?>"><img src="/gfx/edit.png" alt="Redigera" /></a></td>
			<? endif ?>
			<td><a href="/Group/view/<?=$group->id?>"><?=$group?></a></td>
		</tr>
	<? endforeach ?>
</table>
