<? if($user->id == $current_user->id): ?>
	<h1>Min info</h1>
<? else: ?>
	<h1>Redigera <?=$user?></h1>
<? endif ?>
<form method="post" action="/User/modify">
	<div style="display:none;">
	<input type="hidden" name="user" value="<?=$user->id?>" />
	</div>
	<table>
		<? if($admin): ?>
			<tr>
				<th>Användarnamn</th>
				<td><input type="text" value="<?=$user->username?>" name="username" /></td>
			</tr>
			<tr>
				<th>Förnamn</th>
				<td><input type="text" value="<?=$user->first_name?>" name="first_name" /></td>
			</tr>
			<tr>
				<th>Efternamn</th>
				<td><input type="text" value="<?=$user->surname?>" name="surname" /></td>
			</tr>
			<tr>
				<th>Personnummer</th>
				<td>
					<input type="text" value="<?=$user->birthdate?>" name="birthdate" maxlength="10" size="10" /> - 
					<input type="text" value="<?=$user->person_id_number?>" name="person_id_number" maxlength="4" size="4" />
				</td>
			</tr>
			<tr>
				<th>Kön</th>
				<td>
					<label>
						<input type="radio" name="sex" value="male" <?=$user->sex=='male'?'checked="checked"':''?> />
						Man
					</label>
					<label>
						<input type="radio" name="sex" value="female" <?=$user->sex=='female'?'checked="checked"':''?> />
						Kvinna
					</label>
		<? else: ?>
			<tr>
				<th>Användarnamn</th>
				<td><?=$user->username?></td>
			</tr>
			<tr>
				<th>Namn</th>
				<td><?=$user?></td>
			</tr>
			<tr>
				<th>Personnummer</th>
				<td><?=$user->personnummer?></td>
			</tr>
			<tr>
				<th>Kön</th>
				<td><?=$user->sex=='male'?'Man':'Kvinna'?></td>
			</tr>
		<? endif ?>
		<tr>
			<th>Telefonnummer</th>
			<td><input type="text" value="<?=$user->phone1?>" name="phone1" /></td>
		</tr>
		<tr>
			<th>Alt. telefonnummer</th>
			<td><input type="text" value="<?=$user->phone2?>" name="phone2" /></td>
		</tr>
		<tr>
			<th>e-postadress</th>
			<td><input type="text" value="<?=$user->email?>" name="email" /></td>
		</tr>
		<tr>
			<th>Gatuadress</th>
			<td><input type="text" value="<?=$user->street_address?>" name="street_address" /></td>
		</tr>
		<tr>
			<th>Postadress</th>
			<td>
				<input type="text" value="<?=$user->area_code?>" name="area_code" size="5" maxlength="6" />
				<input type="text" value="<?=$user->area?>" name="area" />
			</td>
		</tr>
		<tr>
			<th>Sätt nytt lösenord</th>
			<td><input type="password" name="password" /></td>
		</tr>
		<tr>
			<th>Bekräfta nytt lösenord</th>
			<td><input type="password" name="confirm_password" /></td>
		</tr>
		<tr>
			<th>Lösenord</th>
			<td><input type="password" name="old_password" /></td>
		</tr>
			
	</table>
	<? if($user->id == $current_user->id): ?>
		<ul>
			<? foreach($settings as $setting): ?>
				<li>
					<label>
						<input type="checkbox" name="<?=$setting->code_name?>"
								<?=UserSetting::count(array(
									'user_id' => $user->id,
									'setting_id' => $setting->id,
								)) > 1 ? 'checked="checked"' : ''?> />
						<?=$setting->name?>
					</label>
				</li>
			<? endforeach ?>
		</ul>
	<? endif ?>
	<div>
		<input type="submit" value="Uppdatera" />
	</div>
</form>
