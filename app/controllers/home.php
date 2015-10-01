<?php
	class HomeController extends baseController
	{
		public function index()
		{
			$this->loadModel("page");
			$data = array();

			$data['news'] = $this->PageModel->getNews("", array('field' => 'news_id', 'type' => 'desc'), 4, 1);
			$data['lastestNews'] = $this->PageModel->getNews("", array('field' => 'news_id', 'type' => 'desc'), 1);
			$data['lastestNews']['news_content'] = substr(strip_tags($data['lastestNews']['news_content']), 0, 300);
			$data['randomNews'] = $this->PageModel->getNews("", array('field' => '', 'type' => 'RAND()'), 10);

			$data['slides'] = $this->PageModel->getSlides(10);
			$data['products'] = $this->PageModel->getProducts("", array('field' => 'product_id', 'type' => 'desc'), 8);
			$data['mainContentFile'] = "page/home";
			$this->loadView("page/template", $data);
		}
	}
