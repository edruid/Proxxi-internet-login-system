<form method="post" action="/User/make">
	<fieldset>
		<legend>Skapa Användare</legend>
		<table>
			<tr>
				<th>Användarnamn</th>
				<td><input type="text" value="<?=ClientData::defaults('username')?>" name="username" /></td>
			</tr>
			<tr>
				<th>Förnamn</th>
				<td><input type="text" value="<?=ClientData::defaults('first_name')?>" name="first_name" /></td>
			</tr>
			<tr>
				<th>Efternamn</th>
				<td><input type="text" value="<?=ClientData::defaults('surname')?>" name="surname" /></td>
			</tr>
			<tr>
				<th>Personnummer</th>
				<td>
					<input type="text" value="<?=ClientData::defaults('birthdate')?>" name="birthdate" maxlength="10" size="10" onblur="fixPersonnummer(this, document.getElementById('person_id_number'));" /> - 
					<input type="text" value="<?=ClientData::defaults('person_id_number')?>" id="person_id_number" name="person_id_number" maxlength="4" size="4" />
				</td>
			</tr>
			<tr>
				<th>Kön</th>
				<td>
					<label>
						<input type="radio" name="sex" value="male" <?=ClientData::defaults('sex')=='male'?'checked="checked"':''?> />
						Man
					</label>
					<label>
						<input type="radio" name="sex" value="female" <?=ClientData::defaults('sex')=='female'?'checked="checked"':''?> />
						Kvinna
					</label>
				</td>
			</tr>
			<tr>
				<th>Telefonnummer</th>
				<td><input type="text" value="<?=ClientData::defaults('phone1')?>" name="phone1" /></td>
			</tr>
			<tr>
				<th>Alt. telefonnummer</th>
				<td><input type="text" value="<?=ClientData::defaults('phone2')?>" name="phone2" /></td>
			</tr>
			<tr>
				<th>e-postadress</th>
				<td><input type="text" value="<?=ClientData::defaults('email')?>" name="email" /></td>
			</tr>
			<tr>
				<th>C/o</th>
				<td><input type="text" value="<?=ClientData::defaults('co')?>" name="co" /></td>
			</tr>
			<tr>
				<th>Gatuadress</th>
				<td><input type="text" value="<?=ClientData::defaults('street_address')?>" name="street_address" /></td>
			</tr>
			<tr>
				<th>Postadress</th>
				<td>
					<input type="text" value="<?=ClientData::defaults('area_code')?>" name="area_code" size="5" maxlength="6" />
					<input type="text" value="<?=ClientData::defaults('area')?>" name="area" />
				</td>
			</tr>
			<tr>
				<th>Lösenord</th>
				<td><input type="password" name="password" /></td>
			</tr>
			<tr>
				<th>Bekräfta lösenord</th>
				<td><input type="password" name="confirm_password" /></td>
			</tr>
		</table>
		<?php
			self::_partial('UserSetting/create');
		?>
		<ul>
			<? foreach($eulas as $eula): ?>
				<li>
					<label>
						<input
							type="checkbox"
							name="eula/<?=$eula->code_name?>"
							<? if(ClientData::defaults("eula/$eula->code_name")=='on'): ?>
								checked="checked"
							<? endif ?>
						/>
						Jag har läst och accepterat föreningens <a href="<?=$eula->url?>"><?=$eula->name?></a>
					</label>
				</li>
			<? endforeach ?>
		</ul>
		<input type="submit" value="Bli medlem" />
	</fieldset>
</form>
<? ClientData::clear_defaults() ?>
