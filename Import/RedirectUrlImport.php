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

namespace TheliaRedirectUrl\Import;

use Thelia\ImportExport\Import\AbstractImport;
use TheliaRedirectUrl\Model\RedirectUrl;
use TheliaRedirectUrl\Model\RedirectUrlQuery;
use TheliaRedirectUrl\TheliaRedirectUrl;

class RedirectUrlImport extends AbstractImport
{
    protected $mandatoryColumns = [
        'url',
        'redirect'
    ];

    public function importData(array $data)
    {
        $tempRedirect = '';
        $url = $data['url'];
        $redirect = $data['redirect'];

        if (isset($data['temp_redirect'])) {
            $tempRedirect = $data['temp_redirect'];
        }

        // check if columns have a valid url format
        if (!TheliaRedirectUrl::isValidUrl($url)) {
            $errorUrl = $url;
        }elseif (!TheliaRedirectUrl::isValidUrl($redirect)) {
            $errorUrl = $redirect;
        }elseif($tempRedirect !='' && !TheliaRedirectUrl::isValidUrl($tempRedirect)) {
            $errorUrl = $tempRedirect;
        }

        // at this point one of the url has an invalid format
        if (isset($errorUrl)) {
            throw new \Exception('The url format is not valid for the following url : '.$errorUrl);
        }

        // if no redirection for this url exists, create one
        if (null === $query = RedirectUrlQuery::create()->findOneByUrl($url)) {
            (new RedirectUrl())
                ->setUrl($url)
                ->setRedirect($redirect)
                ->setTempRedirect($tempRedirect)
                ->save()
            ;
            $this->importedRows++;
        } elseif ($query->getRedirect() != $redirect || $query->getTempRedirect() != $tempRedirect) { //else check if the redirection or temp redirection is different
            $query
                ->setRedirect($redirect)
                ->setTempRedirect($tempRedirect)
                ->save()
            ;
            $this->importedRows++;
        }
    }
}