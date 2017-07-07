<?php

class NrwDashboardMetaBox {

	public $width;

	public $header;

	public $content;

	public function __construct($width, $header, $content) {
		$this->width = $width;
		$this->header = $header;
		$this->content = $content;
	}

}