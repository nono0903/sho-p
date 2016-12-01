<?php 
namespace Home\Model;
use Think\Model;

class CommentModel extends Model{
	protected $_validate = array(
		array('email','email','请输入正确的邮箱',1,'regex'),
		array('content','1,9999','评论不能为空',1,'length')
		);
	public $_auto = array(
		array('pubtime','time',1,'function')
		);
}