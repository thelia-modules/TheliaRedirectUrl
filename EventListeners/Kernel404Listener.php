<?php
/**
 * Created by PhpStorm.
 * User: tompradat
 * Date: 20/04/2016
 * Time: 16:07
 */

namespace TheliaRedirectUrl\EventListeners;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Tools\URL;
use TheliaRedirectUrl\Model\RedirectUrlQuery;
use TheliaRedirectUrl\TheliaRedirectUrl;

class Kernel404Listener implements EventSubscriberInterface
{
    /** @var Request */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function kernel404Resolver(FilterResponseEvent $event)
    {
        if ($event->getResponse()->getStatusCode() === 404) {

            $path = TheliaRedirectUrl::formatUrl($this->request->getUri());

            $query = RedirectUrlQuery::create()->findOneByUrl($path);

            if (null !== $query && $path !== $query->getRedirect()) {
                if (null !== $query->getTempRedirect() && '' !== $query->getTempRedirect()) {
                    $event->setResponse(new RedirectResponse(URL::getInstance()->absoluteUrl($query->getTempRedirect()), 302));
                } else {
                    $event->setResponse(new RedirectResponse(URL::getInstance()->absoluteUrl($query->getRedirect()), 301));
                }
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => ['kernel404Resolver', 256]
        ];
    }
}