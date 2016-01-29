<?php
class SignupController extends AppController {

    public function add() {
        $this->autoRender = false;
        if ($this->request->is('post')) {
            $this->loadModel('User');

            $sessionKey = substr(str_shuffle(MD5(microtime())), 0, 36);
            $this->User->create();

            $user = array(
                'User' => array(
                    'session' => $sessionKey
                    )
                );

            if ($this->User->save($user)) {
                $message = 'Saved';
                $id = $this->User->id;
                $this->User->saveField('nickname', 'User ' . $id);
            } else {
                $message = 'Error';
            }
            return '{"session": ' . json_encode($sessionKey) . "}";
        }
    }
}