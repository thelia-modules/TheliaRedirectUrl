<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
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
        } catch (\Exception $e) {
            $database = new Database($con);
            $database->insertSql(null, array(__DIR__ . '/Config/thelia.sql'));
        }

        return true;
    }

    public static function formatUrl($url)
    {
        if (!preg_match('/\//', $url)) {
            if (empty(parse_url($url, PHP_URL_SCHEME))) {
                $url = 'http://' . $url;
            }
        }

        $path = parse_url($url, PHP_URL_PATH);
        $path = str_replace('/index_dev.php', '', $path);

        return $path;
    }
}
