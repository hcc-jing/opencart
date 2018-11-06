<?php
class ModelCatalogGoldType extends Model {
	public function addGoldType($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "gold_type SET gt_name = '" . $this->db->escape($data['name']) . "', gt_status = '" . (int)$data['status'] . "', gt_add_user = '" . $this->db->escape((string)$this->user->getUserName()) . "', gt_updated = NOW(), gt_added = NOW()");

		$gt_id = $this->db->getLastId();		

		return $gt_id;
	}

	public function editGoldType($id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "gold_type SET gt_name = '" . $this->db->escape($data['name']) . "', gt_status = '" . (int)$data['status'] . "', gt_update_user = '" . $this->db->escape((string)$this->user->getUserName()) . "', gt_updated = NOW() WHERE gt_id = '" . (int)$id . "'");
	}

	public function deleteGoldType($id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "gold_type WHERE gt_id = '" . (int)$id . "'");
	}

	public function getGoldType($gt_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "gold_type WHERE gt_id = " . (int)$gt_id);

		return $query->row;
	}

	public function getGoldTypes($data = array()) {
		$sql = "SELECT * FROM ". DB_PREFIX . "gold_type";

		$where_option = [];
		if (!empty($data['filter_name'])) {
			$where_option[] = "gt_name LIKE '%" . $this->db->escape((string)$data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] != '') {
			$where_option[] = "gt_status = '" . (int)$data['filter_status'] . "'";
		}

		if( !empty($where_option) )
		{
			$sql .= ' where ' . implode(' AND ', $where_option);
		}
		$sort_data = array(
			'name',
			'sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY gt_id";
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

	public function getTotalGoldTypes($data = array()) {
		$sql = "SELECT COUNT(DISTINCT gt_id) AS total FROM " . DB_PREFIX . "gold_type";

		$where_option = array();

		if (!empty($data['filter_name'])) {
			$where_option[] = "gt_name LIKE '%" . $this->db->escape((string)$data['filter_name']) . "%'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] != '') {
			$where_option[] = "gt_status = " . (int)$data['filter_status'];
		}

		if( !empty($where_option) )
		{
			$sql .= ' where ' . implode(' AND ', $where_option);
		}
		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}
