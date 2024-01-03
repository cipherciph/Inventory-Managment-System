<?php 
function dashboard()
{
		return array( 
				array(	
					'title'=>'Home',
					'icon' => 'fa fa-dashboard',
					'url'  => site_url('dashboard'),
					'active' => FALSE,		
					), 
			);
}

function view_question()
{
	return array( 
				array(	
					'title'=>'Home',
					'icon' => 'fa fa-dashboard',
					'url'  => site_url('dashboard'),
					'active' => FALSE,		
					), 
				array(	
					'title'=>'View Question',
					'icon' => 'fa fa-eye',
					'url'  => site_url('dashboard'),
					'active' => TRUE,		
					), 
			);
}
