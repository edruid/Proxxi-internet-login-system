<h1>Användare</h1>
<?php
$this->_register('caption', 'Medlemmar');
UserC::_display('_list');
$this->_print_child();
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

