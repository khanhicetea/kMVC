<?php
	class AdminModel extends baseModel
	{
		//////////////////////////////////////////////////////////////////
		///////////////////////// Users //////////////////////////////////
		//////////////////////////////////////////////////////////////////

		public function getUserByUsername($username)
		{
			$userInfo = $this->getData("users", array('field' => 'user_name', 'value' => $username), "", 1);
			return $userInfo;
		}

		public function getUserByUserId($user_id)
		{
			$userInfo = $this->getData("users", array('field' => 'user_id', 'value' => $user_id), "", 1);
			return $userInfo;
		}

		public function updateUser($data, $user_id)
		{
			return $this->updateData("users", $data, array('field' => 'user_id', 'value' => $user_id));
		}

		public function getUsers($conditions = "")
		{
			return $this->getData("users", $conditions);
		}

		public function addUser($data)
		{
			return $this->insertData("users", $data);
		}

		public function deleteUser($user_id)
		{
			return $this->deleteData("users", array('field' => 'user_id', 'value' => $user_id));
		}

		//////////////////////////////////////////////////////////////////
		///////////////////////// Slides /////////////////////////////////
		//////////////////////////////////////////////////////////////////
		public function getSlideById($slideId)
		{
			$slide = $this->getData("slides", array('field' => 'slide_id', 'value' => $slideId), "" , 1);
			return $slide;
		}

		public function getSlides($conditions = "", $orders = "")
		{
			$slides = $this->getData("slides", $conditions, $orders);
			return $slides;
		}

		public function addSlide($data)
		{
			return $this->insertData("slides", $data);
		}

		public function updateSlide($data, $slideId)
		{
			return $this->updateData("slides", $data, array('field' => 'slide_id', 'value' => $slideId));
		}

		public function deleteSlide($slideId)
		{
			return $this->deleteData("slides", array('field' => 'slide_id', 'value' => $slideId));
		}
		
		//////////////////////////////////////////////////////////////////
		///////////////////////// Products /////////////////////////////////
		//////////////////////////////////////////////////////////////////
		public function getProductById($productId)
		{
			$product = $this->getData("products", array('field' => 'product_id', 'value' => $productId), "" , 1);
			return $product;
		}

		public function getProducts($conditions = "", $orders = "")
		{
			$products = $this->getData("products", $conditions, $orders);
			return $products;
		}

		public function addProduct($data)
		{
			return $this->insertData("products", $data);
		}

		public function updateProduct($data, $productId)
		{
			return $this->updateData("products", $data, array('field' => 'product_id', 'value' => $productId));
		}

		public function deleteProduct($productId)
		{
			return $this->deleteData("products", array('field' => 'product_id', 'value' => $productId));
		}
		
		//////////////////////////////////////////////////////////////////
		///////////////////////// News /////////////////////////////////
		//////////////////////////////////////////////////////////////////
		public function getNewsById($newsId)
		{
			$news = $this->getData("news", array('field' => 'news_id', 'value' => $newsId), "" , 1);
			return $news;
		}

		public function getNews($conditions = "", $orders = "")
		{
			$news = $this->getData("news", $conditions, $orders);
			return $news;
		}

		public function addNews($data)
		{
			return $this->insertData("news", $data);
		}

		public function updateNews($data, $newsId)
		{
			return $this->updateData("news", $data, array('field' => 'news_id', 'value' => $newsId));
		}

		public function deleteNews($newsId)
		{
			return $this->deleteData("news", array('field' => 'news_id', 'value' => $newsId));
		}
	}