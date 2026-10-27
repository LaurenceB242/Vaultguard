<?php

namespace App\Form;

use App\Entity\Credential;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CredentialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom du service / Site (ex: Google)'
            ])
            ->add('login', TextType::class, [
                'label' => 'Identifiant / Email'
            ])
            ->add('encryptedPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false, // Important : ce champ n'est pas lié directement tel quel, on le traite dans le contrôleur
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Credential::class,
        ]);
    }
}