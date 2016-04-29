<?php
/**
 * Created by PhpStorm.
 * User: tompradat
 * Date: 21/04/2016
 * Time: 11:53
 */

namespace TheliaRedirectUrl\Form;

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
                    new Assert\NotBlank
                ]
            ))
            ->add('temp_redirect', 'text', array(
                'label' => Translator::getInstance()->trans('Temporary Redirection', [], TheliaRedirectUrl::DOMAIN_NAME),
                'label_attr' => ['for' => 'temp_redirect']
            ))
            ->add('redirect', 'text', array(
                'label' => Translator::getInstance()->trans('Redirection', [], TheliaRedirectUrl::DOMAIN_NAME),
                'label_attr' => ['for' => 'redirect'],
                'required' => true,
                'constraints' => [
                    new Assert\NotBlank
                ]
            ))
        ;
    }
}