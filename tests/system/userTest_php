<?php

class userTest extends PHPUnit_Framework_TestCase
{

    /**
     * Get User By Email
     */
    public function testGetUserByEmail()
    {
        //Select random user
        $users = User::select();
        $user = $users[0];

        //Check
        $this->assertInstanceOf(User, $user->getUserByEmail($user->email));
    }
}
