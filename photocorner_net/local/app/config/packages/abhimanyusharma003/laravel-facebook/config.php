<?php

return array(
    'secret'   => array(
        'appId'  => 'appId',
        'secret' => 'secret'
    ),
    //Redirect after successful login
    'redirect' => url('/login/facebook'),
    //When Someone Logout from your Site
    'logout'   => url('/logout'),
    //you can add scope according to your requirement
    'scope'    => 'email'
);
