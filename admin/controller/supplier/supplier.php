<?php
class ControllerSupplierSupplier extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('supplier/supplier');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('supplier/supplier');

		$this->getList();
	}

	public function add() {
		$this->load->language('supplier/supplier');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('supplier/supplier');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_supplier_supplier->addSupplier($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_add');

			$url = '';

			if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_short_name'])) {
				$url .= '&filter_short_name=' . urlencode(html_entity_decode($this->request->get['filter_short_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			$this->response->redirect($this->url->link('supplier/supplier', 'user_token=' . $this->session->data['user_token'] . $url));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('supplier/supplier');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('supplier/supplier');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_supplier_supplier->editSupplier($this->request->get['supplier_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success_edit');

			$url = '';

			if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_short_name'])) {
				$url .= '&filter_short_name=' . urlencode(html_entity_decode($this->request->get['filter_short_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			$this->response->redirect($this->url->link('supplier/supplier', 'user_token=' . $this->session->data['user_token'] . $url));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('supplier/supplier');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('supplier/supplier');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $supplier_id) {
				$this->model_supplier_supplier->deleteSupplier($supplier_id);
			}

			$this->session->data['success'] = $this->language->get('text_success_dele');

			$url = '';

			if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_short_name'])) {
				$url .= '&filter_short_name=' . urlencode(html_entity_decode($this->request->get['filter_short_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			$this->response->redirect($this->url->link('supplier/supplier', 'user_token=' . $this->session->data['user_token'] . $url));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_short_name'])) {
			$filter_short_name = $this->request->get['filter_short_name'];
		} else {
			$filter_short_name = '';
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['filter_add_time'])) {
			$filter_add_time = $this->request->get['filter_add_time'];
		} else {
			$filter_add_time = '';
		}

		$url = '';

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_short_name'])) {
			$url .= '&filter_short_name=' . urlencode(html_entity_decode($this->request->get['filter_short_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('supplier/supplier', 'user_token=' . $this->session->data['user_token'] . $url)
		);

		$data['add'] = $this->url->link('supplier/supplier/add', 'user_token=' . $this->session->data['user_token'] . $url);
		$data['delete'] = $this->url->link('supplier/supplier/delete', 'user_token=' . $this->session->data['user_token'] . $url);

		$data['suppliers'] = array();

		$filter_data = array(
			'filter_short_name'        => $filter_short_name,
			'filter_name'              => $filter_name,
			'filter_status'            => $filter_status,
			'sort'                     => $sort,
			'order'                    => $order,
			'filter_add_time'          => $filter_add_time,
			'start'                    => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                    => $this->config->get('config_limit_admin')
		);

		$supplier_total = $this->model_supplier_supplier->getTotalSuppliers($filter_data);

		$results = $this->model_supplier_supplier->getSuppliers($filter_data);

		foreach ($results as $result) {

			$store_data = array();

			$store_data[] = array(
				'name' => $this->config->get('config_name'),
				'href' => $this->url->link('supplier/supplier/login', 'user_token=' . $this->session->data['user_token'] . '&supplier_id=' . $result['supplier_id'] . '&store_id=0')
			);

			$data['suppliers'][] = array(
				'supplier_id'    => $result['supplier_id'],
				'name'           => $result['supplier_name'],
				'short_name'     => $result['supplier_short_name'],
				'status'         => ($result['supplier_status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'add_time'       => date($this->language->get('datetime_format'), strtotime($result['supplier_add_time'])),
				'edit'           => $this->url->link('supplier/supplier/edit', 'user_token=' . $this->session->data['user_token'] . '&supplier_id=' . $result['supplier_id'] . $url)
			);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';


		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_add_time'])) {
			$url .= '&filter_add_time=' . $this->request->get['filter_add_time'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_short_name'])) {
			$url .= '&filter_short_name=' . urlencode(html_entity_decode($this->request->get['filter_short_name'], ENT_QUOTES, 'UTF-8'));
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['short_name'] = $this->url->link('supplier/supplier', 'user_token=' . $this->session->data['user_token'] . '&sort=short_name' . $url);
		$data['name'] = $this->url->link('supplier/supplier', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url);
		$data['status'] = $this->url->link('supplier/supplier', 'user_token=' . $this->session->data['user_token'] . '&sort=status' . $url);
		$data['add_time'] = $this->url->link('supplier/supplier', 'user_token=' . $this->session->data['user_token'] . '&sort=add_time' . $url);

		$url = '';

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_add_time'])) {
			$url .= '&filter_add_time=' . $this->request->get['filter_add_time'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_short_name'])) {
			$url .= '&filter_short_name=' . urlencode(html_entity_decode($this->request->get['filter_short_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $supplier_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('supplier/supplier', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($supplier_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($supplier_total - $this->config->get('config_limit_admin'))) ? $supplier_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $supplier_total, ceil($supplier_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_short_name'] = $filter_short_name;
		$data['filter_status'] = $filter_status;
		$data['filter_add_time'] = $filter_add_time;
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		// d($data);exit;
		$this->response->setOutput($this->load->view('supplier/supplier_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['supplier_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

        $data['store_url'] = HTTP_CATALOG;
		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->get['supplier_id'])) {
			$data['supplier_id'] = (int)$this->request->get['supplier_id'];
		} else {
			$data['supplier_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['short_name'])) {
			$data['error_short_name'] = $this->error['short_name'];
		} else {
			$data['error_short_name'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_add_time'])) {
			$url .= '&filter_add_time=' . $this->request->get['filter_add_time'];
		}

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_short_name'])) {
			$url .= '&filter_short_name=' . urlencode(html_entity_decode($this->request->get['filter_short_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'],'')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('supplier/supplier', 'user_token=' . $this->session->data['user_token'] . $url)
		);

		if (!isset($this->request->get['supplier_id'])) {
			$data['action'] = $this->url->link('supplier/supplier/add', 'user_token=' . $this->session->data['user_token'] . $url);
		} else {
			$data['action'] = $this->url->link('supplier/supplier/edit', 'user_token=' . $this->session->data['user_token'] . '&supplier_id=' . $this->request->get['supplier_id'] . $url);
		}

		$data['cancel'] = $this->url->link('supplier/supplier', 'user_token=' . $this->session->data['user_token'] . $url);

		if (isset($this->request->get['supplier_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$supplier_info = $this->model_supplier_supplier->getSupplier($this->request->get['supplier_id']);
		}

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($supplier_info)) {
			$data['name'] = $supplier_info['supplier_name'];
		} else {
			$data['name'] = '';
		}

		if (isset($this->request->post['short_name'])) {
			$data['short_name'] = $this->request->post['short_name'];
		} elseif (!empty($supplier_info)) {
			$data['short_name'] = $supplier_info['supplier_short_name'];
		} else {
			$data['short_name'] = '';
		}

		$filter_data = array(
			'sort'  => 'supplier_id',
			'order' => 'ASC'
		);

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($supplier_info)) {
			$data['status'] = $supplier_info['supplier_status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['add_time'])) {
			$data['add_time'] = $this->request->post['add_time'];
		} elseif (!empty($supplier_info)) {
			$data['add_time'] = $supplier_info['supplier_add_time'];
		} else {
			$data['add_time'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('supplier/supplier_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'supplier/supplier')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 1) || (utf8_strlen(trim($this->request->post['name'])) > 32)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ((utf8_strlen($this->request->post['short_name']) < 1) || (utf8_strlen(trim($this->request->post['short_name'])) > 16)) {
			$this->error['short_name'] = $this->language->get('error_short_name');
		}

		$supplier_info = $this->model_supplier_supplier->getSupplierByShortName($this->request->post['short_name']);

		if (!isset($this->request->get['supplier_id'])) {
			if ($supplier_info) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		} else {
			if ($supplier_info && ($this->request->get['supplier_id'] != $supplier_info['supplier_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		// d($this->error);exit;
		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'supplier/supplier')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
