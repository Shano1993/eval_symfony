<?php

namespace App\Form;

use App\Entity\Article;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Article title"
            ])

            ->add('content', CKEditorType::class, [
                'label' => "Article content",
            ])

            ->add('cover', FileType::class, [
                'label' => 'Article cover',
                'mapped' => false,
                'constraints' => [
                    new File([
                        'maxSize' => "8M",
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ]
                    ])
                ]
            ])

            ->add('isPublish', CheckboxType::class, [
                'label' => "Publish ?",
                'required' => false,
            ])

            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
