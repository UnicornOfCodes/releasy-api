<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Project;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class ProjectSubscriber implements EventSubscriberInterface
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['addUserCurrent', EventPriorities::POST_WRITE],
        ];
    }

    public function addUserCurrent(ViewEvent $event)
    {
        $project = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$project instanceof Project || Request::METHOD_POST !== $method) {
            return;
        }

        $project->addUser($this->security->getUser());
    }
}