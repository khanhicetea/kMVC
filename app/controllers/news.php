<?php
	class NewsController extends baseController
	{
		public function read($news_id)
		{
			$this->loadModel("page");
			$data = array();


			$data['randomNews'] = $this->PageModel->getNews("", array('field' => '', 'type' => 'RAND()'), 10);
			$data['news'] = $this->PageModel->getNews( array('field' => 'news_id', 'value' => $news_id), "", 1);
			$data['mainContentFile'] = "page/news";
			$this->loadView("page/template", $data);
		}
	}
