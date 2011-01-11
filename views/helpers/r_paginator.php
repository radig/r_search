<?php
class RPaginator extends AppHelper
{
	protected $_paginator = null;
	
	/**
	 * 
	 * @param PaginatorHelper $paginator
	 * @param array $options
	 */
	public function controls(&$paginator, $options = array())
	{
		$this->_paginator =& $paginator;
		
		if(!empty($options['filters']))
		{
			$this->_paginator->options(array('url' => array_merge($options['filters'], $this->passedArgs)));
		} 
		
		$out =	$this->_paginator->first('<< '.__('first', true), array(), null, array('class'=>'disabled')) .
				$this->_paginator->prev(__('previous', true), array(), null, array('class'=>'disabled')) .
				$this->_paginator->numbers(array('separator' => '')) .
				$this->_paginator->next(__('next', true), array(), null, array('class' => 'disabled')) .
				$this->_paginator->last(__('last', true).' >>', array(), null, array('class' => 'disabled'));
		
		if(isset($options['return']) && $options['return'] === true)
		{
			return $out;
		}
		else
		{
			echo $out;
		}
	}
}