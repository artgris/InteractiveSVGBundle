<?php

namespace Artgris\Bundle\InteractiveSVGBundle\Form;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 *
 * @author Arthur Gribet <a.gribet@gmail.com>
 */
class NodeType extends AbstractType
{


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', TextType::class, [
                'label' => 'id',
                'disabled' => true,
            ])
            ->add('title', TextType::class, [
                'label' => 'title',
                'required' => false
            ]);

        $builder->addEventListener(FormEvents::POST_SET_DATA, function ($event) {

            /** @var FormEvent $event */
            $nodeId = $event->getData()->getId();
            $form = $event->getForm();

            $form->add('colorCode', TextType::class, [
                'label' => 'color code',
                'required' => false,
                'attr' => [
                    'data-id' => $nodeId,
                    'class' => 'bird_list jsfill jscolor {required:false}'
                ]
            ]);
            $form->add('strokeCode', TextType::class, [
                'label' => 'color code',
                'required' => false,
                'attr' => [
                    'data-id' => $nodeId,
                    'class' => 'bird_list jsstroke jscolor {required:false}'
                ]
            ]);

        });
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Artgris\Bundle\InteractiveSVGBundle\Entity\Node',
        ]);
    }

}