<?php
	class DashboardController extends baseController
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
			$data['mainContentFile'] = "admin/dashboard";
			$this->loadView("admin/template", $data);
		}
	}