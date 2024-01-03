<?php namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
	
	function authenticate($email,$password)
	{
		$db = db_connect();
		$session = session();
		$user = $db->table('admin')->where('emailid', $email)->get()->getRow();

		if($user)
		{
			$verify_hash=$this->hash($password,$user->password);
			if($verify_hash)
			{

				$sess = array(
					'emailid' => $user->emailid,
					'name' => $user->name,
					'mobile_number' => $user->mobile_number,
					'admin_id' => $user->admin_id,
					'isLoggedIn' => TRUE,
					'role_id'=>$user->role_id,
                    
				);
				
				$session->set( $sess );
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
		
	}
		function userlogin($email,$password)
	{
		$db = db_connect();
		$user = $db->table('user')->where('email_id', $email)->get()->getRow();

		if($user)
		{
			$verify_hash=$this->hash($password,$user->password);
			if($verify_hash)
			{

				$sess = array(
					'emailid' => $user->email_id,
					'name' => $user->name,
					'mobile_number' => $user->mobile_number,
					'user_id' => $user->user_id,
					'role' => "user",
					'isLoggedIn' => TRUE,
				);
				
				$this->session->set_userdata( $sess );
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
		
	}


	function updateRememberMeToken($token)
	{
		$db = db_connect();
		$db->table("admin")->where('admin_id', $this->session->admin_id);
		if($db->table('admin')->set(array("remember_me"=>$token)))
		{
			return TRUE;
		}
		return FALSE;
	}
	function hash($password,$hash)
	{
		return password_verify($password,$hash);
	}
	function getUserFromCookie($token)
	{
		$db = db_connect();
		return $db->table('admin')->where('remember_me', $token)->get()->getRow();
	}
}