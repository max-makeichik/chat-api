<?php
class User extends AppModel {
	public $actsAs = array('Containable');
    public $hasMany = array('Message');
}