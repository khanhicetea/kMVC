<?php
	class ProductController extends baseController
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

			$data['products'] = $this->AdminModel->getProducts("", array('field' => 'product_id', 'type' => 'desc'));
			$data['mainContentFile'] = "admin/product/view";
			$this->loadView("admin/template", $data);
		}

		public function add()
		{
			$this->loadModel("admin");
			$data = array();

			if ($this->input("action") == "add")
			{
				$record = array(
					'product_name' => $this->input("product_name"),
					'product_info' => $this->input("product_info")
				);

				// Upload file
				$this->loadLib("upload");
				$config = array(
					'fileField' => 'product_img',
					'destDir' => 'uploads',
					'maxFileSize' => 1048576,
					'extAllowed' => array('png', 'jpg', 'jpeg', 'gif'),
					'randomName' => true
				);
				
				$this->UploadLib->setConfig($config);
				$product_img = $this->UploadLib->uploadFile();
				if ($product_img !== false)
				{
					$record['product_img'] = $product_img;
				}

				/////////////////////////////////////////////////////////////////

				if ($this->AdminModel->addProduct($record))
					redirect("admin/product/index");
				$data['error'] = "Error !";
			}

			$data['action'] = "add";
			$data['mainContentFile'] = "admin/product/form";

			$this->loadView("admin/template", $data);
		}

		public function update($product_id)
		{
			$this->loadModel("admin");
			$data = array();

			if ($this->input("action") == "update")
			{
				$record = array(
					'product_name' => $this->input("product_name"),
					'product_info' => $this->input("product_info")
				);
				
				// Upload file
				$this->loadLib("upload");
				$config = array(
					'fileField' => 'product_img',
					'destDir' => 'uploads',
					'maxFileSize' => 1048576,
					'extAllowed' => array('png', 'jpg', 'jpeg', 'gif'),
					'randomName' => true
				);
				$this->UploadLib->setConfig($config);
				$product_img = $this->UploadLib->uploadFile();
				if ($product_img !== false)
				{
					$record['product_img'] = $product_img;
				}

				if ($this->AdminModel->updateProduct($record, $product_id))
						redirect("admin/product/index");
						
				$data['error'] = "Error !";
			}

			$data['product'] = $this->AdminModel->getProductById($product_id);
			$data['action'] = "update";
			$data['mainContentFile'] = "admin/product/form";

			$this->loadView("admin/template", $data);
		}

		public function delete($product_id, $confirm = "no")
		{
			$this->loadModel("admin");
			$data = array();

			if ($confirm == "yes")
			{
				if ($this->AdminModel->deleteProduct($product_id))
					redirect("admin/product/index");
			}

			$data['product'] = $this->AdminModel->getProductById($product_id);

			$data['mainContentFile'] = "admin/product/delete";

			$this->loadView("admin/template", $data);
		}
	}