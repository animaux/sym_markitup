<?php

// Used multiselect to checkboxes extention as template

class extension_sym_markitup extends Extension {
	
	public function getSubscribedDelegates(){
		return array(
			array(
				'page' => '/backend/',
				'delegate' => 'AdminPagePreGenerate',
				'callback' => 'appendAssets'
			),
			array(
				'page' => '/blueprints/sections/',
				'delegate' => 'FieldPostEdit',
				'callback' => 'saveFieldSettings'
			)
		);
	}
	
	public function saveFieldSettings($context){
		//save field settings
		if (isset($context['data']['markitup'])){
			$fieldID = $context['field']->get('id');
			Symphony::Configuration()->set($fieldID, '["' .str_replace(',', '","', implode(',',  $context['data']['markitup']))  . '"]' ,'sym_markitup');
			Symphony::Configuration()->write();
			// var_dump($context['data']['markitup']);die;
		}
	}

	
	public function appendAssets($context){

		$settings = Symphony::Configuration()->get('sym_markitup');
		$buttons = $settings['buttons'];

		if ( in_array(Administration::instance()->Page->_context['page'], array('new', 'edit')) || in_array(Administration::instance()->Page->_context['0'], array('new', 'edit'))){

			$script = 'Symphony.MarkItUp ={}; Symphony.MarkItUp.buttons='. $buttons .';Symphony.MarkItUp.fields =[];';

			// var_dump($script);die;

			foreach ($settings as $key => $setting) {
				if ($key !== 'buttons')
					$script .= "Symphony.MarkItUp.fields[{$key}]={$setting} ;";
			}

			Administration::instance()->Page->addElementToHead(
				new XMLElement('script', $script  , array(
					'type' => 'text/javascript'
				))              
			);
		}

		if(isset(Administration::instance()->Page->_context) && in_array(Administration::instance()->Page->_context['0'], array('new', 'edit'))){            
			Administration::instance()->Page->addScriptToHead(URL . '/extensions/sym_markitup/assets/field-preferences.js', 224);
		}

		if(isset(Administration::instance()->Page->_context['section_handle']) && in_array(Administration::instance()->Page->_context['page'], array('new', 'edit'))){	
			Administration::instance()->Page->addStylesheetToHead('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css', 'screen', 221);
			Administration::instance()->Page->addStylesheetToHead(URL . '/extensions/sym_markitup/assets/style.css?1', 'screen', 222);
			Administration::instance()->Page->addScriptToHead(URL . '/extensions/sym_markitup/assets/jquery.markitup.js', 223);
			Administration::instance()->Page->addScriptToHead(URL . '/extensions/sym_markitup/assets/init.js', 224);
		}
	}

	public function install(){
		$buttonsDefaultConfig = '[
							{name:\'First Level Heading\', className:\'fa fa-header h1\' , key:\'1\', placeHolder:\'Your title here...\', closeWith:function(markItUp) { return miu.markdownTitle(markItUp, \'=\') } },
							{name:\'Second Level Heading\', className:\'fa fa-header h2\',  key:\'2\', placeHolder:\'Your title here...\', closeWith:function(markItUp) { return miu.markdownTitle(markItUp, \'-\') } },
							{name:\'Heading 3\', key:\'3\', className:\'fa fa-header h3\', openWith:\'### \', placeHolder:\'Your title here...\' },
							{name:\'Heading 4\', key:\'4\', className:\'fa fa-header h4\', openWith:\'#### \', placeHolder:\'Your title here...\' },
							{name:\'Heading 5\', key:\'5\', className:\'fa fa-header h5\', openWith:\'##### \', placeHolder:\'Your title here...\' },
							{name:\'Heading 6\', key:\'6\', className:\'fa fa-header h6\', openWith:\'###### \', placeHolder:\'Your title here...\' },
							{separator:\'|\' },     
							{name:\'Bold\', className:\'fa fa-bold\', key:\'B\', openWith:\'**\', closeWith:\'**\'},
							{name:\'Italic\', className:\'fa fa-italic\', key:\'I\', openWith:\'_\', closeWith:\'_\'},
							{separator:\'|\' },
							{name:\'Bulleted List\', className:\'fa fa-list-ul\', openWith:\'- \' },
							{name:\'Numeric List\', className:\'fa fa-list-ol\', openWith:function(markItUp) {
								return markItUp.line+\'. \';
							}},
							{separator:\'|\' },
							{name:\'Picture\', className:\'fa fa-image\', key:\'P\', replaceWith:\'![[![Alternative text]!]]([![URL:!:http://]!] "[![Title]!]")\'},
							{name:\'Link\', className:\'fa fa-link\', key:\'L\', openWith:\'[\', closeWith:\']([![Url:!:http://]!] "[![Title]!]")\', placeHolder:\'Your text to link here...\' },
							{separator:\'|\'},  
							{name:\'Quotes\', className:\'fa fa-quote-left\', openWith:\'> \'},
							{name:\'Code Block / Code\', className:\'fa fa-code\', openWith:\'(!(   |!|`)!)\', closeWith:\'(!(`)!)\'}
						]';

		Symphony::Configuration()->set('buttons', $buttonsDefaultConfig ,'sym_markitup');
		Symphony::Configuration()->write();
	}
}
		
?>