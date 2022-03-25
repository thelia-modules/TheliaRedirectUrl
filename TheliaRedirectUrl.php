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

namespace TheliaRedirectUrl;

use Propel\Runtime\Connection\ConnectionInterface;
use Symfony\Component\Finder\Finder;
use Thelia\Install\Database;
use Thelia\Module\BaseModule;
use TheliaRedirectUrl\Model\Base\RedirectUrlQuery;

class TheliaRedirectUrl extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'theliaredirecturl';

    public function preActivation(ConnectionInterface $con = null)
    {
        try {
            RedirectUrlQuery::create()->findOne();
        }
        catch (\Exception $e) {
            $database = new Database($con);
            $database->insertSql(null, [__DIR__ . '/Config/thelia.sql']);
        }

        return true;
    }

    public function update($currentVersion, $newVersion, ConnectionInterface $con = null)
    {
        $finder = (new Finder())
            ->files()
            ->name('#.*?\.sql#')
            ->sortByName()
            ->in(__DIR__ . DS . 'Config' . DS . 'update')
        ;
        $database = new Database($con);

        /** @var \Symfony\Component\Finder\SplFileInfo $updateSQLFile */
        foreach ($finder as $updateSQLFile) {
            if (version_compare($currentVersion, str_replace('.sql', '', $updateSQLFile->getFilename()), '<')) {
                $database->insertSql(
                    null,
                    [
                        $updateSQLFile->getPathname()
                    ]
                );
            }
        }
    }

    public static function isValidUrl($url)
    {
        // the url '/' is valid, else the url must start with '/' and not end with '/'
        if ($url != '/') {
            return preg_match('/(^\/)(.)+([^\/]$)/', $url);
        }

        return true;
    }

    public static function formatUrl($url)
    {
        //we want the path with parameter (for example : remove 'http://www.test.fr' in 'http://www.test.fr/shop/product?product_id=12&test=2')
        $url = preg_replace('/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})/', '', $url);

        //remove index and index_dev.php
        $url = preg_replace('/\/index(_dev)?\.php/', '', $url);
        return $url;
    }
}
