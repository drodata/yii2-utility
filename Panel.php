<?php

namespace drodata\utility;

use yii\helpers\Html;

class Panel extends \yii\bootstrap\Widget
{
    public $panelStyles = [
        'default' => 'panel-default',
        'danger'  => 'panel-danger',
        'success' => 'panel-success',
        'info'    => 'panel-info',
        'warning' => 'panel-warning'
    ];
	public $size = 'sm';
	public $width = 12;
	public $style = 'default';
	public $title = "&nbsp;";
	public $clear = false;
	public $float = 'left';
	public $offset = null;

    public function init()
    {
        parent::init();
		$class = 'col-'.$this->size.'-'.$this->width.' pull-'.$this->float;
		$class .= is_null($this->offset) ? '' : ' col-'.$this->size.'-offset-'.$this->offset;
		$opt  = Html::beginTag('div', ['class' => $class]);
		$opt .= '<div class="panel panel-'.$this->style.'">';
  		$opt .= '<div class="panel-heading">'.$this->title.'</div>';
  		$opt .= '<div class="panel-body">';

		echo $opt;

    }
    public function run()
    {
		echo '</div></div></div>';
		if ($this->clear === true)
			echo '<div class="clearfix"></div>';
    }
}
