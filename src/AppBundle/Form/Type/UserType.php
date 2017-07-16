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

use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class UserType
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('civility', ChoiceType::class, [
                'label'    => 'app.form.registration.gender',
                'multiple' => false,
                'expanded' => false,
                'choices'  => User::getAvailableCivilities(),
            ])
            ->add('lastName', TextType::class, [
                'label' => 'app.form.registration.last_name',
            ])
            ->add('firstName', TextType::class, [
                'label' => 'app.form.registration.first_name',
            ])
            ->add('birthdayDate', BirthdayType::class, [
                'label'    => 'app.form.registration.birthday',
                'widget'   => 'single_text',
                'format'   => 'dd/MM/yyyy',
                'attr'     => ['class' => 'js-datepicker'],
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'label'    => 'app.form.registration.address',
                'required' => false,
            ])
            ->add('zipCode', IntegerType::class, [
                'label'    => 'app.form.registration.zip_code',
                'required' => false,
                'attr'     => [
                    'max' => 5,
                ],
            ])
            ->add('city', TextType::class, [
                'label'    => 'app.form.registration.city',
                'required' => false,
            ])
            ->add('country', TextType::class, [
                'label'    => 'app.form.registration.country',
                'required' => false,
            ])
            ->add('phone', TextType::class, [
                'label'    => 'app.form.registration.phone',
                'required' => false,
            ])
            ->add('generalCondition', CheckboxType::class, [
                'label' => 'app.form.registration.general_condition',
            ]);
    }
}
