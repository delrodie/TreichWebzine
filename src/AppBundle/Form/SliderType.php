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

class SliderType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le titre du slider'
                ]
            ])
            ->add('contenu', TextareaType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Resumé du slider',
                    'style' => 'width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;'
                ]
            ])
            ->add('lien', TextType::class,[
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le lien de l\'article correspondant a ce slide'
                ],
                'required' => false
            ])
            ->add('datedeb', TextType::class,[
                'attr' => [
                    'class' => 'form-control pull-right',
                    'placeholder' => 'La date debut de publication'
                ]
            ])
            ->add('datefin', TextType::class,[
                'attr' => [
                    'class' => 'form-control pull-right',
                    'placeholder' => 'La date fin de publication'
                ]
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
                'class' => 'AppBundle:TypeSlider',
                'query_builder' => function(EntityRepository $er){
                    return $er->listActif();
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
            'data_class' => 'AppBundle\Entity\Slider'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_slider';
    }


}
