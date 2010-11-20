<? foreach(Message::get_errors() as $error): ?>
	<p class="error"><?=$error?></p>
<? endforeach ?>
<? foreach(Message::get_warnings() as $warning): ?>
	<p class="warning"><?=$warning?></p>
<? endforeach ?>
<? foreach(Message::get_notices() as $notice): ?>
	<p class="notice"><?=$notice?></p>
<? endforeach ?>

