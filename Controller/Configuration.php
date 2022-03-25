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
        if (null !== $response = $this->checkAuth([], TheliaRedirectUrl::getModuleCode(), AccessManager::CREATE)) {
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
            else {
                (new RedirectUrl())
                    ->setUrl($url)
                    ->setRedirect($redirect)
                    ->setTempRedirect($tempRedirect)
                    ->save()
                ;
            }

            return $this->generateSuccessRedirect($form);
        }
        catch (\Exception $e) {
            $message = $e->getMessage();
        }

        $form->setErrorMessage($message);

        $this
            ->getParserContext()
            ->addForm($form)
            ->setGeneralError($message)
        ;
        return $this->generateRedirectFromRoute(
            'admin.module.configure',
            [],
            ['module_code' => TheliaRedirectUrl::getModuleCode()]
        );
    }

    public function deleteAction()
    {
        if (null !== $response = $this->checkAuth([], TheliaRedirectUrl::getModuleCode(), AccessManager::DELETE)) {
            return $response;
        }

        $errorMessage = null;

        try {
            if (null != $deleteQuery = RedirectUrlQuery::create()->findPk($this->getRequest()->get('theliaredirecturl_id'))) {
                $deleteQuery->delete();
            }
        }
        catch (\Exception $e) {
            $errorMessage = $e->getMessage();
        }

        if (null !== $errorMessage) {
            $this->setupFormErrorContext('Redirect URL delete error', $errorMessage, $addressForm);
            $response = $this->generateRedirect($redirect);
        }

        return $this->generateRedirectFromRoute(
            'admin.module.configure',
            [],
            ['module_code' => TheliaRedirectUrl::getModuleCode()]
        );
    }

    public function updateAction()
    {
        if (null !== $response = $this->checkAuth([], TheliaRedirectUrl::getModuleCode(), AccessManager::UPDATE)) {
            return $response;
        }

        $form = $this->createForm('redirect.url.update');

        try {
            $vform = $this->validateForm($form, 'POST');

            $url = TheliaRedirectUrl::formatUrl($vform->get('url')->getData());
            $redirect = TheliaRedirectUrl::formatUrl($vform->get('redirect')->getData());
            $tempRedirect = TheliaRedirectUrl::formatUrl($vform->get('temp_redirect')->getData());

            if (null != $query = RedirectUrlQuery::create()->findPk($vform->get('id')->getData())) {
                if ($query->getRedirect() != $redirect || $query->getTempRedirect() != $tempRedirect) {
                    $query
                        ->setRedirect($redirect)
                        ->setTempRedirect($tempRedirect)
                        ->save()
                    ;
                }
            }

            return $this->generateSuccessRedirect($form);
        }
        catch (\Exception $e) {
            $message = $e->getMessage();
        }

        $form->setErrorMessage($message);

        $this
            ->getParserContext()
            ->addForm($form)
            ->setGeneralError($message)
        ;
        return $this->generateRedirectFromRoute(
            'admin.module.configure',
            [],
            ['module_code' => TheliaRedirectUrl::getModuleCode()]
        );
    }
}
