<?php
namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Choice;

class PostType extends AbstractType
{
    public function __construct()
    {

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('body')
            ->add('img', FileType::class, [
                'label'  => 'Img (PNG file)',
                ])
            ->add('tags', CollectionType::class, [
                'entry_type'    => TagType::class,
                'entry_options' => ['label' => false],
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
            ])
            ->add('categories', EntityType::class, [
                    'class' => Category::class,
                    'query_builder' =>function(CategoryRepository $categoryRepository) {
                        return $categoryRepository->createQueryBuilder('c')
                            ->orderBy('c.name', 'ASC');
                    },
                    'expanded' => false,
                    'multiple' => true,
                    'choice_label' => 'name',
                    ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
