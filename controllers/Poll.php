<?php
class PollC extends Controller {
	public function index($params) {
		$this->_access_type("html");
		$polls = Poll::selection(array(
				'@order' => 'poll_id:desc',
				'@limit' => array($start, 10),
		));
		$this->_register('polls', $polls);
		$this->_display('index');
		new LayoutC('html');
	}

	public function create($params) {
		$this->_access_type("html");
		global $current_user;
		if($current_user == null || !$current_user->has_access('edit_poll')) {
			Message::add_error('Du har inte access att skapa omröstningar');
			URL::redirect('');
		}
		$poll_alts = array();
		$texts = ClientData::defaults('text');
		$colors = ClientData::defaults('color');
		if($texts) {
			for($i = 0; $i < count($texts); $i++) {
				if($texts[$i]) {
					$poll_alts[] = array(
						'text' => $texts[$i],
						'color' => $colors[$i],
					);
				}
			}
		}
		$this->_register('poll_alts', $poll_alts);
		$this->_display('create');
		new LayoutC('html');
	}

	public function vote($params) {
		$this->_access_type("script");
		global $current_user, $db;
		if($current_user == null) {
			Message::add_error('Du måste vara inloggad för att få rösta.');
			URL::redirect('');
		}
		$alternative = PollAlternative::from_id(ClientData::post('alternative'));
		if($alternative == null) {
			Message::add_error("Kunde inte hitta omröstningen.");
			URL::redirect();
		}
		$poll = Poll::from_id(array_shift($params));
		if(!$poll->may_vote($current_user)) {
			Message::add_error('Du får tyvärr inte rösta i denna omröstning.');
			URL::redirect('');
		}
		$db->autocommit(false);
		$alternative->num_votes += 1;
		$alternative->commit();
		$voter = new Voter();
		$voter->user_id = $current_user->id;
		$voter->poll_id = $poll->id;
		$voter->commit();
		$db->commit();
		Message::add_notice('Tack för att du gör din röst hörd.');
		URL::redirect();
	}

	public function make($params) {
		$this->_access_type("script");
		global $current_user, $db;
		$error = false;
		$db->autocommit(false);
		if($current_user == null || !$current_user->has_access('edit_poll')) {
			Message::add_error('Du har inte access att skapa omröstningar');
			ClientData::defaults_set($_POST);
			URL::redirect();
		}
		$poll = new Poll();
		$fields = array(
			'question',
			'description',
			'vote_until',
		);
		$poll->creator = $current_user->id;
		foreach($fields as $field) {
			try{
				$poll->question = ClientData::post('question');
			} catch(Exception $e) {
				Message::add_error($e->getMessage());
				$error=true;
			}
		}
		try{
			$poll->commit();
			$colors = ClientData::post('color');
			$alts = ClientData::post('text');
			for($i = 0; $i < count($alts); $i++) {
				if($alts[$i] == '') {
					continue;
				}
				try{
					$alt = new PollAlternative();
					$alt->poll_id = $poll->id;
					$alt->text = $alts[$i];
					$alt->color = $colors[$i];
					$alt->commit();
				} catch(Exception $e) {
					Message::add_error($e->getMessage());
					$error=true;
				}
			}
		} catch(Exception $e) {
			Message::add_error($e->getMessage());
			$error = true;
		}
		if($error){
			ClientData::defaults_set($_POST);
			URL::redirect();
		} else {
			$db->commit();
			URL::redirect("/Poll/view/{$poll->id}");
		}
	}

	public function delete($params) {
		$this->_access_type("script");
		if($current_user == null || !$current_user->has_access('edit_poll')) {
			Message::add_error('Du har inte access att ta bort omröstningar');
			$error = true;
		}
	}
}
?>
