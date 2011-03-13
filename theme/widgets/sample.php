<?php

class SampleWidget extends WP_Widget
{
	public function SampleWidget()
	{
		parent::WP_Widget(false, 'SampleWidget');
	}
	
	public function widget($args, $instance)
	{
		include 'sample.html';
	}
}

register_widget('SampleWidget');
