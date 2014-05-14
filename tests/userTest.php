<?php

class UserTest extends PHPUnit_Framework_TestCase
{

    public function testGetUserByEmail()
    {
    	// Select random user
    	$users = User::select();
    	$user = $users[0];

        // Assert
        $this->assertInstanceOf(User, $user->getUserByEmail($user->email));
    }
}