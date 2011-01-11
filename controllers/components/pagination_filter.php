<?php
/**
 * Componente para filtragem de resultados de paginação
 *
 * PHP version 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Advocacia(tm): Sistema de Gerenciamento de Atividades de Advocacia
 * Copyright 2009-2011, Radig Soluções em TI. (http://www.radig.com.br)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright	Copyright 2011, Radig Soluções em TI. (http://www.radig.com.br)
 * @link		http://www.radig.com.br
 * @package		advocacia
 * @subpackage	advocacia.controllers.components	
 * @since         Advocacia(tm) v 0.1
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

app::import('Sanitize');

class PaginationFilterComponent extends Object
{
	/**
	 * Configurações globais
	 * @var array $settings
	 */
	public $settings;
	
	/**
	 * @method initialize Initializing component
	 * @param object $controller
	 * @param array $settings To setup your application to filter pagination results, supply $settings array
	 * 1) To retrive results by passing a pattern string using "LIKE" condition
	 *  array(
	 * 		'type' => 'like',
	 * 		'field' => 'ModelName.field_name'
	 *	)
	 *
	 * 2) To apply 'or' type conditions, set the array $settings as follow:
	 * array(
	 * 		'type' => 'or'
	 * 		'fields' => array('Model1.field1', 'Model1.field2', ...)
	 * )
	 *  provide as much fields as the or condition needs
	 */
	
	public function initialize(&$controller, $settings = array()) {
		// saving the controller reference for later use
		$this->controller =& $controller;
		$this->settings = $settings;
	}
	
	/**
	 * Adiciona o filtro nas opções de paginação
	 * @return array opções de paginação
	 */
	
	public function setFilter()
	{
		$condition = array();
		
		if(isset($this->controller->params['url']['q']) || isset($this->controller->params['named']['q']))
		{
			$q = isset($this->controller->params['url']['q']) ? Sanitize::escape($this->controller->params['url']['q']) : Sanitize::espace($this->controller->params['named']['q']);
			
			/* switching condition types*/
			switch($this->settings['type'])
			{
				case 'like':
					$condition = array($this->settings['field'] . ' LIKE' => '%' . $q . '%');
				break;
				
				case 'or':
					foreach($this->settings['fields'] as $field)
						$condition['OR'][$field . ' LIKE'] = '%'.$q.'%';
				break;
			}
			
			$this->controller->paginate = array_merge($this->controller->paginate, array('conditions' => $condition));
			
			return $this->controller->paginate['conditions'];
		}
	}
	
	
}

?>