<?php
/*************************************************************************************/
/*      This file is part of the module TheliaRedirectUrl                            */
/*                                                                                   */
/*      Copyright (c) Pixel Plurimedia                                               */
/*      email : thierry@pixel-plurimedia.fr                                          */
/*      web : https://pixel-plurimedia.fr                                            */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace TheliaRedirectUrl\Loop;

use Propel\Runtime\ActiveQuery\Criteria;

use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Type\TypeCollection;
use Thelia\Type\EnumListType;

use TheliaRedirectUrl\Model\RedirectUrlQuery;

/**
 * Class RedirectUrlLoop
 * @package TheliaRedirectUrl\Loop
 * @author Thierry Caresmel <thierry@pixel-plurimedia.fr>
 */
class RedirectUrlLoop extends BaseLoop implements PropelSearchLoopInterface
{
    protected $timestampable = true;

    /**
     * Definition of loop arguments
     *
     * @return \Thelia\Core\Template\Loop\Argument\ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id'),
            /*
            new Argument('order', new TypeCollection(
                    new EnumListType([
                        'id', 'id_reverse', 'given_id',
                        'alpha', 'alpha_reverse',
                        'random'
                    ])
            ), 'id'),*/
        );
    }

    /**
     * this method returns a Propel ModelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $search = RedirectUrlQuery::create();

        if (null != $id = $this->getId()) $search->filterById($id);
        /*
        $orders  = $this->getOrder();
        foreach ($orders as $order) {
            switch ($order) {
                case "id":
                    $search->orderById(Criteria::ASC);
                    break;
                case "id_reverse":
                    $search->orderById(Criteria::DESC);
                    break;
                case "alpha":
                    $search->addAscendingOrderByColumn('i18n_TITLE');
                    break;
                case "alpha_reverse":
                    $search->addDescendingOrderByColumn('i18n_TITLE');
                    break;
                case "given_id":
                    if (null === $id) {
                        throw new \InvalidArgumentException('Given_id order cannot be set without `id` argument');
                    }
                    foreach ($id as $singleId) {
                        $givenIdMatched = 'given_id_matched_' . $singleId;
                        $search->withColumn(ContentTableMap::ID . "='$singleId'", $givenIdMatched);
                        $search->orderBy($givenIdMatched, Criteria::DESC);
                    }
                    break;
                case "random":
                    $search->clearOrderByColumns();
                    $search->addAscendingOrderByColumn('RAND()');
                    break(2);
                case "position":
                    $search->addAscendingOrderByColumn('position');
                    break;
                case "position_reverse":
                    $search->addDescendingOrderByColumn('position');
                    break;
            }
        }
        */

        $search->groupById();

        return $search;
    }

    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        /** @var RedirectUrl $redirectUrl */
        foreach ($loopResult->getResultDataCollection() as $redirectUrl) {
            $loopResultRow = new LoopResultRow($redirectUrl);

            $loopResultRow
                ->set("ID", $redirectUrl->getId())
                ->set("URL", $redirectUrl->getUrl())
                ->set("TEMP_REDIRECT", $redirectUrl->getTempRedirect())
                ->set("REDIRECT", $redirectUrl->getRedirect())
            ;
            $this->addOutputFields($loopResultRow, $redirectUrl);

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
