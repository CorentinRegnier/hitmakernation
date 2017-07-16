<?php

/*
 * This file is part of the ValepImmo Project.
 *
 * (c) Corentin Régnier <corentin.regnier59@gmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class PageType
 */
class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label'    => 'admin.form.page.title',
                'required' => true,
            ])
            ->add('metaTitle', TextType::class, [
                'label'    => 'admin.form.page.meta_title',
                'required' => false,
            ])
            ->add('metaDescription', TextType::class, [
                'label'    => 'admin.form.page.meta_description',
                'required' => false,
            ])
            ->add('content', TextareaType::class, [
                'label'    => 'admin.form.page.content',
                'attr'     => ['class' => 'wysi-html-editor'],
                'required' => false,
            ]);
    }
}
