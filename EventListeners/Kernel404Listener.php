<?php
/*************************************************************************************/
/*      This file is part of the TheliaRedirectUrl package.                          */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace TheliaRedirectUrl\EventListeners;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Tools\URL;
use TheliaRedirectUrl\Model\RedirectUrl;
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

            // We first check if the RequestUri match and if not we check with the pathInfo
            $path = $this->request->getRequestUri();
            $pathInfo = $this->request->getPathInfo();

            $query = RedirectUrlQuery::create()->findOneByUrl($path);

            if (null !== $query && $path !== $query->getRedirect()) {
                $this->resolveRedirect($event, $query);
            } elseif ((null !== $query = RedirectUrlQuery::create()->findOneByUrl($pathInfo)) && $pathInfo !== $query->getRedirect()) {
                $this->resolveRedirect($event, $query);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => ['kernel404Resolver', 256]
        ];
    }

    /**
     * @param FilterResponseEvent $event
     * @param $query
     */
    protected function resolveRedirect(FilterResponseEvent $event, RedirectUrl $query)
    {
        if (null !== $query->getTempRedirect() && '' !== $query->getTempRedirect()) {
            $event->setResponse(new RedirectResponse(URL::getInstance()->absoluteUrl($query->getTempRedirect()), 302));
        } else {
            $event->setResponse(new RedirectResponse(URL::getInstance()->absoluteUrl($query->getRedirect()), 301));
        }
    }
}