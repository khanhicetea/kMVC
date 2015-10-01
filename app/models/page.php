<?php
	class PageModel extends baseModel
	{
		public function getSlides( $limits = null )
		{
			$slides = $this->getData("slides", "", "", $limits);
			return $slides;
		}

		public function getProducts($conditions = "", $orders = "", $limits = null, $offset = null)
		{
			$products = $this->getData("products", $conditions, $orders, $limits, $offset);
			return $products;
		}

		public function getNews($conditions = "", $orders = "", $limits = null, $offset = null)
		{
			$news = $this->getData("news", $conditions, $orders, $limits, $offset);
			return $news;
		}
	}
