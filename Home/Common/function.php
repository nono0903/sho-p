<?php 

function cookie_chk(){
	if(md5(cookie('username').C('salt')) === cookie('code')){
		return 1;
	}else{
		return 0;
	}
}
function msg($str){
	require('./msg.html');
	
	// echo $str;

}


