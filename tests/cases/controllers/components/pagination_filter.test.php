<?php
App::import('Component', 'RSearch.PaginationFilter');

Mock::generate('PaginationFilterComponent', 'TestMockPaginationFilterComponent');

/**
* TestAuthComponent class
*
* @package       cake
* @subpackage    cake.tests.cases.libs.controller.components
*/
class TestPaginationFilterComponent extends PaginationFilterComponent {

/**
 * testStop property
 *
 * @var bool false
 * @access public
 */
	var $testStop = false;

/**
 * Sets default login state
 *
 * @var bool true
 * @access protected
 */
	var $_loggedIn = true;

/**
 * stop method
 *
 * @access public
 * @return void
 */
	function _stop() {
		$this->testStop = true;
	}
}

/**
* Test case
*/
class PaginationFilterTestCase extends CakeTestCase {
	/**
	 * fixtures.
	 *
	 * @var array
	 **/
	public $fixtures = array('core.aco_two');
	
	/**
	 * Start test callback
	 *
	 * @access public
	 * @return void
	 **/
	public function startTest()
	{
		Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
		
		$this->Controller = new Controller();
		$this->Controller->params = Router::parse('/');
		$this->Controller->params['url']['url'] = '/';
		$this->Controller->uses = array();
		$this->Controller->components = array('RSearch.PaginationFilter');
		$this->Controller->constructClasses();
		$this->Controller->Component->init($this->Controller);
		$this->Controller->Component->initialize($this->Controller);
		

		$this->_server = $_SERVER;
		$this->_paths = array();
		$this->_paths['plugins'] = App::path('plugins');
		$this->_paths['views'] = App::path('views');
		$this->_paths['vendors'] = App::path('vendors');
		$this->_paths['controllers'] = App::path('controllers');
		Configure::write('Cache.disable', false);
	}
	
	/**
	 * endTest
	 *
	 * @return void
	 **/
	public function endTest()
	{
		$_SERVER = $this->_server;
		App::build(array(
			'plugins' => $this->_paths['plugins'],
			'views' => $this->_paths['views'],
			'controllers' => $this->_paths['controllers'],
			'vendors' => $this->_paths['vendors']
		), true);
		Configure::write('Cache.disable', true);

		unset($this->Controller);
	}
	
	/**
	 * test Configurações padrão do componente
	 *
	 * @return void
	 **/
	public function testConfigurationsDefault()
	{
		$expected = array(
			'autoFilter' => false,
			'method' => 'post', 
			'inputModel' => 'Filter',
			'inputName' => 'q',
			'comparassion' => 'or', 
			'queryFields' => array()
		);
		
		$real = $this->Controller->PaginationFilter->settings;
		
		$this->assertEqual($expected, $real, 'msg');
	}
}