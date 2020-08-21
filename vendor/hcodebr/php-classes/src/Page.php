<?php

namespace Hcode;

use Rain\Tpl;
use \Hcode\Model\User;

class Page {

	private $tpl;
	private $defaults = [
		"header"=>true,
		"footer"=>true,
		"data"=>[]
	];
	private $options = [];

	public function __construct($opts = array(), $tpl_dir = "/views/"){

		$this->tpl_dir = $tpl_dir;

		$this->options = array_merge($this->defaults, $opts);

		$this->config = array(
			"tpl_dir"       => $_SERVER['DOCUMENT_ROOT'].$tpl_dir,
			"cache_dir"     => $_SERVER['DOCUMENT_ROOT']."/views-cache/",
			"debug"         => true
		);

		Tpl::configure( $this->config );

		$this->tpl = new Tpl;

		if (isset($_SESSION[User::SESSION])) $this->tpl->assign("user", $_SESSION[User::SESSION]);

		$pageName = explode("/", $_SERVER['REQUEST_URI']);
		$pageName = end($pageName);
		$this->tpl->assign("pageName", $pageName);

		$this->setData($this->options['data']);

		if ($this->options["header"] === true) $this->tpl->draw("header");

	}

	private function setData($data = array())
	{

		foreach ($data as $key => $value) {			
			$this->tpl->assign($key, $value);
		}

	}

	public function setTpl($name, $data = array(), $returnHtml = false)
	{

		$this->setData($data);

		return $this->tpl->draw($name, $returnHtml);

	}

	public function __destruct(){

		if ($this->options["footer"] === true) $this->tpl->draw("footer");

	}

}

?>