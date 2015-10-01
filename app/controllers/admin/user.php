<?php
	class UserController extends baseController
	{
		public function __construct()
		{
			if ($this->getUserdata("admin_logged") != "logged")
			{
				redirect("admin/auth");
				return;
			}
			$userInfo = $this->getUserdata("userInfo");
			if ($userInfo['user_permission'] != "admin")
			{
				redirect("admin/dashboard");
				return;
			}

		}

		public function index()
		{
			$this->loadModel("admin");

			$data['users'] = $this->AdminModel->getUsers();

			$data['mainContentFile'] = "admin/user/view";
			$this->loadView("admin/template", $data);
		}

		public function add()
		{
			$this->loadModel("admin");
			$data = array();

			if ($this->input("action") == "add")
			{
				$record = array(
					'user_name' => $this->input("user_name"),
					'user_password' => $this->input("user_password"),
					'user_permission' => $this->input("user_permission")
				);

				if ($record['user_name'] != "" && $record['user_password'] != "")
				{
					$record['user_password'] = md5($record['user_password']);
					if ($this->AdminModel->addUser($record))
						redirect("admin/user/index");
				}
				$data['error'] = "Error !";
			}

			$data['action'] = "add";
			$data['mainContentFile'] = "admin/user/form";

			$this->loadView("admin/template", $data);
		}

		public function update($user_id)
		{
			$this->loadModel("admin");
			$data = array();

			if ($this->input("action") == "update")
			{
				$record = array(
					'user_name' => $this->input("user_name"),
					'user_password' => $this->input("user_password"),
					'user_permission' => $this->input("user_permission")
				);

				if ($record['user_name'] != "" && $record['user_password'] != "")
				{
					$record['user_password'] = md5($record['user_password']);
					if ($this->AdminModel->updateUser($record, $user_id))
						redirect("admin/user/index");
				}
				$data['error'] = "Error !";
			}

			$data['user'] = $this->AdminModel->getUserByUserId($user_id);
			$data['action'] = "update";
			$data['mainContentFile'] = "admin/user/form";

			$this->loadView("admin/template", $data);
		}

		public function delete($user_id, $confirm = "no")
		{
			$this->loadModel("admin");
			$data = array();

			if ($confirm == "yes")
			{
				if ($this->AdminModel->deleteUser($user_id))
					redirect("admin/user/index");
			}

			$data['user'] = $this->AdminModel->getUserByUserId($user_id);

			$data['mainContentFile'] = "admin/user/delete";

			$this->loadView("admin/template", $data);
		}
	}