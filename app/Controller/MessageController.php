<?php
class MessageController extends AppController {

    public function add() {
        if ($this->request->is('post')) {
            $this->autoRender = false;
            $this->loadModel('Message'); 
            $this->loadModel('User'); 
            $this->Message->create();

            $user = $this->User->find('first', array(
                'conditions' => array('User.session'=> $_POST['session']),
                'fields' => ['id']
                ));

            $message = array(
                'Message' => array(
                    'user_id' => current(current($user)),
                    'text' => $_POST['text'],
                    'updated_at' => date("Y-m-d H:i:s"),
                    'image_url' => isset($_POST['image_url']) ? $_POST['image_url'] : null
                    )
                );

        //echo json_encode($message);
            if ($this->Message->save($message)) {
                $message = 'Saved';
                return '200';
            } else {
                $message = 'Error';
                debug($this->validationErrors); die();
            }
        }
    }

}