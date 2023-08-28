<?php
if(empty($this->options)) {
	Yii::app()->slaveScript->registerScript('jalaliDatePicker'.$this->id,"
		$('#". $this->id ."').datepicker();
	");
}else {
	Yii::app()->slaveScript->registerScript('jalaliDatePicker'.$this->id,"
		$('#". $this->id ."').datepicker(". CJavaScript::encode($this->options) .");
	");
} 

?>