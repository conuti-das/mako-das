<?php

namespace App\Tests;

use Codeception\Actor;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
 */
class ApiTester extends Actor
{
    use _generated\ApiTesterActions;

    public function getJWT(): string
    {
        $this->haveHttpHeader('accept', 'application/json');
        $this->haveHttpHeader('Content-Type', 'application/json');
        $this->sendPost(
            '/api/authorization',
            [
                'username' => $_ENV['API_TEST_USERNAME'],
                'password' => $_ENV['API_TEST_PASSWORD'],
            ]
        );
        $this->seeResponseCodeIs(200);

        $token = $this->grabDataFromResponseByJsonPath('token');
        $this->assertNotEmpty($token);

        return $token[0];
    }
}
