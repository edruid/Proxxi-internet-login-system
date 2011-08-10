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
			<? if($current_user->has_access('view_user')): ?>
				<td><a href="/Attendance/group_create/<?=$group->id?>">Rapportera närvaro</a></td>
			<? endif ?>
		</tr>
	<? endforeach ?>
</table>
