<?php

class NrwDashboardMetaBox {

	public $width;

	public $header;

	public $content;

	public $position;

	public $left;

	public $top;

	public function __construct($width, $header, $content, $position, $left, $top) {
		$this->width = $width;
		$this->header = $header;
		$this->position = $position;
		$this->content = $content;
		$this->left = $left;
		$this->top = $top;
	}

}