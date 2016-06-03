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

namespace TheliaRedirectUrl\Controller;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Translation\Translator;
use TheliaRedirectUrl\Model\RedirectUrl;
use TheliaRedirectUrl\Model\RedirectUrlQuery;
use TheliaRedirectUrl\TheliaRedirectUrl;

class Configuration extends BaseAdminController
{
    public function createAction()
    {
        if (null !== $response = $this->checkAuth(array(), 'TheliaRedirectUrl', AccessManager::CREATE)) {
            return $response;
        }

        $form = $this->createForm('redirect.url.create');

        try {
            $vform = $this->validateForm($form, 'POST');

            $url = TheliaRedirectUrl::formatUrl($vform->get('url')->getData());
            $redirect = TheliaRedirectUrl::formatUrl($vform->get('redirect')->getData());
            $tempRedirect = TheliaRedirectUrl::formatUrl($vform->get('temp_redirect')->getData());

            if (null !== $query = RedirectUrlQuery::create()->findOneByUrl($url)) {
                if ($query->getRedirect() != $redirect || $query->getTempRedirect() != $tempRedirect) {
                    $query
                        ->setRedirect($redirect)
                        ->setTempRedirect($tempRedirect)
                        ->save()
                    ;
                }
            }

            (new RedirectUrl())
                ->setUrl($url)
                ->setRedirect($redirect)
                ->setTempRedirect($tempRedirect)
                ->save()
            ;

            return $this->generateSuccessRedirect($form);

        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        $form->setErrorMessage($message);

        $this->getParserContext()
            ->addForm($form)
            ->setGeneralError($message)
        ;

        return $this->generateRedirectFromRoute(
            'admin.module.configure',
            array(),
            array('module_code' => 'TheliaRedirectUrl')
        );
    }
}