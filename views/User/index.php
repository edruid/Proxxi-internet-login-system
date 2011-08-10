<h1>Användare</h1>
<?php
self::_partial('User/table', array($users, 'Medlemmar'));
?>
<div>
	<? if($start == 0): ?>
		&lt;&lt;&lt;
	<? else: ?>
		<a href="/User/index/<?=max($start-100, 0)?>">&lt;&lt;&lt;</a>
	<? endif ?>
	<? for($i=1; ($i-1)*100<$count; $i++): ?>
		<a href="/User/index/<?=($i-1)*100?>"><?=$i?></a>
	<? endfor ?>
</div>

