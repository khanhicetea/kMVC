<?php
	class ContactController extends baseController {
		public function index()
		{
			$this->loadModel("page");
			$data = array();

			$data['randomNews'] = $this->PageModel->getNews("", array('field' => '', 'type' => 'RAND()'), 10);
			$data['mainContentFile'] = "page/contact";
			$this->loadView("page/template", $data);
		}
	}
