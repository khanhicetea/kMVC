<?php
	class AuthController extends baseController
	{
		public function index()
		{
			if ($this->getUserdata("admin_logged") != "logged")
				$this->login();
			else
				redirect("admin/dashboard");
		}

		public function login()
		{
			if ($this->input("action") == "login")
			{
				$this->loadModel("admin");

				$username = $this->input("username");
				$password = $this->input("password");

				$userInfo = $this->AdminModel->getUserByUsername($username);

				if ((isset($userInfo['user_password'])) && (md5($password) == $userInfo['user_password']))
				{
					$this->setUserdata("admin_logged", "logged");
					unset($userInfo['user_password']);
					$this->setUserdata("userInfo", $userInfo);

					redirect("admin/dashboard");
				}
			}

			$this->loadView("admin/login");
		}

		public function logout()
		{
			$this->removeUserdata();
			$this->login();
		}
	}