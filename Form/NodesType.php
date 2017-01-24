<?php

namespace Artgris\Bundle\InteractiveSVGBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Arthur Gribet <a.gribet@gmail.com>
 */
class NodesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("viewBoxMinx", NumberType::class, [
                'label' => "min-x",
                'attr' => [
                    'class' => "viewbox"
                ]
            ])
            ->add("viewBoxMiny", NumberType::class, [
                'label' => "min-y",
                'attr' => [
                    'class' => "viewbox"
                ]
            ])
            ->add("viewBoxWidth", NumberType::class, [
                'label' => "width",
                'attr' => [
                    'class' => "viewbox"
                ]
            ])
            ->add("viewBoxHeight", NumberType::class, [
                'label' => "height",
                'attr' => [
                    'class' => "viewbox"
                ]
            ])
            ->add("dataHoverColor", TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'jscolor {required:true}'
                ]
            ])
            ->add('nodes', CollectionType::class, [
                'entry_type' => NodeType::class
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Artgris\Bundle\InteractiveSVGBundle\Entity\Nodes',
        ]);
    }
}