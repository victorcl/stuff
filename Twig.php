<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Twig
{
	private $CI;
	private $_twig;
	private $_template_dir;
	private $_cache_dir;
	/**
	 * Constructor
	 *
	 */
	function __construct($debug = false)
	{
		$this->CI =& get_instance();
		$this->CI->load->library('ion_auth');		
				
		$this->CI->config->load('twig');;
		

		Twig_Autoloader::register();
		$this->_template_dir = $this->CI->config->item('template_dir');
		$this->_cache_dir = $this->CI->config->item('cache_dir');
		$loader = new Twig_Loader_Filesystem($this->_template_dir);
		$this->_twig = new Twig_Environment($loader, array(
                'cache' => $this->_cache_dir,
                'debug' => $debug,
		));
		$this->ci_function_init();
        
	}


	public function render($template, $data = array()) 
	{
		$template = $this->_twig->loadTemplate($template);
		return $template->render($data);
	}
	public function display($template, $data = array()) 
	{
		$template = $this->_twig->loadTemplate($template);
		/* elapsed_time and memory_usage */
		$data['elapsed_time'] = $this->CI->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		$memory = (!function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2) . 'MB';
		$data['memory_usage'] = $memory;
		$template->display($data);
	}

	/**
	 * Initialize standard CI functions
	 * 
	 * @return void
	 */
	public function ci_function_init() 
	{
		$this->_twig->addFunction('base_url', new Twig_Function_Function('base_url'));
		$this->_twig->addFunction('site_url', new Twig_Function_Function('site_url'));
		$this->_twig->addFunction('current_url', new Twig_Function_Function('current_url'));
		// lang
		$this->_twig->addFunction('lang', new Twig_Function_Function('lang'));		

		$this->_twig->addFunction('get_time_intervals', new Twig_Function_Function('get_time_intervals'));		

		$this->_twig->addFunction('print_r', new Twig_Function_Function('print_r'));		

		$this->_twig->addGlobal('USER', $this->CI->ion_auth->user()->row() );	
		
		

		// form functions
		$this->_twig->addFunction('validation_errors', new Twig_Function_Function('validation_errors'));
		$this->_twig->addFunction('form_open', new Twig_Function_Function('form_open'));
		$this->_twig->addFunction('form_hidden', new Twig_Function_Function('form_hidden'));
		$this->_twig->addFunction('form_input', new Twig_Function_Function('form_input'));
		$this->_twig->addFunction('form_password', new Twig_Function_Function('form_password'));
		$this->_twig->addFunction('form_upload', new Twig_Function_Function('form_upload'));
		$this->_twig->addFunction('form_textarea', new Twig_Function_Function('form_textarea'));
		$this->_twig->addFunction('form_dropdown', new Twig_Function_Function('form_dropdown'));
		$this->_twig->addFunction('form_multiselect', new Twig_Function_Function('form_multiselect'));
		$this->_twig->addFunction('form_fieldset', new Twig_Function_Function('form_fieldset'));
		$this->_twig->addFunction('form_fieldset_close', new Twig_Function_Function('form_fieldset_close'));
		$this->_twig->addFunction('form_checkbox', new Twig_Function_Function('form_checkbox'));
		$this->_twig->addFunction('form_radio', new Twig_Function_Function('form_radio'));
		$this->_twig->addFunction('form_submit', new Twig_Function_Function('form_submit'));
		$this->_twig->addFunction('form_label', new Twig_Function_Function('form_label'));
		$this->_twig->addFunction('form_reset', new Twig_Function_Function('form_reset'));
		$this->_twig->addFunction('form_button', new Twig_Function_Function('form_button'));
		$this->_twig->addFunction('form_close', new Twig_Function_Function('form_close'));
		$this->_twig->addFunction('form_prep', new Twig_Function_Function('form_prep'));
		$this->_twig->addFunction('set_value', new Twig_Function_Function('set_value'));
		$this->_twig->addFunction('set_select', new Twig_Function_Function('set_select'));
		$this->_twig->addFunction('set_checkbox', new Twig_Function_Function('set_checkbox'));
		$this->_twig->addFunction('set_radio', new Twig_Function_Function('set_radio'));
		$this->_twig->addFunction('form_open_multipart', new Twig_Function_Function('form_open_multipart'));
	}
}