<div class="menu">
	<ul>
		<li><a href="/Group/view/2">Nyckelbärare</a></li>
		<? if(Helpers::is_local()): ?>
			<li><a href="/Attendance/create">Närvarorapport</a></li>
			<li><a href="/Karaoke/index">Karaoke kö</a></li>
			<li><a href="https://sockerdricka/price_list">Kioskpriser</a></li>
		<? endif ?>
		<li><a href="/Static/stadgar">Stadgar</a></li>
		<li><a href="/Static/internet_rules">Internetregler</a></li>
		<li><a href="/Static/rules">Lokalregler</a></li>
		<? if($current_user): ?>
			<li><a href="/User/edit/<?=$current_user->username?>">Min info</a></li>
			<li><a href="/Poll/index">Omröstningar</a></li>
			<? if($current_user->has_access('create_news')): ?>
				<li><a href="/News/create">Ny nyhet</a></li>
			<? endif ?>
			<? if($current_user->has_access('multiple_login')): ?>
				<li><a href="/Session/remote_login">Logga in annan dator</a></li>
			<? endif ?>
			<? if($current_user->is_member() || $current_user->has_access('view_user')): ?>
				<li><a href="/Attendance/index">Lista närvarande</a></li>
			<? endif ?>
			<? if($current_user->has_access('view_user')): ?>
				<li><a href="/User/index">Lista användare</a></li>
				<li><a href="/Attendance/chart">Närvarodiagram</a></li>
				<li><a href="/Report/budget">Budget</a></li>
			<? endif ?>
			<? if($current_user->has_access('edit_user')): ?>
				<li><a href="/User/create">Skapa medlem</a></li>
			<? endif ?>
			<? if($current_user->has_access('edit_setting')): ?>
				<li><a href="/Setting/index">Inställningar</a></li>
			<? endif ?>
			<? if($current_user->has_access('edit_group') || $current_user->has_access('edit_group_access')): ?>
				<li><a href="/Group/index">Grupper</a></li>
			<? endif ?>
			<? if($current_user->has_access('edit_access')): ?>
				<li><a href="/Access/index">Rättigheter</a></li>
			<? endif ?>
			<li><a href="/Session/delete">Logga ut</a></li>
		<? else: ?>
			<li><a href="/User/create">Bli medlem</a></li>
		<? endif ?>
	</ul>
	<? if(!$current_user): ?>
		<?php
			self::_partial('Session/create');
		?>
	<? endif ?>
</div>
