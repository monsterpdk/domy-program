<?php
class CLinkColumnEval extends CLinkColumn
{
	
	protected function renderDataCellContent($row,$data)
	{
		if($this->urlExpression!==null)
			$url=$this->evaluateExpression($this->urlExpression,array('data'=>$data,'row'=>$row));
		else
			$url=$this->url;
		if($this->labelExpression!==null)
			$label=$this->evaluateExpression($this->labelExpression,array('data'=>$data,'row'=>$row));
		else
			$label=$this->label;
		$options=$this->linkHtmlOptions;
		
		if( isset ( $options ) ) 
		{
				foreach( $options as $key=>$value) 
				{
					$options[$key] = $this->evaluateExpression($options[$key], array('data'=>$data,'row'=>$row));
				}

				unset($options['evaluateOptions']);
		}
		
		if(is_string($this->imageUrl))
			echo CHtml::link(CHtml::image($this->imageUrl,$label),$url,$options);
		else
			echo CHtml::link($label,$url,$options);
	}
	
}
