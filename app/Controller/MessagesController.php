<?php
class MessagesController extends AppController {

	public function index() {
		$this->autoRender = false;
		$this->loadModel('User');

		$fieldsMessage = array_keys($this->Message->getColumnTypes());
		$key = array_search('user_id', $fieldsMessage);
		unset($fieldsMessage[$key]);

		$fieldsUser = array_keys($this->User->getColumnTypes());		
		$key = array_search('session', $fieldsUser);
		unset($fieldsUser[$key]);
		foreach ($fieldsUser as &$value)
			$value = 'User.'.$value;

		$messages = $this->Message->find('all', array(
			'joins' => array(
				array(
					'table' => 'users',
					'alias' => 'User',
					'type' => 'INNER',
					'conditions' => array(
						'User.id = Message.user_id'
						)
					)
				),
			'fields' => array_merge($fieldsMessage, $fieldsUser),
			'order' => array('Message.id DESC'),
			'limit' => isset($_GET['paging_size']) ? $_GET['paging_size'] : 20,
			'conditions' => isset($_GET['newest_message_id']) ? array('Message.id >'=> $_GET['newest_message_id']) :
			(isset($_GET['oldest_message_id']) ? array('Message.id <'=> $_GET['oldest_message_id']) : null),
			//'fields' => array('UserJoin.*', 'Message.*')
			));

		return '{"messages": ' . json_encode($messages) . "}";

	}

	public function view($id) {
		$this->autoRender = false;
		$article = $this->Message->findById($id);
		$this->set(array(
			'article' => $article,
			'_serialize' => array('article')
			));
	}

}