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
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AdminUserType
 */
class AdminUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName', TextType::class, [
                'label'    => 'admin.form.user.last_name',
                'required' => true,
            ])
            ->add('firstName', TextType::class, [
                'label'    => 'admin.form.user.first_name',
                'required' => true,
            ])
            ->add('address', TextType::class, [
                'label'    => 'admin.form.user.address',
                'required' => true,
            ])
            ->add('zipCode', TextType::class, [
                'label'    => 'admin.form.user.zip_code',
                'required' => true,
            ])
            ->add('city', TextType::class, [
                'label'    => 'admin.form.user.city',
                'required' => true,
            ])
            ->add('country', TextType::class, [
                'label'    => 'admin.form.user.country',
                'required' => true,
            ])
            ->add('phone', TextType::class, [
                'label'    => 'admin.form.user.phone',
                'required' => true,
            ])
            ->add('username', TextType::class, [
                'label'    => 'admin.form.user.username',
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label'    => 'admin.form.user.email',
                'required' => true,
            ])
            ->add('enabled', CheckboxType::class, [
                'label'    => 'admin.form.enabled',
                'required' => false,
            ])
            ->add('birthdayDate', BirthdayType::class, [
                'label'    => 'app.form.registration.birthday',
                'widget'   => 'single_text',
                'format'   => 'dd/MM/yyyy',
                'attr'     => ['class' => 'js-datepicker'],
                'required' => false,
            ])
            ->add('roles', ChoiceType::class, [
                'label'    => 'admin.form.user.role.label',
                'multiple' => true,
                'choices'  => User::getAvailableAdminRoles(),
                'required' => true,
            ]);
        if ($options['isCreation'] === true) {
            $builder
                ->add('plainPassword', RepeatedType::class, [
                    'type'           => PasswordType::class,
                    'first_options'  => ['label' => 'admin.form.user.password'],
                    'second_options' => ['label' => 'admin.form.user.repeated'],
                    'required'       => true,
                ]);
        }
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'isCreation' => null,
        ]);
    }
}
