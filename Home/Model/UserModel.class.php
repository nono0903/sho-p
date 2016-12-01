<?php 
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	protected $_validate = array(
		array('username','3,12','用户名字需是3-12位',1,'length'),
		array('username','','用户名已经存在',1,'unique'),
		array('email','email','邮箱不合法',1,'regex'),
		array('password','6,16','密码需是3-16位',1,'length'),
		array('confirm_password','password','两次密码不一致',1,'confirm')
		);
}