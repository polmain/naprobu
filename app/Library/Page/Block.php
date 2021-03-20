<?php
/**
 * Created by PhpStorm.
 * User: Дмитрий
 * Date: 13.06.2019
 * Time: 10:31
 */

namespace App\Library\Page;


class Block
{
	protected $blocks;

	/**
	 * @param \App\Model\Page\Block $blocks
	 */
	public static function setBlocks($blocks){
		$instance = static::getInstance();
		$instance->blocks = $blocks;
	}

	/**
	 * @param string $name
	 * @return string
	 */
	public static function getBlockContent($name){
		$instance = static::getInstance();
		return $instance->blocks->where('name', $name)->first()->content;
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