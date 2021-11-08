<?php

namespace App\Form;

use App\Entity\Crud;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class CrudType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('first_name')
            ->add('last_name')
            ->add('email',EmailType::class,[
                'attr' => ['type' => 'email'],
            ])
            ->add('gender', ChoiceType::class, [
            'choices'  => [
                'Male' => 'Male',
                'Female' => 'Female',
            ]])
            ->add('password',PasswordType::class,[
                'attr' => ['type' => 'password'],
            ]);
    
    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Crud::class,
        ]);
    }
}
