<?php
/**
 * @package		Extension for OpenCart: Multi Replacer
 * @author		Roman Sha
 * @copyright	2022 © All Rights Reserved
 * @license		Commercial
 * @link		https://opencartforum.com/files/developer/678008-sha/?utm_medium=profilecpage
 */
const VERSION_MULTIREPLACER = '0.0.1-alpha';
class ControllerExtensionModuleMultiReplacer extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/product');
		$this->load->language('extension/module/multireplacer');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('extension/module/multireplacer');

        $this->session->data['info'] = $this->language->get('text_gateway_index');

		$this->getForm();
	}

	public function create() {
        $this->load->language('catalog/product');
        $this->load->language('extension/module/multireplacer');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('extension/module/multireplacer');

        if (!isset($this->request->get['categories']))
            return;

        $categories_info = $this->model_extension_module_multireplacer->getCategoriesById(
            (string)$this->request->get['categories']
        );

        $this->getForm($categories_info);
	}

    public function add() {
    	var_dump($this->request->post);

        $this->load->language('catalog/product');
        $this->load->language('extension/module/multireplacer');

        $this->document->setTitle($this->language->get('heading_title'));

        // $this->load->model('catalog/product');
        $this->load->model('extension/module/multireplacer');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_extension_module_multireplacer->addProduct($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_model'])) {
                $url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_price'])) {
                $url .= '&filter_price=' . $this->request->get['filter_price'];
            }

            if (isset($this->request->get['filter_price_min'])) {
                $url .= '&filter_price_min=' . $this->request->get['filter_price_min'];
            }

            if (isset($this->request->get['filter_price_max'])) {
                $url .= '&filter_price_max=' . $this->request->get['filter_price_max'];
            }

            if (isset($this->request->get['filter_quantity'])) {
                $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
            }

            if (isset($this->request->get['filter_quantity_min'])) {
                $url .= '&filter_quantity_min=' . $this->request->get['filter_quantity_min'];
            }

            if (isset($this->request->get['filter_quantity_max'])) {
                $url .= '&filter_quantity_max=' . $this->request->get['filter_quantity_max'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }

            if (isset($this->request->get['filter_category'])) {
                $url .= '&filter_category=' . $this->request->get['filter_category'];
                if (isset($this->request->get['filter_sub_category'])) {
                    $url .= '&filter_sub_category';
                }
            }

            if (isset($this->request->get['filter_manufacturer_id'])) {
                $url .= '&filter_manufacturer_id=' . $this->request->get['filter_manufacturer_id'];
            }

            if (isset($this->request->get['filter_noindex'])) {
                $url .= '&filter_noindex=' . $this->request->get['filter_noindex'];
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

            $this->response->redirect($this->url->link('catalog/category', 'user_token=' . $this->session->data['user_token'] . $url, true));
        }

        $this->getForm();
    }

	protected function getForm($categories_id = []) {
        $data['base'] = HTTP_SERVER;

        // < type_options
        $data['type_options'] = [
        	['selected' => 'selected', 'value' => 'name', 'innerText' => $this->language->get('field_types_name')],
        	['value' => 'html_h1', 'innerText' => $this->language->get('field_types_html_h1')],
        	// ['value' => 'meta_title', 'innerText' => $this->language->get('field_types_meta_title')],
        	// ['value' => 'meta_description', 'innerText' => $this->language->get('field_types_meta_description')],
        	// ['value' => 'meta_keyword', 'innerText' => $this->language->get('field_types_meta_keyword')],
        	// ['value' => 'description', 'innerText' => $this->language->get('field_types_description')],
        	
        	// ['value' => 'tag', 'innerText' => $this->language->get('field_types_tag')]
        ];

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/multireplacer_form', $data));
	}

    public function loaddata() {
        $this->load->language('extension/module/multireplacer');

        $json = [];

        $json['tasks'] = [];

        // < type_options
        $json['fields'] = [
            ['value' => 'name', 'text' => $this->language->get('field_types_name')],
            ['value' => 'html_h1', 'text' => $this->language->get('field_types_html_h1')],
            ['value' => 'meta_title', 'text' => $this->language->get('field_types_meta_title')],
            ['value' => 'meta_description', 'text' => $this->language->get('field_types_meta_description')],
            ['value' => 'meta_keyword', 'text' => $this->language->get('field_types_meta_keyword')],
            ['value' => 'description', 'text' => $this->language->get('field_types_description')],

            // ['value' => 'tag', 'text' => $this->language->get('field_types_tag')]
        ];

        $this->load->model('localisation/language');

        $json['languages'] = $this->model_localisation_language->getLanguages();

        $json['products'] = '';

        if (isset($this->session->data['multi_edit_products'])) {
            $json['products'] = $this->session->data['multi_edit_products'];
        }

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($json));
    }

    public function postData() {
        $data = json_decode(html_entity_decode(file_get_contents('php://input')), true);

		$this->load->model('extension/module/multireplacer');

        $replace = $this->model_extension_module_multireplacer->replace($data);

        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput(json_encode($replace));
    }

	public function install () {
		// настройки глобально на магазин
		// что-бы потом подхватывать в multiedit и других
		$this->load->model('setting/setting');

		$this->model_setting_setting->editSetting(
			'multi', 
			[
				'multi_extend_replaser' => [
					'name'  => 'multireplacer',
					'title' => 'Multi: Search and Replace',
					'version' => VERSION_MULTIREPLACER,
					'path' => 'extension/module/multireplacer',
					'classButton' => '111',
					'classChild' => 'fa-cut'
				]
			], 
			0 // TODO store_id
		);
	}

	public function uninstal () {
		$this->load->model('setting/setting');

		$this->model_setting_setting->deleteSetting();
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'extension/module/multireplacer')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['product_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 0) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}

						if ((utf8_strlen($value['meta_h1']) < 0) || (utf8_strlen($value['meta_h1']) > 255)) {
				$this->error['meta_h1'][$language_id] = $this->language->get('error_meta_h1');
			}
		}

		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
			$this->error['model'] = $this->language->get('error_model');
		}

		if ($this->request->post['product_seo_url']) {
			$this->load->model('design/seo_url');

			foreach ($this->request->post['product_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (!empty($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
						}

						$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);

						foreach ($seo_urls as $seo_url) {
							if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['product_id']) || (($seo_url['query'] != 'product_id=' . $this->request->get['product_id'])))) {
								$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');

								break;
							}
						}
					}
				}
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}
}
