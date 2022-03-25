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

namespace TheliaRedirectUrl\Form;

use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints;
use TheliaRedirectUrl\TheliaRedirectUrl;

/**
 * Class RedirectUrlUpdate
 * @package TheliaRedirectUrl\Form
 * @author Thierry Caresmel <thierry@pixel-plurimedia.fr>
 */
class RedirectUrlUpdate extends RedirectUrlCreate
{
    public function getName()
    {
        return 'redirect_url_update';
    }

    public function buildForm()
    {
        parent::buildForm();

        $this->formBuilder
            ->add('id', Type\HiddenType::class, [
                  'constraints' => [
                      new Constraints\NotNull()
                  ],
                  'required' => true,
            ])
        ;
    }
}
