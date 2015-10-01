<?php
	class ProductController extends baseController
	{
		public function index()
		{
			$this->loadModel("page");
			$data = array();

			$data['randomNews'] = $this->PageModel->getNews("", array('field' => '', 'type' => 'RAND()'), 10);
			$data['products'] = $this->PageModel->getProducts();
			$data['mainContentFile'] = "page/products";
			$this->loadView("page/template", $data);
		}
	}
