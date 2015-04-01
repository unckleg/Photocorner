<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(

		/**
		 * Facebook
		 */
        'Facebook' => array(
            'client_id'     => '308175872639781',
            'client_secret' => '596aa4537e964c080623d783ce56d40c',
            'scope'         => array('email'),
        ),		

        'Google' => array(
            'client_id'     => '9840082737-9s4igu3cqrh45hv1sd63b0qsloqmk96l.apps.googleusercontent.com',
            'client_secret' => '1NfzfsrjbXVXOlWsyoa9r84s',
		    'scope'         => array('userinfo_email', 'userinfo_profile'),
		),  
	)

);