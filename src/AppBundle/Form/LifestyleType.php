<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class LifestyleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class,[
                'attr' => [
                    'class'=> 'form-control',
                    'placeholder' => 'Le titre du lifestyle'
                ]
            ])
            ->add('contenu', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Le contenu du lifestyle",
                    'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;'
                ]
            ])
            //->add('resume')
            ->add('tags', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => "Les mots clés",
                    'data-role' => 'tagsinput',
                ],
                'required' => false,
            ])
            ->add('statut', CheckboxType::class,[
                'required' => false
            ])
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'label' => '.',
            ])
            //->add('imageSize')->add('updatedAt')->add('slug')->add('publiePar')->add('modifiePar')->add('publieLe')->add('modifieLe')
            ->add('type', null, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'selectionnez le type'
                ],
                'class' => 'AppBundle:TypeLifestyle',
                'query_builder' => function(EntityRepository $er){
                    return $er->findAllAscActif();
                },
                'choice_label' => 'libelle'
            ])
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Lifestyle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_lifestyle';
    }


}
