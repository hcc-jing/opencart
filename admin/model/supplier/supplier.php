<?php
class ModelSupplierSupplier extends Model {
	public function addSupplier($data) {

		$this->db->query("INSERT INTO " . DB_PREFIX . "supplier SET supplier_name = '" . $this->db->escape((string)$data['name']) . "', supplier_short_name = '" . $this->db->escape((string)$data['short_name']) . "', supplier_add_user = '" . $this->db->escape((string)$this->user->getUserName()) . "', supplier_status = '" . (int)$data['status'] . "', supplier_add_time = NOW()");

		$Supplier_id = $this->db->getLastId();

		return $Supplier_id;
	}

	public function editSupplier($Supplier_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "Supplier SET supplier_name = '" . $this->db->escape((string)$data['name']) . "', supplier_short_name = '" . $this->db->escape((string)$data['short_name']) . "', supplier_status = '" . (int)$data['status'] . "', supplier_update_user = '" . $this->db->escape((string)$this->user->getUserName()) . "', supplier_update_time = NOW() WHERE Supplier_id = '" . (int)$Supplier_id . "'");
	}

	public function deleteSupplier($Supplier_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "Supplier WHERE Supplier_id = '" . (int)$Supplier_id . "'");
	}

	public function getSupplier($Supplier_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "Supplier WHERE supplier_id = '" . (int)$Supplier_id . "'");

		return $query->row;
	}

	public function getSupplierByShortName($short_name) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "Supplier WHERE supplier_short_name = '" . $this->db->escape(utf8_strtolower($short_name)) . "'");

		return $query->row;
	}
	
	public function getSuppliers($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "supplier ";
		$where_option = [];

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$where_option[] = "supplier_status = " . (int)$data['filter_status'];
		}

		if (!empty($data['filter_add_time'])) {
			$implode[] = "DATE(supplier_add_time) = DATE('" . $this->db->escape((string)$data['filter_add_time']) . "')";
		}

		if (!empty($data['filter_name'])) {
			$where_option[] = "supplier_name LIKE '%" . $this->db->escape((string)$data['filter_name']) . "%'";
		}

		if (!empty($data['filter_short_name'])) {
			$where_option[] = "supplier_short_name LIKE '%" . $this->db->escape((string)$data['filter_short_name']) . "%'";
		}

		if ($where_option) {
			$sql .= " WHERE " . implode(" AND ", $where_option);
		}

		$sort_data = array(
			'name',
			'short_name',
			'sort_status',
			'sort_add_time'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY supplier_" . $data['sort'];
		} else {
			$sql .= " ORDER BY supplier_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}	

	public function getTotalSuppliers($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "supplier";

		$implode = array();

		if (isset($data['filter_status']) && $data['filter_status'] !== '') {
			$implode[] = "supplier_status = " . (int)$data['filter_status'];
		}

		if (!empty($data['filter_name'])) {
			$implode[] = "supplier_name LIKE '%" . $this->db->escape((string)$data['filter_name']) . "%'";
		}

		if (!empty($data['filter_short_name'])) {
			$implode[] = "supplier_short_name LIKE '%" . $this->db->escape((string)$data['filter_short_name']) . "%'";
		}

		if (!empty($data['filter_add_time'])) {
			$implode[] = "DATE(supplier_add_time) = DATE('" . $this->db->escape((string)$data['filter_add_time']) . "')";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}