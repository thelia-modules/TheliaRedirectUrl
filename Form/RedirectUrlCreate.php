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
use Symfony\Component\Validator\Context\ExecutionContextInterface;

use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;

use TheliaRedirectUrl\TheliaRedirectUrl;

class RedirectUrlCreate extends BaseForm
{
    public function getName()
    {
        return 'redirect_url_create';
    }

    public function buildForm()
    {
        $this->formBuilder
            ->add('url', Type\TextType::class, [
                  'constraints' => [
                      new Constraints\NotBlank(),
                      new Constraints\Callback(array("methods" => array(
                          array($this, "isValidUrl"),
                      ))),
                  ],
                  'label' => Translator::getInstance()->trans('Url to redirect', [], TheliaRedirectUrl::DOMAIN_NAME),
                  'label_attr' => ['for' => 'url'],
                  'required' => true,
            ])
            ->add('temp_redirect', Type\TextType::class, [
                  'constraints' => [
                      new Constraints\Callback(array("methods" => array(
                          array($this, "isValidUrl"),
                      ))),
                  ],
                  'label' => Translator::getInstance()->trans('Temporary Redirection', [], TheliaRedirectUrl::DOMAIN_NAME),
                  'label_attr' => ['for' => 'temp_redirect'],
            ])
            ->add('redirect', Type\TextType::class, [
                  'constraints' => [
                      new Constraints\NotBlank(),
                      new Constraints\Callback(array("methods" => array(
                          array($this, "isValidUrl"),
                      ))),
                  ],
                  'label' => Translator::getInstance()->trans('Redirection', [], TheliaRedirectUrl::DOMAIN_NAME),
                  'label_attr' => ['for' => 'redirect'],
                  'required' => true,
            ])
        ;
    }

    public function isValidUrl($value, ExecutionContextInterface $context)
    {
        if (! TheliaRedirectUrl::isValidUrl($value) && $value) {
            $context->addViolation(
                Translator::getInstance()->trans("The url format is not valid")
            );
        }
    }
}
