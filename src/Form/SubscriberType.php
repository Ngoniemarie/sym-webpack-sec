<?php

namespace App\Form;

use App\Entity\Subscriber;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscriberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('photo',FileType::class)
            ->add('password',TextType::class)
            ->add('verifiedPassword',TextType::class)
            ->add('email',TextType::class)
            ->add('age',IntegerType::class)
            ->add('address',TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Subscriber::class,
        ]);
    }
}
