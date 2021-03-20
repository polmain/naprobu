<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 11.03.2019
 * Time: 10:41
 */

namespace App\Library\Admin;


class AdminPageData
{
	protected $pageName = "";
	protected $breadcrumbs = [];

	public static function setPageName($name){
		$instance = static::getInstance();
		$instance->pageName = $name;
	}
	public static function getPageName(){
		$instance = static::getInstance();
		return $instance->pageName;
	}

	public static function addBreadcrumbLevel($name,$link = null){
		$instance = static::getInstance();
		$level = [];
		$level["name"] = $name;
		$level["link"] = $link;
		$instance->breadcrumbs[] = $level;
	}

	public static function renderBreadcrumbs(){
		$instance = static::getInstance();
		$currentLink = '/admin/';
		$render = '<ol class="breadcrumb">';
		$render .= '<li><a href="'.$currentLink.'"><i class="fa fa-dashboard"></i>Главная</a></li>';
		foreach ($instance->breadcrumbs as $breadcrumb){
			if($breadcrumb["link"]){
				$currentLink .= $breadcrumb["link"].'/';
				$render .= '<li><a href="'.$currentLink.'">'.$breadcrumb['name'].'</a></li>';
			}else{
				$render .= '<li class="active">'.$breadcrumb['name'].'</li>';
			}
		}
		$render .= '</ol>';
		return $render;
	}

	private static $instance;
	public static function getInstance()
	{
		if (null === static::$instance) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	private function __construct(){}
	private function __clone(){}
	private function __wakeup(){}
}