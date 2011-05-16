<?php
/** 
 * Behavior to add capacity of complex search schemas with
 * simple configuration and syntax in model
 * 
 * Code comments in brazilian portuguese.
 * -----
 * Behavior que adiciona capacidade para execução de buscas
 * complexas com configuração e sintaxe simples em qualquer
 * modelo.
 * 
 * PHP version > 5.2.4
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @copyright 2011, Radig - Soluções em TI, www.radig.com.br
 * @link http://www.radig.com.br
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 * @package radig
 * @subpackage radig.r_search.models.behaviors
 */

App::import('CORE', 'ConnectionManager');

class EasySearchBehavior extends ModelBehavior
{
	/**
	 * Referência para o modelo que está utilizando o behavior
	 * @var Model
	 */
	protected $_Model;
	
	/**
	 * Array contendo a sintaxe de alguns operadores de consulta para
	 * cada um dos drivers de DB suportados.
	 * 
	 * @var array
	 */
	private $_nonConventionSyntax = array(
		'mysql' => array(
			'like' => " LIKE '\%%s\%'",
			'match' => " MATCH(%s) AGAINST(%s)"
		),
		'postgres' => array(
			'ilike' => " ilike '\%%s\%'"
		)
	);

	/**
	 * Inicializa os dados do behavior
	 * 
	 * @see ModelBehavior::setup()
	 */
	public function setup(&$model, $config = array())
	{
		$this->settings = array(
			'inputField' => 'q'
		);
		
		$this->_Model =& $model;
		$this->settings = Set::merge($this->settings, $config);
		
		$db =& ConnectionManager::getDataSource($this->_Model->useDbConfig);
		
	}
}
//
//if(!empty($fullText))
//{
//	$fullText = implode(',', $fullText);
//
//	$conditions[$this->settings['comparassion']]["{$field} MATCH ({$fullText}) AGAINST"] = '(' . $this->query . ')';
//}