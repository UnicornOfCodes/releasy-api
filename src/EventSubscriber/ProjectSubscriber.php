<?php

namespace App\EventSubscriber;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class ProjectSubscriber implements EventSubscriberInterface
{
    private $security;
    private $em;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
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

        $this->em->persist($project);
        $this->em->flush();
    }
}