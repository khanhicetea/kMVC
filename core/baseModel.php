<?php
	class baseModel
	{
		var $db = null;

		public function __construct($db_connnection)
		{
			$this->db = $db_connnection;
		}

		public function getWhereString($conditions)
		{
			$where = "";
			if (is_array($conditions))
			{
				if (isset($conditions['field']) && isset($conditions['value']))
				{
					$where .= "`" . $conditions['field'] . "` = " . setTypeSQL($conditions['value']);
				}
				else
				{
					for ($i = 0; $i < count($conditions); $i++)
					{
						$where .= ($i == 0 ? "" : " " . strtoupper($conditions[$i]['type']) . " ");
						$where .= "`" . $conditions[$i]['field'] . "` = " . setTypeSQL($conditions[$i]['value']);
					}
				}
			}
			else
			{
				$where .= $conditions;
			}
			$where = ($where == "" ? "" : "WHERE " . $where);			

			return $where;
		}

		public function getOrderString($orders)
		{
			$order = "";
			if (is_array($orders))
			{
				if (isset($orders['field']) && isset($orders['type']))
				{
					$order .= (($orders['field'] != "") ? "`" . $orders['field'] . "` " : "") . $orders['type'];
				}
				else
				{
					for ($i = 0; $i < count($orders); $i++)
					{
						$order .= (($orders[$i]['field'] != "") ? "`" . $orders[$i]['field'] . "` " : "") . $orders[$i]['type'] . ", ";
					}
					$order = substr($order, 0, -2);
				}
			}
			else
			{
				$order .= $orders;
			}
			$order = ($order == "" ? "" : "ORDER BY " . $order);

			return $order;
		}

		public function fetchOne($result)
		{
			$row = mysql_fetch_assoc($result);
			
			return $row;
		}

		public function fetchAll($result)
		{
			$data = array();
			
			while ($row = mysql_fetch_assoc($result))
			{
				$data[] = $row;
			}

			return $data;
		}

		public function querySQL($sql)
		{
			$result = mysql_query($sql);
			return $result;
		}

		public function getData($tableName, $conditions = "", $orders = "", $limit = null, $offset = null)
		{
			// Filter params
			$tableName = filterSQL($tableName);
			$conditions = filterSQL($conditions);
			$orders = filterSQL($orders);
			$limit = filterSQL($limit);
			$offset = filterSQL($offset);

			//Prepare SQL
			$whereString = $this->getWhereString($conditions);
			$orderString = $this->getOrderString($orders);
			$sql = "SELECT * FROM `$tableName` $whereString $orderString";
			$sql .= ($limit == null) ? "" : " LIMIT $limit";
			$sql .= ($offset == null) ? "" : " OFFSET $offset";
						 
			$result = mysql_query($sql);
			
			$data = array();
			
			while ($row = mysql_fetch_assoc($result))
			{
				$data[] = $row;
			}

			return ($limit == 1 && count($data) > 0) ? $data[0] : $data;
		}

		public function insertData($tableName, $data)
		{
			// Filter params
			$tableName = filterSQL($tableName);
			$data = filterSQL($data);

			// Prepare SQL
			$data = setTypeSQL($data);
			$fieldNames = array_keys($data);
			$fieldNames = implode("`, `", $fieldNames);
			$fieldValues = implode(", ", $data);

			$sql = "INSERT INTO `$tableName` (`" . $fieldNames . "`) VALUES (" . $fieldValues . ")";
			
			$result = mysql_query($sql);

			if (mysql_affected_rows() > 0)
				return true;
			return false;
		}

		public function updateData($tableName, $data, $conditions = "")
		{
			// Filter params
			$tableName = filterSQL($tableName);
			$data = filterSQL($data);
			$conditions = filterSQL($conditions);

			// Prepare SQL
			$data = setTypeSQL($data);
			$setString = "";
			foreach ($data as $field => $value) {
				$setString .= "`" . $field . "` = " . $value . ", ";
			}

			$setString = substr($setString, 0, -2);
			$whereString = $this->getWhereString($conditions);

			$sql = "UPDATE `$tableName` SET $setString $whereString";

			$result = mysql_query($sql);

			if (mysql_affected_rows() > 0)
				return true;
			return false;
		}

		public function deleteData($tableName, $conditions = "")
		{
			// Filter params
			$tableName = filterSQL($tableName);
			$conditions = filterSQL($conditions);

			// Prepare SQL
			$whereString = $this->getWhereString($conditions);
			$sql = "DELETE FROM `$tableName` $whereString";

			$result = mysql_query($sql);

			return true;
		}

		public function countRows($tableName, $conditions = "")
		{
			// Filter params
			$tableName = filterSQL($tableName);
			$conditions = filterSQL($conditions);

			// Prepare SQL
			$whereString = $this->getWhereString($conditions);
			$sql = "SELECT COUNT(*) FROM `$tableName` $whereString";
			$result = mysql_query($sql);

			$data = mysql_fetch_row($result);

			return $data[0];
		}

		public function searchData($tableName, $field = "", $search = "", $limit = null, $offset = null)
		{
			// Filter params
			$tableName = filterSQL($tableName);
			$field = filterSQL($field);
			$search = filterSQL($search);
			$limit = filterSQL($limit);
			$offset = filterSQL($offset);

			//Prepare SQL
			$sql = "SELECT * FROM `$tableName` WHERE `$field` LIKE '%" . $search . "%'";
			$sql .= ($limit == null) ? "" : " LIMIT $limit";
			$sql .= ($offset == null) ? "" : " OFFSET $offset";
			$result = mysql_query($sql);
			
			$data = array();
			
			while ($row = mysql_fetch_assoc($result))
			{
				$data[] = $row;
			}

			return ($limit == 1) ? $data[0] : $data;
		}

}