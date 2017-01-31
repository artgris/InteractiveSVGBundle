<?php


namespace Artgris\Bundle\InteractiveSVGBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;

/**
 * @author Arthur Gribet <a.gribet@gmail.com>
 */
class SVGType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('svg', FileType::class, [
                'label' => 'Select an SVG File to Upload ',
                'constraints' => [
                    new File([
                        "mimeTypes" => ["image/svg+xml"],
                        "mimeTypesMessage" => "Please upload a valid SVG"
                    ])
                ]
            ]);
    }
}