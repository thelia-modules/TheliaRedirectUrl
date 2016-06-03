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