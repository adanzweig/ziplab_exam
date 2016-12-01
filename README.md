# Transition-MVC
PHP Framework to update old fashioned and structured PHP into a ligthweight MVC framework

# ORM Tutorial

	$this->loader->model('ModelClass');

	## Insert
		$elem = new ModelClass();
		$elem->attribute->name = 'name';
		$id = $elem->save();

	## Get
		$elements = WelcomeModel::find('name = ?',array( 'name' ) );
		foreach($elements as $elem){
			$elem;
		}
			
	## Update
		$elem = new ModelClass(1);
		$elem->attribute->name = 'name other';
		$elem->save();
				
	## Delete
		$elem->delete();

# Sessions Tutorial
	## Sessions have expiring time, check Session.php file in /framework/classes/session.php

	## Set session
		$this->session->setSession('session name','session value',Encrypt flag[true/false]);
	## Get session
		$sessionValue = $this->session->getSession('session name'));
	## Compare session value
		$this->session->compareSessionValue('session name','new value');

# HTTP Request Tutorial
	
	## Direct URL call 
		/Controller/Method

	## Friendly URL
		Go to /application/config/routes.php and add a router.

	## Plugins or Old code
		/file.php 
		The extension ".php" makes the framework understand that it doesn't need the frame code and goes to application/plugins/Path and file sent.

	## Old code compare
		Add in the controller the parameter:
			 $data['router']['old'][] = 'Controller/Method';
			 or 
			 $data['router']['old'] = array('Controller/Method','/newPlugin/file.php');

		Then call the same controller with /old/[array position of the route you need to check]

