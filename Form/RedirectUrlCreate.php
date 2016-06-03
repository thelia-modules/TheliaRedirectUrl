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

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Thelia\Core\Translation\Translator;
use Thelia\Form\BaseForm;
use Symfony\Component\Validator\Constraints as Assert;
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
            ->add('url', 'text', array(
                'label' => Translator::getInstance()->trans('Url to redirect', [], TheliaRedirectUrl::DOMAIN_NAME),
                'label_attr' => ['for' => 'url'],
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Callback(array("methods" => array(
                        array($this, "isValidUrl"),
                    ))),
                ]
            ))
            ->add('temp_redirect', 'text', array(
                'label' => Translator::getInstance()->trans('Temporary Redirection', [], TheliaRedirectUrl::DOMAIN_NAME),
                'label_attr' => ['for' => 'temp_redirect'],
                'constraints' => [
                    new Assert\Callback(array("methods" => array(
                        array($this, "isValidUrl"),
                    ))),
                ]
            ))
            ->add('redirect', 'text', array(
                'label' => Translator::getInstance()->trans('Redirection', [], TheliaRedirectUrl::DOMAIN_NAME),
                'label_attr' => ['for' => 'redirect'],
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Callback(array("methods" => array(
                        array($this, "isValidUrl"),
                    ))),
                ]
            ))
        ;
    }

    public function isValidUrl($value, ExecutionContextInterface $context)
    {
        if (!TheliaRedirectUrl::isValidUrl($value) && $value) {
            $context->addViolation(
                Translator::getInstance()->trans(
                    "The url format is not valid"
                )
            );
        }
    }
}