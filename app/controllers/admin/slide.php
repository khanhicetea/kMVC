<?php
	class SlideController extends baseController
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

			$data['slides'] = $this->AdminModel->getSlides("", array('field' => 'slide_id', 'type' => 'desc'));
			$data['mainContentFile'] = "admin/slide/view";
			$this->loadView("admin/template", $data);
		}

		public function add()
		{
			$this->loadModel("admin");
			$data = array();

			if ($this->input("action") == "add")
			{
				$record = array();

				// Upload file
				$this->loadLib("upload");
				$config = array(
					'fileField' => 'slide_img',
					'destDir' => 'uploads',
					'maxFileSize' => 1048576,
					'extAllowed' => array('png', 'jpg', 'jpeg', 'gif'),
					'randomName' => true
				);
				$this->UploadLib->setConfig($config);
				$slide_img = $this->UploadLib->uploadFile();
				if ($slide_img !== false)
				{
					$record['slide_img'] = $slide_img;
				}

				/////////////////////////////////////////////////////////////////

				if ($record['slide_img'] != "")
				{
					if ($this->AdminModel->addSlide($record))
						redirect("admin/slide/index");
				}
				$data['error'] = "Error !";
			}

			$data['action'] = "add";
			$data['mainContentFile'] = "admin/slide/form";

			$this->loadView("admin/template", $data);
		}

		public function update($slide_id)
		{
			$this->loadModel("admin");
			$data = array();

			if ($this->input("action") == "update")
			{
				$record = array();
				// Upload file
				$this->loadLib("upload");
				$config = array(
					'fileField' => 'slide_img',
					'destDir' => 'uploads',
					'maxFileSize' => 1048576,
					'extAllowed' => array('png', 'jpg', 'jpeg', 'gif'),
					'randomName' => true
				);
				$this->UploadLib->setConfig($config);
				$slide_img = $this->UploadLib->uploadFile();
				if ($slide_img !== false)
				{
					$record['slide_img'] = $slide_img;
				}

				if ($record['slide_img'] != "")
				{
					if ($this->AdminModel->updateSlide($record, $slide_id))
						redirect("admin/slide/index");
				}
				$data['error'] = "Error !";
			}

			$data['slide'] = $this->AdminModel->getSlideById($slide_id);
			$data['action'] = "update";
			$data['mainContentFile'] = "admin/slide/form";

			$this->loadView("admin/template", $data);
		}

		public function delete($slide_id, $confirm = "no")
		{
			$this->loadModel("admin");
			$data = array();

			if ($confirm == "yes")
			{
				if ($this->AdminModel->deleteSlide($slide_id))
					redirect("admin/slide/index");
			}

			$data['slide'] = $this->AdminModel->getSlideById($slide_id);

			$data['mainContentFile'] = "admin/slide/delete";

			$this->loadView("admin/template", $data);
		}
	}