<? foreach(Message::get_errors() as $error): ?>
	<p class="error message"><?=$error?></p>
<? endforeach ?>
<? foreach(Message::get_warnings() as $warning): ?>
	<p class="warning message"><?=$warning?></p>
<? endforeach ?>
<? foreach(Message::get_notices() as $notice): ?>
	<p class="message notice"><?=$notice?></p>
<? endforeach ?>

