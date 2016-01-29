<?php
class SessionController extends AppController {

    public function add() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $this->loadModel('User'); 

            $user = $this->User->find('first', array(
                'conditions' => array('User.session'=> $_POST['session']),
                'fields' => ['id']
                ));
            
            return json_encode($user);
        }
    }
}