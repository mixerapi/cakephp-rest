<?php

namespace MixerApiRest\Test\TestCase\Command;

use Cake\Routing\Route\Route;
use Cake\Routing\Router;
use Cake\TestSuite\ConsoleIntegrationTestTrait;
use Cake\TestSuite\TestCase;

class CreateRoutesCommandTest extends TestCase
{
    use ConsoleIntegrationTestTrait;

    public $fixtures = [
        'plugin.MixerApiRest.Actors'
    ];

    private const ROUTE_FILE = 'routes_test.php';

    public function setUp() : void
    {
        parent::setUp();
        $this->setAppNamespace('MixerApiRest\Test\App');
        $this->useCommandRunner();

        unlink(CONFIG . self::ROUTE_FILE);
        touch(CONFIG . self::ROUTE_FILE);
    }

    public function testSuccess()
    {
        $file = self::ROUTE_FILE;
        $this->exec("mixerapi:rest create --routesFile $file", ['Y']);
        $this->assertOutputContains('Routes were written to ' . CONFIG . $file);
        $this->assertExitSuccess();
    }

    public function testAbort()
    {
        $file = self::ROUTE_FILE;
        $this->exec("mixerapi:rest create --routesFile $file", ['N']);
        $this->assertExitError();
    }

    public function testNoControllersExitError()
    {
        $file = self::ROUTE_FILE;
        $this->exec("mixerapi:rest create --routesFile $file --plugin Nope", ['Y']);
        $this->assertExitError();
    }

    public function testPluginSuccess()
    {
        $this->markTestIncomplete();
    }

    public function testDisplaySuccess()
    {
        $this->exec("mixerapi:rest create --display");
        $this->assertOutputContains('actors:index', 'route name');
        $this->assertOutputContains('actors', 'uri template');
        $this->assertOutputContains('GET', 'method(s)');
        $this->assertOutputContains('Actors', 'controller');
        $this->assertExitSuccess();
    }
}