<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertificateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'partnerId',
                TextType::class,
                [
                    'required' => true,
                ]
            )->add(
                'uploadFile',
                FileType::class,
                [
                    'required' => true,
                ]
            )->add(
                'validFrom',
                HiddenType::class,
                [
                    'required' => true,
                ]
            )->add(
                'validUntil',
                HiddenType::class,
                [
                    'required' => true,
                ]
            )->add(
                'email',
                HiddenType::class,
                [
                    'required' => true,
                ]
            )->add(
                'certificateFile',
                HiddenType::class,
                [
                    'required' => true,
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
