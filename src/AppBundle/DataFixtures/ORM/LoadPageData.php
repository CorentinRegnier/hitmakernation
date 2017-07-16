<?php

/*
 * This file is part of the ValepImmo Project.
 *
 * (c) Corentin Régnier <corentin.regnier59@gmail.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Page;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadPageData
 */
class LoadPageData extends AbstractFixture implements OrderedFixtureInterface
{

    private $pages = [
        [
            'title'   => 'Conditions générales de vente',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur ultrices risus augue, ac mollis ligula gravida eget. Quisque eleifend elementum sem. Nullam congue ligula quis ipsum viverra iaculis. Proin a interdum erat. Vivamus libero urna, venenatis et porttitor vel, facilisis sed ante. Cras massa nisl, vulputate ut arcu eu, eleifend semper ipsum. Curabitur ipsum massa, dapibus et risus ut, lobortis ultricies nulla. Morbi venenatis magna in ornare tempor. 
            Nunc commodo, tellus vel aliquam pharetra, sem odio consequat nunc, id venenatis ex neque quis leo. Interdum et malesuada fames ac ante ipsum primis in faucibus. Maecenas dignissim eros pharetra, molestie ex eget, fringilla arcu. Sed gravida nisl sapien, quis tempor magna elementum id. In hac habitasse platea dictumst. Etiam et ante quis lacus gravida imperdiet. Aenean at massa vel dolor pulvinar egestas. Vivamus vitae mauris aliquam, aliquet sem blandit, finibus eros. Mauris vitae tellus tempor, auctor leo eget, aliquet arcu. Sed dignissim a felis condimentum sollicitudin.
            Duis nec diam commodo, pellentesque odio scelerisque, mollis enim. Phasellus maximus arcu est, et pulvinar purus eleifend facilisis. Nullam interdum pharetra sodales. Nunc a diam nec quam interdum consectetur. Ut arcu sapien, mattis et turpis sit amet, condimentum rhoncus odio. Pellentesque fermentum sapien a gravida accumsan. Proin porta sem quis dolor malesuada auctor. Sed sodales ultrices nisi, ac malesuada mauris mattis at. Ut ac vulputate dui, vitae vestibulum nibh. Vivamus consectetur maximus lacus, ut ultrices eros rhoncus dictum. Curabitur purus risus, placerat ut quam in, ultricies finibus lacus.',
        ],
        [
            'title'   => 'Mentions légales',
            'content' => 'Phasellus dignissim lacus tellus. Quisque vitae viverra augue. Vestibulum ornare commodo sapien eu vestibulum. Phasellus fermentum malesuada quam, eu mollis nulla porttitor nec. Nunc eget ex pellentesque, gravida libero nec, fringilla justo. Ut at nulla lacinia, imperdiet eros at, ultrices mi. Fusce eleifend semper metus, et volutpat mi fermentum in. Nam lacus quam, gravida id posuere fermentum, gravida a magna. Mauris eget magna a ex vestibulum lacinia nec volutpat dolor. Nullam eget urna vitae dui auctor dapibus. Nullam accumsan nisi magna, pulvinar accumsan massa vestibulum a.
            Duis vel orci eget sapien ornare porta. Integer congue dignissim diam, at laoreet mauris laoreet nec. Duis nec nisi enim. Donec a nibh eros. Nulla facilisi. Aenean ac hendrerit metus, sed suscipit dui. Fusce non ante placerat, consectetur nunc non, interdum erat. Quisque sit amet diam porttitor, sollicitudin elit a, aliquam ex. Pellentesque sodales nisl ut sapien bibendum, nec tristique ligula luctus. Morbi hendrerit metus ac elit euismod suscipit. In in dapibus elit.
            Maecenas in nisl tempor, dictum sapien ut, tristique velit. Nulla pellentesque nisl nec metus fermentum accumsan. Curabitur rhoncus tortor sem, eu lobortis enim congue rutrum. Mauris viverra aliquet dui, eu maximus augue. In commodo faucibus lacinia. Aenean rutrum est non neque dignissim lobortis. Aliquam eget mi fermentum, fringilla lectus at, maximus nulla. Phasellus sit amet lobortis sem. Curabitur non ipsum enim. Donec purus dui, sollicitudin a dictum quis, interdum vel velit. Suspendisse cursus in odio rhoncus vehicula. Quisque laoreet ex vitae velit scelerisque, nec tristique augue tincidunt. Phasellus viverra magna vel lectus egestas, vitae posuere lacus mattis. Mauris ornare malesuada tincidunt.',
        ],
        [
            'title'   => 'Qui nous sommes',
            'content' => 'Phasellus dignissim lacus tellus. Quisque vitae viverra augue. Vestibulum ornare commodo sapien eu vestibulum. Phasellus fermentum malesuada quam, eu mollis nulla porttitor nec. Nunc eget ex pellentesque, gravida libero nec, fringilla justo. Ut at nulla lacinia, imperdiet eros at, ultrices mi. Fusce eleifend semper metus, et volutpat mi fermentum in. Nam lacus quam, gravida id posuere fermentum, gravida a magna. Mauris eget magna a ex vestibulum lacinia nec volutpat dolor. Nullam eget urna vitae dui auctor dapibus. Nullam accumsan nisi magna, pulvinar accumsan massa vestibulum a.
            Duis vel orci eget sapien ornare porta. Integer congue dignissim diam, at laoreet mauris laoreet nec. Duis nec nisi enim. Donec a nibh eros. Nulla facilisi. Aenean ac hendrerit metus, sed suscipit dui. Fusce non ante placerat, consectetur nunc non, interdum erat. Quisque sit amet diam porttitor, sollicitudin elit a, aliquam ex. Pellentesque sodales nisl ut sapien bibendum, nec tristique ligula luctus. Morbi hendrerit metus ac elit euismod suscipit. In in dapibus elit.
            Maecenas in nisl tempor, dictum sapien ut, tristique velit. Nulla pellentesque nisl nec metus fermentum accumsan. Curabitur rhoncus tortor sem, eu lobortis enim congue rutrum. Mauris viverra aliquet dui, eu maximus augue. In commodo faucibus lacinia. Aenean rutrum est non neque dignissim lobortis. Aliquam eget mi fermentum, fringilla lectus at, maximus nulla. Phasellus sit amet lobortis sem. Curabitur non ipsum enim. Donec purus dui, sollicitudin a dictum quis, interdum vel velit. Suspendisse cursus in odio rhoncus vehicula. Quisque laoreet ex vitae velit scelerisque, nec tristique augue tincidunt. Phasellus viverra magna vel lectus egestas, vitae posuere lacus mattis. Mauris ornare malesuada tincidunt.',
        ],
        [
            'title'   => 'Crédits',
            'content' => 'Aenean maximus, nulla consequat auctor tincidunt, purus purus rutrum neque, sit amet blandit libero libero nec sapien. Vivamus ac tristique purus, sit amet ullamcorper urna. Vivamus ac consequat dui. Duis dapibus lorem quis enim tincidunt, nec sagittis nulla lacinia. Proin blandit sodales leo, non egestas dui malesuada a. Fusce consequat ex quis nisl mattis tristique. Etiam laoreet ex elit, vel vehicula nisi tincidunt dignissim.
            Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Quisque dignissim libero vitae est dapibus egestas. Vestibulum sagittis, ligula eget viverra semper, lacus tellus pellentesque lacus, id efficitur erat massa quis elit. Duis vel nulla dapibus tellus auctor blandit a quis orci. Nullam volutpat nibh magna, eget egestas sem euismod in. Nam mollis eu sem vel maximus. In viverra dignissim augue id accumsan.
            Integer rutrum pretium justo, id tempor nisi commodo non. Phasellus at neque in lectus pretium ultricies id at massa. Proin rutrum sit amet mi non mollis. Aenean dignissim consequat nulla. Aliquam sit amet rhoncus augue, non sagittis odio. Proin leo nulla, maximus vitae bibendum ac, luctus vitae ipsum. Aliquam at urna sit amet leo fermentum varius quis in risus. Fusce dictum felis nec arcu mattis porttitor. Donec placerat pulvinar risus in fringilla. Praesent elementum ex eu risus varius consectetur. Vestibulum vitae commodo dolor.',
        ],
        [
            'title'   => 'Présentation',
            'content' => 'Aenean maximus, nulla consequat auctor tincidunt, purus purus rutrum neque, sit amet blandit libero libero nec sapien. Vivamus ac tristique purus, sit amet ullamcorper urna. Vivamus ac consequat dui. Duis dapibus lorem quis enim tincidunt, nec sagittis nulla lacinia. Proin blandit sodales leo, non egestas dui malesuada a. Fusce consequat ex quis nisl mattis tristique. Etiam laoreet ex elit, vel vehicula nisi tincidunt dignissim.
            Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Quisque dignissim libero vitae est dapibus egestas. Vestibulum sagittis, ligula eget viverra semper, lacus tellus pellentesque lacus, id efficitur erat massa quis elit. Duis vel nulla dapibus tellus auctor blandit a quis orci. Nullam volutpat nibh magna, eget egestas sem euismod in. Nam mollis eu sem vel maximus. In viverra dignissim augue id accumsan.
            Integer rutrum pretium justo, id tempor nisi commodo non. Phasellus at neque in lectus pretium ultricies id at massa. Proin rutrum sit amet mi non mollis. Aenean dignissim consequat nulla. Aliquam sit amet rhoncus augue, non sagittis odio. Proin leo nulla, maximus vitae bibendum ac, luctus vitae ipsum. Aliquam at urna sit amet leo fermentum varius quis in risus. Fusce dictum felis nec arcu mattis porttitor. Donec placerat pulvinar risus in fringilla. Praesent elementum ex eu risus varius consectetur. Vestibulum vitae commodo dolor.',
        ],
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->pages as $i => $data) {
            $page = new Page();
            $page
                ->setTitle($data['title'])
                ->setContent($data['content']);
            $this->addReference('page-'.$i, $page);
            $manager->persist($page);
        }
        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
