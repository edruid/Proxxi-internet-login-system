<script type="text/javascript">
<!--
	function swapNodes(elem1, elem2) {
		var parent1 = elem1.parentNode;
		var parent2 = elem2.parentNode;
		parent1.insertBefore(elem2, elem1);
		parent2.insertBefore(elem1, elem2);
	}
	function move_up(elem) {
		var other = elem.previousSibling;
		while(other != null && other.tagName!='TR') {
			other = other.previousSibling;
		}
		if(other != null) {
			swapNodes(elem, other);
		}
	}
	function move_down(elem) {
		var other = elem.nextSibling;
		while(other != null && other.tagName!='TR') {
			other = other.nextSibling;
		}
		if(other != null) {
			swapNodes(other, elem);
		}
	}
	function update_color(color, elem) {
		elem.style.backgroundColor = color;
	}
	function add_fields() {
		var poll_alts_elem =  document.getElementById('poll_alts');
		var poll_alts = poll_alts_elem.getElementsByTagName('tr');
		if(poll_alts[poll_alts.length-1].getElementsByTagName('input')[0].value != '') {
			var tr = document.createElement('tr');
			var td_text = document.createElement('td');
			var td_color = document.createElement('td');
			var td_buttons = document.createElement('td');
			var input_text = document.createElement('input');
			var input_color = document.createElement('input');
			var color_display = document.createElement('span');
			var button_down = document.createElement('button');
			var button_up = document.createElement('button');
			input_text.name='text[]';
			input_text.type='text';
			input_text.onblur=add_fields;
			input_color.name='color[]';
			input_color.type='text';
			input_color.onblur=function() {
				update_color(this.value, this.nextSibling);
			};
			color_display.className='color_display';
			color_display.innerHTML='&nbsp;';
			input_text.name='text[]';
			button_up.innerHTML = 'Upp';
			button_up.type = 'button';
			button_up.onclick = function() {
				move_up(this.parentNode.parentNode);
				return false;
			};
			button_down.innerHTML = 'Ned';
			button_down.type = 'button';
			button_down.onclick = function() {
				move_down(this.parentNode.parentNode);
				return false;
			};
			tr.appendChild(td_text);
			tr.appendChild(td_color);
			tr.appendChild(td_buttons);
			td_text.appendChild(input_text);
			td_color.appendChild(input_color);
			td_color.appendChild(color_display);
			td_buttons.appendChild(button_up);
			td_buttons.appendChild(document.createTextNode(' '));
			td_buttons.appendChild(button_down);
			poll_alts_elem.appendChild(tr);
		}
	}
-->
</script>
<form method="post" action="/Poll/make">
	<fieldset>
		<legend>Skapa omröstning</legend>
		<input type="submit" value="Skapa omröstning" style="display:hidden;" />
		<h3>Fråga</h3>
		<textarea name="question" cols="80" rows="5"><?=ClientData::defaults('question')?></textarea><br/>
		<h3>Förklarande text</h3>
		<textarea name="description" cols="80" rows="10"><?=ClientData::defaults('description')?></textarea>
		<p>Rösta till: <input type="text" name="vote_until" value="<?=ClientData::defaults('vote_until')?>" /></p>
		<table>
			<thead>
				<tr>
					<th>Svarsalternativ</th>
					<th>Färg</th>
					<th>Flytta</th>
				</tr>
			</thead>
			<tbody id="poll_alts">
				<? foreach($poll_alts as $alt): ?>
					<tr>
						<td>
							<input
								type="text"
								name="text[]"
								value="<?=$alt['text']?>"
							/>
						</td>
						<td>
							<input
								type="text"
								name="color[]"
								value="<?=$alt['color']?>"
							/><span
								class="color_display"
								style="background-color:<?=$alt['color']?>;"
							>&nbsp;</span>
						</td>
						<td>
							<button
								onclick="move_up(parentNode.parentNode);return false;"
							>Upp</button>
							<button
								onclick="move_down(parentNode.parentNode);return false;"
							>Ned</button>
						</td>
					</tr>
				<? endforeach ?>
				<tr>
					<td>
						<input
							type="text"
							name="text[]"
							onblur="add_fields();"
						/>
					</td>
					<td>
						<input
							type="text"
							name="color[]"
							onblur="update_color(this.value, this.nextSibling);"
						/><span class="color_display">&nbsp;</span>
					</td>
					<td>
						<button
							onclick="move_up(parentNode.parentNode); return false;"
						>Upp</button>
						<button
							onclick="move_down(parentNode.parentNode); return false;"
						>Ned</button>
					</td>
				</tr>
			</tbody>
		</table>
		<input type="submit" value="Skapa omröstning" />
	</fieldset>
</form>
