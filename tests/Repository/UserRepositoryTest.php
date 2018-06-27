<?php

// tests/Repository/ProductRepositoryTest.php
namespace App\Tests\Repository;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductRepositoryTest extends KernelTestCase
{
    /**
    * @var \Doctrine\ORM\EntityManager
    */
    private $entityManager;

    /**
    * {@inheritDoc}
    */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
        ->get('doctrine')
        ->getManager();
    }

    public function testSearchByCategoryName()
    {
        $user = $this->entityManager
        ->getRepository(User::class)
        ->findOneBy(array('username' => 'ndoyer'))
        ;

        $this->assertEquals('Nicolas Doyer', $user->getFullname());
    }

}