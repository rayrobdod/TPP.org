<?php

class SiteController extends Controller {
	//a

	public function actionIndex() {
		$messages = $this->getMessages();
		$this->render('site/general', array('messages' => $messages));
	}

	public function getMessages() {
//		$getMessages = $this->db->prepare("SELECT m.`id`, m.`message`, m.`sent_user`, s.`suggestion` FROM `message` m LEFT JOIN `suggestion` s ON m.`suggestion_id` = s.`id` ORDER BY `date_created` ASC LIMIT 1") or die($this->db->error);
		$getMessages = $this->db->prepare("SELECT m.`id`, m.`message`, m.`sent_user`, s.`suggestion` FROM `message` m LEFT JOIN `suggestion` s ON m.`suggestion_id` = s.`id` WHERE m.`read` = 0 AND m.`ip` = ? ORDER BY `date_created` ASC LIMIT 1") or die($this->db->error);
		$getMessages->bind_param('s', $_SERVER["REMOTE_ADDR"]);
		$getMessages->execute();
		$getMessages->bind_result($messageId, $message, $sentUser, $suggestion);
		$getMessages->store_result();

		$return = null;

		if($getMessages->num_rows > 0) {
			while($getMessages->fetch()) {
				$return = array('message' => $message, 'id' => $messageId, 'sentUser' => $sentUser, 'suggestion' => $suggestion);
			}
		}
		$getMessages->free_result();
		return $return;
	}

}
