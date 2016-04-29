<?php
/**
 * Created by PhpStorm.
 * User: tompradat
 * Date: 21/04/2016
 * Time: 09:30
 */

namespace TheliaRedirectUrl\Hook;

use Thelia\Core\Event\Hook\HookRenderEvent;
use Thelia\Core\Hook\BaseHook;

class BackHook extends BaseHook
{
    public function onModuleConfiguration(HookRenderEvent $event)
    {
        $event->add($this->render('module-configuration.html'));
    }

    public function onModuleConfigJs(HookRenderEvent $event)
    {
        $event->add($this->render('module-configuration-js.html'));
    }
}