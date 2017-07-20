<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ContactType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
        
            ->add('email', EmailType::class, [
                'label' => 'Votre adresse email',
                'attr' => [
                    'placeholder' => 'Ex : monnom@xyzmail.fr'
                ],
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => "Le champ email ne doit par être vide."
                    ]),
                    new Assert\Email([
                        'message' => "L'adresse email n'est pas correcte"
                    ])
                ]
            ])
            
            ->add('sujet', TextType::class, [
                'label' => 'Sujet',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'Merci de renseigner un sujet.'
                    ]),
                ]
            ])
            
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => "Vous n'avez pas rédigé de message."
                    ]),
                ]
            ])
            
            ->add('valider', SubmitType::class, [
                'label' => 'Envoyer le message'
            ])
            
        ;
        
    }

}
