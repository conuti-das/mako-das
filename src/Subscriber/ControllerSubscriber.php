<?php

declare(strict_types=1);

namespace App\Subscriber;

use App\Service\Data\JavaScript\JavaScriptDataManager;
use App\Service\Data\Twig\TwigDataManager;
use Exception;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ControllerSubscriber implements EventSubscriberInterface
{
    public function __construct(
        protected JavaScriptDataManager $javaScriptDataManager,
        protected TwigDataManager $twigDataManager
    ) {
    }

    public function onKernelController(ControllerEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        // the release tag
        // use try/catch especially for the codeception tests
        try {
            $this->javaScriptDataManager->setJSData(
                'system',
                [
                    'release' => $_ENV['RELEASE_TAG'],
                    'environment' => $_ENV['RELEASE_ENVIRONMENT'],
                ]
            );
        } catch (Exception $e) {
            $this->javaScriptDataManager->setJSData('system', ['release' => 'NO RELEASE TAG']);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::CONTROLLER => array(array('onKernelController', 1)),
        );
    }
}
