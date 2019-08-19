<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => 'Titre'])
            ->add('description')
            ->add('surface', null, ['label' => 'Surface (en m²)'])
            ->add('rooms', null, ['label' => 'Nombre de pièces'])
            ->add('bedrooms', null, ['label' => 'Nombre de chambres'])
            ->add('floor', null, ['label' => 'Étage'])
            ->add('price', null, ['label' => 'Prix (€)'])
            ->add('heat', ChoiceType::class, ['label' => 'Chauffage', 'choices' => array_flip(Property::HEAT)])
            ->add('options', EntityType::class, ['class' => Option::class, 'choice_label' => 'name', 'multiple' => true,
            'required' => false])
            ->add('imageFile', FileType::class, ['required' => false, 'label' => 'Photo du bien'])
            ->add('city', null, ['label' => 'Ville'])
            ->add('address', null, ['label' => 'Adresse'])
            ->add('postal_code', null, ['label' => 'Code postal'])
            ->add('sold', null, ['label' => 'Vendu'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }

}
