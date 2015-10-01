<?php
	class NewsController extends baseController
	{
		public function __construct()
		{
			if ($this->getUserdata("admin_logged") != "logged")
			{
				redirect("admin/auth");
				return;
			}
		}

		public function index()
		{
			$this->loadModel("admin");

			$data['news'] = $this->AdminModel->getNews("", array('field' => 'news_id', 'type' => 'desc'));
			$data['mainContentFile'] = "admin/news/view";
			$this->loadView("admin/template", $data);
		}

		public function add()
		{
			$this->loadModel("admin");
			$data = array();

			if ($this->input("action") == "add")
			{
				$record = array(
					'news_title' => $this->input("news_title"),
					'news_content' => $this->input("news_content")
				);

				if ($record['news_title'] != "")
				{
					if ($this->AdminModel->addNews($record))
						redirect("admin/news/index");
				}
				$data['error'] = "Error !";
			}

			$data['action'] = "add";
			$data['mainContentFile'] = "admin/news/form";

			$this->loadView("admin/template", $data);
		}

		public function update($news_id)
		{
			$this->loadModel("admin");
			$data = array();

			if ($this->input("action") == "update")
			{
				$record = array(
					'news_title' => $this->input("news_title"),
					'news_content' => $this->input("news_content")
				);
				
				if ($record['news_title'] != "")
				{
					if ($this->AdminModel->updateNews($record, $news_id))
						redirect("admin/news/index");
				}
				$data['error'] = "Error !";
			}

			$data['news'] = $this->AdminModel->getNewsById($news_id);
			$data['action'] = "update";
			$data['mainContentFile'] = "admin/news/form";

			$this->loadView("admin/template", $data);
		}

		public function delete($news_id, $confirm = "no")
		{
			$this->loadModel("admin");
			$data = array();

			if ($confirm == "yes")
			{
				if ($this->AdminModel->deleteNews($news_id))
					redirect("admin/news/index");
			}

			$data['news'] = $this->AdminModel->getNewsById($news_id);

			$data['mainContentFile'] = "admin/news/delete";

			$this->loadView("admin/template", $data);
		}
	}