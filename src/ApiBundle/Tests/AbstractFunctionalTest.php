<?php

namespace ApiBundle\Tests;

use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpKernel\Kernel;
use Liip\FunctionalTestBundle\Test\WebTestCase;

abstract class AbstractFunctionalTest extends WebTestCase
{
    use ContainerAwareTrait;

    /**
     * @var Kernel
     */
    protected static $kernel;

    /**
     * @var DocumentManager
     */
    protected $documentManager;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        if (null === static::$kernel) {
            static::$kernel = $this->createKernel(array('debug' => false));
        }
        static::$kernel->boot();

        $this->setContainer(self::$kernel->getContainer());
        $this->documentManager = $this->container->get('doctrine.odm.mongodb.document_manager');
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $this->tearDownDocumentManager();
        $this->tearDownRedis();
        parent::tearDown();
    }

    private function tearDownDocumentManager()
    {
        if ($this->documentManager) {
            foreach ($this->documentManager->getDocumentDatabases() as $db) {
                foreach ($db->listCollections() as $collection) {
                    $collection->drop();
                }
            }
            $this->documentManager->getConnection()->close();
        }

        $this->documentManager->getConnection()->close();
    }

    private function tearDownRedis()
    {
        $this->container->get('snc_redis.default')->flushDB();
    }
}
