<?php

use \MyHonors\Auth\MyHonorsAuthFactory;


class AuthFactoryTest extends \Codeception\TestCase\Test
{

    use \Codeception\Specify;
    
    protected function _after() {
        Mockery::close();
    }

    /**
    * Tests AuthFactory without any login initialization
    */
    public function testNotLoggedInState() 
    {
        // Injected AuthToken Object should not have its initialization 
        // methods - fromUserInformation() and fromStringToken()
        $authTokenMock = Mockery::mock(
            "MyHonors\Auth\Contract\AuthTokenInterface", 
            function ($mock) {
                $mock->shouldNotReceive("fromUserInformation");
                $mock->shouldNotReceive("fromStringToken");
            }
        );
        // Injected AuthDriver Object should not have its 
        // login() method called
        $authDriverMock = Mockery::mock(
            "MyHonors\Auth\Contract\AuthDriverInterface", 
            function ($mock) {
                $mock->shouldNotReceive("login");
            }
        );
        
        $instance = new MyHonorsAuthFactory($authDriverMock, 
                                            $authTokenMock);
        
        expect("Auth Factory is not in a logged in state", 
               $instance->isLoggedIn())->equals(false);
    }

    /**
    * Tests AuthFactory implementation with a correct 
    * credential-based login
    */
    public function testCorrectCredentialedLogin()
    {   
        $correctUsername = "someUsername";
        $correctPassword = "somePassword";

        $authUserMock = Mockery::mock(
            "MyHonors\Auth\Contract\AuthUserInterface"
        );
        // The injected AuthToken Object must be initialized 
        // at succesful login, being provided an AuthUser 
        // object which becomes the token's payload
        $authTokenMock = Mockery::mock(
            "MyHonors\Auth\Contract\AuthTokenInterface", 
            function ($mock) use ($authUserMock) {
                $mock
                    ->shouldReceive("fromUserInformation")->once()
                    ->with($authUserMock);
                $mock
                    ->shouldNotReceive("fromAuthToken");
            }
        );
        // The Injected AuthDriver Object must be requested for 
        // the actual "logging in" implementation. 
        // After a succesful log in, the AuthDriver Object
        // must then return an AuthUser object whenever 
        // its getUser method is called.
        $authDriverMock = Mockery::mock(
            "MyHonors\Auth\Contract\AuthDriverInterface",
            function ($mock) use ($authUserMock, $correctUsername, 
                                  $correctPassword) {
                $mock
                    ->shouldReceive("login")->once()
                    ->with($correctUsername, $correctPassword)
                    ->andReturn(true)
                    ->ordered();
                $mock
                    ->shouldReceive("getUser")->once()
                    ->andReturn($authUserMock)
                    ->ordered();
            }
        );

        $instance = new MyHonorsAuthFactory($authDriverMock, 
                                            $authTokenMock);

        $instance->loginByCredentials($correctUsername, 
                                      $correctPassword);
        expect("Auth Factory is in a logged-in state", 
               $instance->isLoggedIn())->equals(true);
        expect("Auth Factory returns the same injected auth token", 
               $instance->getToken())->equals($authTokenMock);
    }

    /**
    * Tests AuthFactory implementation with a correct token-based login
    */
    public function testCorrectTokenizedLogin()
    {
        $correctToken = "123someTestToken123";

        // The injected AuthToken object must be initialized at 
        // succesful login with the token provided to the AuthFactory
        // object's loginByToken() method. The validity of this token
        // is then checked.
        $authTokenMock = Mockery::mock(
            "MyHonors\Auth\Contract\AuthTokenInterface", 
            function ($mock) use ($correctToken) {
                $mock
                    ->shouldReceive("fromAuthToken")->once()
                    ->with($correctToken)
                    ->ordered();
                $mock
                    ->shouldReceive("isValid")->once()
                    ->withNoArgs()
                    ->andReturn(true)
                    ->ordered();
            }
        );
        // The injected AuthDriver object may or may not be initialized 
        // through the login method (to confirm/not confirm 
        // the contents) of a token
        $authDriverMock = Mockery::mock(
            "MyHonors\Auth\Contract\AuthDriverInterface", 
            function ($mock) {
                $mock
                    ->shouldReceive("login")->zeroOrMoreTimes();
            }
        );

        $instance = new MyHonorsAuthFactory($authDriverMock, 
                                            $authTokenMock);
        $instance->loginByToken($correctToken);
        expect("Auth Factory is in a logged-in state", 
               $instance->isLoggedIn())->equals(true);
        expect("Auth Factory returns the same injected auth token", 
               $instance->getToken())->equals($authTokenMock);
    }
    
    /**
    * Tests AuthFactory implementation with an incorrect 
    * credential-based login (inappropriate set of credentials).
    */
    public function testIncorrectCredentialedLogin() 
    {
        $correctUsername = "someUsername";
        $correctPassword = "somePassword";
        
        // The injected AuthToken object must not be initialized
        $authTokenMock = Mockery::mock(
            "MyHonors\Auth\Contract\AuthTokenInterface", 
            function ($mock) {
                $mock
                    ->shouldNotReceive("fromUserInformation");
            }
        );
        // The injected AuthDriver object must have its login() method 
        // called because this determines whether the given credentials 
        // are correct or incorrect.
        $authDriverMock = Mockery::mock(
            "MyHonors\Auth\Contract\AuthDriverInterface", 
            function ($mock) use ($correctUsername, $correctPassword) {
                $mock
                    ->shouldReceive("login")->once()
                    ->with($correctUsername, $correctPassword)
                    ->andReturn(false);
            }
        );
        
        $instance = new MyHonorsAuthFactory($authDriverMock, 
                                            $authTokenMock);
        $instance->loginByCredentials($correctUsername, 
                                      $correctPassword);
        expect("Auth Factory is NOT in a logged-in state", 
               $instance->isLoggedIn(), false);
        
        // NotLoggedInException exception should throw when trying 
        // to access token
        $exception = "MyHonors\Auth\Exception\NotLoggedInException";
        $this->setExpectedException($exception);
        $instance->getToken();
    }
    
}