<?php
/** 
 * Helper para criação de input de pesquisa personalizado
 * 
 * Possui método para imprimir um form com um campo de pesquisa que envia os valores via get
 * 
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 * 
 * @copyright 2011, Radig - Soluções em TI, www.radig.com.br
 * @link http://www.radig.com.br
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 * @package radig
 * @subpackage radig.pagination.views.helpers
 */
class RSearchHelper extends AppHelper
{
	/**
	 * Helpers 
	 * @var array $helpers
	 */
	public $helpers = array('Form');
	
	/**
	 * Retorna um formulário de pesquisa personalidado
	 * 
	 * @param string $query_var Nome do campo no formulário
	 * @param array $options Opções do campo de busca (ver em Form::input)
	 */
	public function searchForm($query_var = 'q', $options = array())
	{
		$controller = $this->params['controller'];

		//cria um formulário com o nome do model atual
		$out  = $this->Form->create('Search', array('url' => array('controller' => $controller), 'type' => 'get'));

		//cria um input com nome $query_var e opções $options
		$out .= $this->Form->input($query_var, $options);
		
		$out .= $this->Form->end();
		
		return $out;
	}
}