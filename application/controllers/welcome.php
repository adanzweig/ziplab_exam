<?php
Class Welcome extends Controller{
	function Home($params=array()){
		/*
	   * ------------------------------------------------------
	   *  Old versions of method
	   * ------------------------------------------------------
	   */
		$data['router']['old'][] = 'Welcome/Get';
		$data['router']['old'][] = 'welcome.php'; 

		/*
	   * ------------------------------------------------------
	   *  Session management
	   * ------------------------------------------------------
	   */
		$this->session->setSession('test','value',true);
		$sessionValue = $this->session->getSession('test');
		echo ($this->session->compareSessionValue('test','value'));

		/*
	   * ------------------------------------------------------
	   *  HTML Header management
	   * ------------------------------------------------------
	   */
		$data['header'] = true;
		$data['headers']['title'] = 'Welcome Transition MVC';
		$data['headers']['meta'] = array('<meta>','<meta>');

		/*
	   * ------------------------------------------------------
	   *  ORM management
	   * ------------------------------------------------------
	   */
		$this->loader->model('welcomeModel');

			/*
		   * ------------------------------------------------------
		   *  Insert
		   * ------------------------------------------------------
		   */
			$elem = new WelcomeModel();
			$elem->attribute->name = 'la';
			$elem->attribute->var = 'lo';
			$id = $elem->save();

			/*
		   * ------------------------------------------------------
		   *  FIND
		   * ------------------------------------------------------
		   */
			$elements = WelcomeModel::find('name = ?',array( 'la' ) );
			foreach($elements as $elem){
			
				/*
			   * ------------------------------------------------------
			   *  UPDATE
			   * ------------------------------------------------------
			   */
				$elem->attribute->var = $elem->attribute->id.$elem->attribute->var;
				$elem->save();
				
				/*
			   * ------------------------------------------------------
			   *  DELETE
			   * ------------------------------------------------------
			   */
				if($elem->attribute->id > 18){
					$elem->delete();
				}
			}

		
		/*
	   * ------------------------------------------------------
	   *  View management
	   * ------------------------------------------------------
	   */
		$this->viewer->show('welcome',$data);
		
		
	}
	function Get($params = array()){
		$data['header'] = true;
		$this->viewer->show('welcomeOld',$data);
	}
}