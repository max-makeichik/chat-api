<?php
class ImageController extends AppController {

    public $components = array('RequestHandler');

    public function add() {
        if ($this->request->is('post')) {
            $this->autoRender = false;
            $this->loadModel('User'); 

            $user = $this->User->find('first', array(
                'conditions' => array('User.session'=> $_POST['session']),
                ));
            $user_id = current(current($user));

            $base = $_REQUEST['image'];
            $image = $this->base64_to_jpeg( $base, $_SERVER['DOCUMENT_ROOT']. '/app/webroot/avatars/' . $user_id . '.jpg' );

            $image_url = Router::fullbaseUrl() . '/app/webroot/avatars/' . $user_id . '.jpg';
            $this->User->id = $user_id;
            $this->User->saveField('avatar_url', $image_url);
            return '{"image_url": ' . json_encode($image_url) . "}";
        }
    }

    public function base64_to_jpeg($base64_string, $output_file) {
        $ifp = fopen($output_file, "wb"); 

        $data = explode(',', $base64_string);

        fwrite($ifp, base64_decode($data[1])); 
        fclose($ifp); 

        return $output_file; 
    }

}