<?php

use CodeIgniter\Config\Services;

if ( ! function_exists('css_url'))
{
	function css_url()
	{
		return base_url().'/css/';
	}
}

if ( ! function_exists('js_url'))
{
	function js_url()
	{
		return base_url().'/js/';
	}
}

if ( ! function_exists('img_url'))
{
	function img_url()
	{
		return base_url().'/images/';
	}
}

if ( ! function_exists('plugin_url'))
{
	function plugin_url()
	{
		return base_url().'/plugins/';
	}
}

if ( ! function_exists('site_info'))
{
	function site_info()
	{
		$site = new stdClass();
        $site->company_name = "Inventory Management System";
        $site->contact_name = "7353448991";
        $site->contact_email = "admin@inventory.com";
        $site->address = "Mysore";
        $site->site_name = "Inventory Management System";
        $site->short_name = "IMS";
        return $site;
	}
}