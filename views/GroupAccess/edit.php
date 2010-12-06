<form action="/GroupAccess/modify/<?=$group->id?>" method="post">
	<fieldset>
		<legend>Rättigheter</legend>
		<table>
			<thead>
				<tr>
					<th>Rättighet</th>
					<th>Access</th>
				</tr>
			</thead>
			<tbody>
				<? foreach($accesses as $access): ?>
					<tr>
						<td><?=$access?></td>
						<? $group_access = $group->has_access($access->code_name) ?>
						<td>
							<ul>
								<li>
									<label>
										<input type="radio"
											name="<?=$access->code_name?>"
											value="off"
											<?= $group_access==null?
												'checked="checked"':
												''?>
											onchange="toggle_disable(document.getElementById('<?=$access->code_name?>'), !this.checked);"
										/>
										Ej access
									</label>
								</li>
								<li>
									<label>
										<input type="radio"
											name="<?=$access->code_name?>"
											value="permanent"
											<?= ($group_access!=null && $group_access->permanent!=0)?
												'checked="checked"':
												''?>
											onchange="toggle_disable(document.getElementById('<?=$access->code_name?>'), !this.checked);"
										/>
										Permanent access
									</label>
								</li>
								<li>
									<label>
										<input type="radio"
											name="<?=$access->code_name?>"
											value="timed"
											<?= ($group_access!=null && $group_access->permanent==0)?
												'checked="checked"':
												''?>
											onchange="toggle_disable(document.getElementById('<?=$access->code_name?>'), this.checked);"
										/>
										Tidsbegränsad till:
									</label>
									<input type="text"
										id="<?=$access->code_name?>"
										name="<?=$access->code_name?>/valid_until"
										<?= ($group_access!=null && $group_access->permanent==0)?
											"value=\"$group_access->valid_until\"":
											'disabled="disabled"'?>
									/>
								</li>
							</ul>
						</td>
					</tr>
				<? endforeach ?>
			</tbody>
		</table>
		<input type="submit" value="Spara" />
	</fieldset>
</form>
