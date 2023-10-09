<?php 
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('adresseLivraison', TextType::class, [
            'label' => 'Adresse de livraison',
            'attr' => ['class' => 'form-control'],
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Veuillez renseigner votre adresse de livraison.',
                ]),
                new Assert\Length([
                    'max' => 255,
                    'maxMessage' => 'L\'adresse de livraison ne peut pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('codePostalLivraison', TextType::class, [
            'label' => 'Code postal (Livraison)',
            'attr' => ['class' => 'form-control'],
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Veuillez renseigner le code postal de livraison.',
                ]),
                new Assert\Regex([
                    'pattern' => '/^[0-9]{5}$/',
                    'message' => 'Veuillez renseigner un code postal valide.',
                ]),
            ],
        ])
        ->add('villeLivraison', TextType::class, [
            'label' => 'Ville (Livraison)',
            'attr' => ['class' => 'form-control'],
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Veuillez renseigner la ville de livraison.',
                ]),
                new Assert\Length([
                    'max' => 255,
                    'maxMessage' => 'Le nom de la ville ne peut pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('adresseFacturation', TextType::class, [
            'label' => 'Adresse de facturation',
            'attr' => ['class' => 'form-control'],
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Veuillez renseigner votre adresse de facturation.',
                ]),
                new Assert\Length([
                    'max' => 255,
                    'maxMessage' => 'L\'adresse de facturation ne peut pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
        ->add('codePostalFacturation', TextType::class, [
            'label' => 'Code postal (Facturation)',
            'attr' => ['class' => 'form-control'],
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Veuillez renseigner le code postal de facturation.',
                ]),
                new Assert\Regex([
                    'pattern' => '/^[0-9]{5}$/',
                    'message' => 'Veuillez renseigner un code postal valide.',
                ]),
            ],
        ])
        ->add('villeFacturation', TextType::class, [
            'label' => 'Ville (Facturation)',
            'attr' => ['class' => 'form-control'],
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Veuillez renseigner la ville de facturation.',
                ]),
                new Assert\Length([
                    'max' => 255,
                    'maxMessage' => 'Le nom de la ville ne peut pas dépasser {{ limit }} caractères.',
                ]),
            ],
        ])
            ->add('modePaiement', ChoiceType::class, [
                'label' => 'Mode de paiement',
                'choices'  => [
                    'Carte bancaire' => 'carte_bancaire',
                    'PayPal' => 'paypal',
                    'Virement bancaire' => 'virement_bancaire', 
                ],
                'attr' => ['class' => 'form-select'],
            ])
            ->add('accepterCGU', CheckboxType::class, [
                'label'    => 'J\'accepte les conditions générales d\'utilisation',
                'required' => true,
                'attr' => ['class' => 'form-check-input'],
                'constraints' => [
                    new Assert\IsTrue([
                        'message' => 'Vous devez accepter les CGU pour passer la commande.',
                    ]),
                ],
            ])
        ;
    }

}