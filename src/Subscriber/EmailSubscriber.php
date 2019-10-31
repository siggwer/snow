<?php

namespace App\Subscriber;

use App\Event\UpdateTrickEmailEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Event\ForgotPasswordEmailEvent;
use App\Event\AddTrickEmailEvent;
use App\Services\EmailHelper;

/**
 * Class EmailSubscriber.
 */
class EmailSubscriber implements EventSubscriberInterface
{
    /**
     * @var EmailHelper
     */
    private $emailer;

    /**
     * EmailSubscriber constructor.
     *
     * @param EmailHelper $emailer
     */
    public function __construct(EmailHelper $emailer)
    {
        $this->emailer = $emailer;
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * ['eventName' => 'methodName']
     *  * ['eventName' => ['methodName', $priority]]
     *  * ['eventName' => [['methodName1', $priority], ['methodName2']]]
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            ForgotPasswordEmailEvent::NAME => 'onForgotPassword',
            AddTrickEmailEvent::NAME => 'onAddTrick',
            UpdateTrickEmailEvent::NAME => 'onUpdateTrick'
        ];
    }

    /**
     * ForgotPasswordEmailEvent $event.
     */
    public function onForgotPassword(ForgotPasswordEmailEvent $event): void
    {
        $from = [
            'email' => 'admin.snowtrick@yopmail.com\'',
            'name' => 'Administrateur',
        ];
        $to = [
            'email' => $event->getEmail(),
            'name' => explode('@', $event->getEmail())[0],
        ];

        $this->emailer->mail(
            'Confirmation de votre compte',
            $from,
            $to,
            'security/forgot/forgot_email.html.twig',
            [
                'forgot' => $event,
                'passwordToken' => $event->getToken(),
            ]
        );
    }

    /**
     * @param AddTrickEmailEvent $event
     */
    public function onAddTrick(AddTrickEmailEvent $event): void
    {
        $from = [
            'email' => 'admin.snowtrick@yopmail.com\'',
            'name' => 'Administrateur',
        ];
        $to = [
            'email' => $event->getEmail(),
            'name' => explode('@', $event->getEmail())[0],
        ];

        $this->emailer->mail(
            'Ton trick a été crée',
            $from,
            $to,
            'trick/add_trick_email.html.twig',
            [
                'email' => $event,
                'slug' => $event->getSlug()
            ]
        );
    }

    /**
     * @param UpdateTrickEmailEvent $event
     */
    public function onUpdateTrick(UpdateTrickEmailEvent $event): void
    {
        $from = [
            'email' => 'admin.snowtrick@yopmail.com\'',
            'name' => 'Administrateur',
        ];
        $to = [
            'email' => $event->getEmail(),
            'name' => explode('@', $event->getEmail())[0],
        ];

        $this->emailer->mail(
            'Ton trick a été crée',
            $from,
            $to,
            'trick/update_trick_email.html.twig',
            [
                'email' => $event,
                'slug' => $event->getSlug()
            ]
        );
    }
}
