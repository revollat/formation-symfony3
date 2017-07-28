<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\HttpFoundation\File\File;

class LivreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('couverture', FileType::class,  ['label' => 'Illustration de couverture'])
        ;

        $builder->add('critiques', CollectionType::class, array(
            'entry_type' => CritiqueType::class,
            'allow_add'  => true,
            //'allow_delete' => true,
            'by_reference' => false,
            //'label' => false
        ));
        
        $builder->get('couverture')
            ->addModelTransformer(new CallbackTransformer(
                function ($image_name) {
                    if($image_name)
                    {
                        return new File('/var/www/symfony/web/uploads/couvertures/'.$image_name);
                    }
                    return null;
                },
                function ($image_file) {
                    return $image_file;
                }
            ))
        ;
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Livre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_livre';
    }


}
