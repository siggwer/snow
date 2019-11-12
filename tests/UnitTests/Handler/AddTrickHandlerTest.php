<?php

namespace App\Tests\UnitTests\Handler;

use App\Entity\Trick;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Handler\AbstractHandler;
use App\Handler\AddTrickHandler;

/**
 * Class AddTrickHandlerTest
 *
 * @package App\Tests\UnitTests\Handler
 */
class AddTrickHandlerTest extends AbstractTestHandler
{
    /**
     * @return AbstractHandler
     */
    public function getHandler(): AbstractHandler
    {
        return new AddTrickHandler(
            $this->createMock(EntityManagerInterface::class),
            $this->createMock(EventDispatcherInterface::class),
            $this->createMock(FlashBagInterface::class),
            $this->createMock(Security::class)
        );
    }

    public function getData()
    {
       return new Trick();
    }
}