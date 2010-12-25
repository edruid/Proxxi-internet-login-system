<h1>Rättigheter</h1>
<? if($session && $current_user->has_access('edit_access')): ?>
	<p>
		<a href="/Access/create">Skapa ny rättighet</a>
	</p>
<? endif ?>
<table>
	<? foreach($accesses as $access): ?>
		<tr>
			<? if($session && $current_user->has_access('edit_access')): ?>
				<td><a href="/Access/edit/<?=$access->code_name?>"><img src="/gfx/edit.png" alt="Redigera" /></a></td>
			<? endif ?>
			<td><a href="/Access/view/<?=$access->code_name?>"><?=$access?></a></td>
		</tr>
	<? endforeach ?>
</table>

