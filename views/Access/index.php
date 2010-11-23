<h1>Rättigheter</h1>
<table>
	<? foreach($accesses as $access): ?>
		<tr>
			<? if($session && $current_user->has_access('access_editor')): ?>
				<td><a href="/Access/edit/<?=$access->id?>"><img src="/gfx/edit.png" alt="Redigera" /></a></td>
			<? endif ?>
			<td><a href="/Access/view/<?=$access->id?>"><?=$access?></a></td>
		</tr>
	<? endforeach ?>
</table>

