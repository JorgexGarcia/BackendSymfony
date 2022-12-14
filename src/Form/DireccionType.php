<?php

namespace App\Form;

use App\Entity\Cliente;
use App\Entity\Direccion;
use App\Entity\Municipios;
use App\Entity\Provincias;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DireccionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Direccion::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('calle', TextType::class)
            ->add('numero', TextType::class)
            ->add('puertaPisoEscalera', TextType::class)
            ->add('codPostal', TextType::class)
            ->add('cliente', EntityType::class, ['class'=>Cliente::class])
            ->add('municipio', EntityType::class, ['class'=>Municipios::class])
            ->add('provincia', EntityType::class, ['class'=>Provincias::class])
        ;
    }

    //Quitar tener que añadir un padre
    public function getBlockPrefix()
    {
        return '';
    }

    //Quitar tener que añadir un padre
    public function getName()
    {
        return '';
    }
}
