<?php

namespace App\Tests\UnitTests\Handler;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Handler\ProfilHandler;
use App\Entity\User;

/**
 * Class ProfilHandlerTest
 *
 * @package App\Tests\UnitTests\Handler
 */
class ProfilHandlerTest extends TestCase
{
    /**
     *
     */
    public function testHandle(

    ) {
        $handler = new ProfilHandler($this->createMock(EntityManagerInterface::class),
            $this->createMock(FlashBagInterface::class),
            $this->createMock(Security::class)
        );

        $formFactory = $this->createMock(FormFactoryInterface::class);

        $form = $this->createMock(FormInterface::class);
        $form->method('handleRequest')->willReturnSelf();
        $form->method('isSubmitted')->willReturn(true);
        $form->method('isValid')->willReturn(true);

        $formFactory->method('create')->willReturn($form);

        $handler->setFormFactory($formFactory);

        $this->assertTrue(
            $handler->handle($this->createMock(Request::class), new User())
        );
    }

}