<form action="/UserGroup/modify/<?=$user->username?>" method="post">
	<fieldset class="hidden">
		<legend onclick="toggle_hidden(this.parentNode)">Rättighetsgrupper</legend>
		<table>
			<thead>
				<tr>
					<th>Grupp</th>
					<th>Access</th>
				</tr>
			</thead>
			<tbody>
				<? foreach($groups as $group): ?>
					<? $user_group = $group->UserGroup(array(
						'user_id' => $user->id
					)); $user_group = array_shift($user_group); 
					?>
					<tr>
						<td><?=$group?></td>
						<td>
							<ul>
								<li>
									<label>
										<input type="radio"
											name="<?=$group->id?>"
											value="off"
											<?= $user_group == null ?
												'checked="checked"' :
												''
											?>
											onchange="toggle_disable(document.getElementById('group_<?=$group->id?>'), !this.checked);"
										/>
										Ej access
									</label>
								</li>
								<li>
									<label>
										<input type="radio"
											name="<?=$group->id?>"
											value="permanent"
											<?= ($user_group != null && $user_group->permanent) ?
												'checked="checked"' :
												''
											?>
											onchange="toggle_disable(document.getElementById('group_<?=$group->id?>'), !this.checked);"
										/>
										Permanent access
									</label>
								</li>
								<li>
									<label>
										<input type="radio"
											name="<?=$group->id?>"
											value="timed"
											<?= ($user_group != null && !$user_group->permanent) ?
												'checked="checked"' :
												''
											?>
											onchange="toggle_disable(document.getElementById('group_<?=$group->id?>'), this.checked);"
										/>
										Tidsbegränsad till:
									</label>
									<input type="text"
										name="group_<?=$group->id?>/valid_until"
										id="group_<?=$group->id?>"
										<?= ($user_group!=null && !$user_group->permanent)?
											"value=\"{$user_group->valid_until}\"":
											'disabled="disabled"'
										?>
									/>	
								</li>
							</ul>
						</td>
					</tr>
				<? endforeach ?>
			</tbody>
		</table>
		<input type="submit" value="Spara rättigheter" />
	</fieldset>
</form>
