<?php

namespace App\Admin\Extensions;
use Encore\Admin\Form\Field;

class CityPicker extends Field{
    protected $view = 'admin.city-picker';

    protected static $css = [
        '/vendor/city-picker/css/city-picker.css',
    ];

    protected static $js = [
        '/vendor/city-picker/js/city-picker.data.js',
        '/vendor/city-picker/js/city-picker.js',
    ];

    public function render()
    {
        $name = $this->formatName($this->column);

        $this->script = <<<EOT

    $("form").submit(function(){				
		$(".city-picker-span .select-item").each(function(){		
		    $('form input[name="'+$(this).attr('data-count')+'_code"]').val($(this).attr('data-code'));	
			$('form input[name="'+$(this).attr('data-count')+'"]').val($(this).html());						
		});
		
	});
    $("#{$this->id}").citypicker("reset");
    $("#{$this->id}").citypicker("destroy");
    $("#{$this->id}").citypicker({
      province: $('form input[name="province"]').val(),
      city: $('form input[name="city"]').val(),
      district: $('form input[name="district"]').val()
    });

EOT;
        return parent::render();
    }
}