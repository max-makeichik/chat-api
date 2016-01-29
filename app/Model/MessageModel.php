<?php
class Message extends AppModel {
	public $actsAs = array('Containable');
    public $belongsTo = array('User');
}