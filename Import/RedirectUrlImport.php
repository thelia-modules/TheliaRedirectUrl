<?php
/**
 * Created by PhpStorm.
 * User: tompradat
 * Date: 21/04/2016
 * Time: 10:15
 */

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
        $url = TheliaRedirectUrl::formatUrl($data['url']);
        $redirect = TheliaRedirectUrl::formatUrl($data['redirect']);

        if (isset($data['temp_redirect'])) {
            $tempRedirect = TheliaRedirectUrl::formatUrl($data['temp_redirect']);
        }

        if (null === $query = RedirectUrlQuery::create()->findOneByUrl($url)) {
            (new RedirectUrl())
                ->setUrl($url)
                ->setRedirect($redirect)
                ->setTempRedirect($tempRedirect)
                ->save()
            ;
            $this->importedRows++;
        } elseif ($query->getRedirect() != $redirect || $query->getTempRedirect() != $tempRedirect) {
            $query
                ->setRedirect($redirect)
                ->setTempRedirect($tempRedirect)
                ->save()
            ;
            $this->importedRows++;
        }
    }
}