<?php
	class ProfileController extends baseController
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
			if ($this->input("action") == "changepassword")
			{
				$currentPass = $this->input("current_password");
				$newPass = $this->input("new_password");
				$confirmPass = $this->input("confirm_password");

				if ($newPass === $confirmPass)
				{
					$this->loadModel("admin");
					$userInfo = $this->getUserdata("userInfo");

					$user = $this->AdminModel->getUserByUsername($userInfo['user_name']);

					if ($user['user_password'] == md5($currentPass))
					{
						if ($this->AdminModel->updateUser(array('user_password' => md5($newPass)), $user['user_id']))
						{
							redirect("admin/auth/logout");	
						}
						else
						{
							$data['error'] = "Error ! Try again !";
						}
					}
					else
					{
						$data['error'] = "Current Password is wrong !";
					}
				}
				else
				{
					$data['error'] = "Confirm password is wrong !";
				}
			}

			$data['mainContentFile'] = "admin/profile/change";

			$this->loadView("admin/template", $data);
		}
	}