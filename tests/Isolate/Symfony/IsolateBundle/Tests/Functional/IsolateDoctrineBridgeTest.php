<?php

namespace Isolate\Symfony\IsolateBundle\Tests\Functional;

use Doctrine\Bundle\DoctrineBundle\Command\Proxy\UpdateSchemaDoctrineCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class IsolateDoctrineBridgeTest extends BundleTestCase
{
    public function setUp()
    {
        self::$kernel = $this->createKernel(['suite' => 'DoctrineBridge']);
        self::$kernel->boot();
    }

    /**
     * @runInSeparateProcess
     */
    public function test_doctrine_orm_transaction()
    {
        $tester = $this->getUpdateSchemaTester();
        $tester->execute(array('command' => 'doctrine:schema:updates', '--force' => 1));

        $isolate = self::$kernel->getContainer()->get('isolate');
        $transaction = $isolate->getContext('doctrine_orm')->openTransaction();

        $this->assertInstanceOf(
            'Isolate\PersistenceContext\Transaction\Doctrine\ORMTransaction',
            $transaction
        );
    }

    private function getUpdateSchemaTester()
    {
        $application = new Application(self::$kernel);
        $application->add(new UpdateSchemaDoctrineCommand());

        $command = $application->find('doctrine:schema:update');

        return new CommandTester($command);
    }
}
