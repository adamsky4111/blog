<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\ORM\Doctrine\Populator;


class PostFixture extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $generator = \Faker\Factory::create('pl_PL');

        $populator = new Populator($generator, $manager);
        $populator->addEntity(Post::class, 5000, [
            'title' => $generator->text(50) ,
            'description' => $generator->text(100),
            'body' => $generator->text(2000),
            'img' => function() use ($generator) { return 'https://picsum.photos/1000/700.jpg'; },
        ]);
        $populator->execute();
        $manager->flush();
    }
}