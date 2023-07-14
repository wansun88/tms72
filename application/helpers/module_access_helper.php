<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('module_access'))
{   
	function module_access()
	{
		$CI =& get_instance();
		$CI->load->model('user_model');
		$level = $CI->session->userdata('level');
		$menu=$CI->router->fetch_class();
		$menu=$menu.'/';

		$q = $CI
	            ->db
	            ->select('menu_id')
	            ->where('menu_uri', $menu)
	            ->where("menu_allowed LIKE '%+".$level."+%'")
	            ->get('tb_sys_menu');
	    // echo $CI->db->last_query();
	    // die();
		if($q->num_rows()>0){
                    if($CI->config->item('system_maintenance') == TRUE) 
                    {
	    		redirect($menu);
                    }
                }
                else
                {
                    $whitelist = explode(',', $CI->config->item('proxy_ips')); 
                    $ip_curl = $CI->input->post('ip');
                    $ip = $CI->input->post('ip');
                    if(!in_array($ip, $whitelist) || !in_array($ip_curl, $whitelist))
                    {
                        redirect('home/index');
                    }                
                }
	}
}