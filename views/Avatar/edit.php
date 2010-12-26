<form
	action="/Avatar/modify/<?=$user->username?>"
	method="post"
	enctype="multipart/form-data"
>
	<fieldset>
		<legend>Avatar</legend>
		<div>
			<img src="<?=$user->avatar_url?>" alt="<?=$user?>" />
		</div>
		<input type="hidden" value="30000" name="MAX_FILE_SIZE" />
		<input type="file" name="avatar" />
		<p>
			Avataren kommer skalas till 80x80 pixlar. Format som stöds är JPEG, PNG och GIF. 
		</p>
		<input type="submit" name="change" value="Byt bild" />
		<? if($user->has_avatar()): ?>
			<input type="submit" name="remove" value="Ta bort bild" />
		<? endif ?>
	</fieldset>
</form>
