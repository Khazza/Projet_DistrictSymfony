<?php
namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Plat;
use App\Entity\Commande;
use App\Entity\Detail;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Global1 extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Tableau des libellés de catégories
        $categoriesLibelles = [
            'Entrées' => [
                'Salade César' => 'Salade croquante à base de laitue romaine, garnie de croûtons maison, de parmesan râpé et arrosée d\'une sauce César crémeuse.',
                'Velouté de potiron' => 'Soupe veloutée et riche de potiron rôti, garnie de graines de courge torréfiées et d\'un filet de crème fraîche.',
                'Bruschetta' => 'Tranches de baguette grillée garnies de tomates fraîches, de basilic, d\'ail et d\'huile d\'olive extra vierge.',
                'Houmous' => 'Dip crémeux à base de pois chiches, de tahini, d\'ail, de jus de citron et d\'huile d\'olive. Parfait pour tremper les légumes ou le pain pita.',
                'Guacamole' => 'Guacamole frais fait avec des avocats mûrs, du jus de citron vert, de la coriandre, des oignons rouges, des tomates et un soupçon de piment jalapeno.',
                'Tartelettes aux oignons' => 'Tartelettes croustillantes garnies d\'oignons caramélisés doux et d\'une touche de thym frais.',
                'Salade grecque' => 'Salade fraîche composée de tomates mûres, de concombre croquant, d\'oignons rouges, de poivrons, d\'olives kalamata et de fromage feta.',
                'Tapenade' => 'Dip savoureux et riche à base d\'olives noires, de câpres, d\'anchois et d\'huile d\'olive. Parfait pour être tartiné sur du pain grillé.',
                'Caviar d\'aubergine' => 'Dip crémeux d\'aubergines grillées, d\'ail, de jus de citron et de tahini. Servi avec du pain pita chaud.',
                'Tzatziki' => 'Dip rafraîchissant à base de yaourt grec, de concombre, d\'ail, de jus de citron et d\'aneth. Parfait pour les journées d\'été.',
            ],
            'Plats principaux' => [
                'Coq au vin' => 'Un classique de la cuisine française, le coq au vin est un ragoût de poulet cuit lentement dans du vin rouge, avec des champignons, des oignons perlés et des lardons.',
                'Boeuf bourguignon' => 'Un autre classique français, ce ragoût riche est fait avec du bœuf tendre mijoté dans du vin rouge et garni de lardons, de champignons et de carottes.',
                'Cassoulet' => 'Ragoût copieux du sud de la France à base de haricots blancs, de saucisses et de viande de porc.',
                'Blanquette de veau' => 'Un ragoût de veau français traditionnel cuit lentement dans une sauce crémeuse, garni de carottes, d\'oignons et de champignons.',
                'Ratatouille' => 'Un mélange savoureux de légumes d\'été mijotés comme les aubergines, les courgettes, les poivrons et les tomates.',
                'Tartiflette' => 'Un plat réconfortant de la région de la Savoie en France, fait avec des pommes de terre, du reblochon, des lardons et des oignons.',
                'Choucroute' => 'Un plat alsacien de chou fermenté (choucroute), garni de diverses viandes et saucisses.',
                'Paëlla' => 'Un plat espagnol classique à base de riz, de safran, de poulet, de fruits de mer et de divers légumes.',
                'Lasagnes' => 'Pâtes italiennes superposées avec une sauce à la viande riche, une sauce béchamel crémeuse et beaucoup de fromage.',
                'Couscous' => 'Un plat nord-africain de semoule de blé servi avec un ragoût épicé de viande et de légumes.',
            ],
            'Desserts' => [
                'Tarte aux pommes' => 'Tarte croustillante garnie de pommes juteuses et parfumées à la cannelle.',
                'Mousse au chocolat' => 'Dessert aérien et riche au chocolat, parfait pour conclure un repas.',
                'Crème brûlée' => 'Crème à la vanille riche et crémeuse sous une croûte de sucre caramélisé.',
                'Profiteroles' => 'Choux légers garnis de crème glacée et nappés de sauce au chocolat chaud.',
                'Tiramisu' => 'Dessert italien fait de biscuits à la cuillère imbibés de café et superposés avec une crème mascarpone légère, le tout saupoudré de cacao.',
                'Crêpes' => 'Crêpes françaises légères et aériennes, servies avec du sucre, du Nutella, de la confiture ou du sirop d\'érable.',
                'Gâteau au yaourt' => 'Gâteau moelleux et léger, parfumé au citron et à la vanille.',
                'Cheesecake' => 'Gâteau crémeux à base de fromage frais sur une base de biscuits émiettés, souvent garni de coulis de fruits ou de chocolat.',
                'Macarons' => 'Biscuits français délicats et croustillants, garnis d\'une ganache ou d\'une confiture.',
                'Cupcakes' => 'Petits gâteaux moelleux servis avec une variété de glaçages colorés.',
            ],
            'Boissons' => [
                'Coca-Cola' => 'Boisson gazeuse rafraîchissante au goût unique de cola.',
                'Jus d\'orange' => 'Jus pressé à partir d\'oranges fraîches et mûres.',
                'Café' => 'Boisson chaude préparée à partir de grains de café torréfiés.',
                'Thé' => 'Boisson chaude infusée à partir de feuilles de thé.',
                'Chocolat chaud' => 'Boisson chaude et crémeuse à base de chocolat et de lait.',
                'Smoothie' => 'Boisson fraîche et rafraîchissante faite de fruits mixés, souvent avec du yaourt ou du jus.',
                'Mojito' => 'Cocktail rafraîchissant à base de rhum, de menthe, de sucre, de citron vert et d\'eau gazeuse.',
                'Sangria' => 'Boisson espagnole à base de vin rouge, de fruits et souvent d\'un alcool fort comme le brandy.',
                'Jus de pomme' => 'Jus pressé à partir de pommes fraîches et mûres.',
                'Limonade' => 'Boisson rafraîchissante à base de jus de citron, de sucre et d\'eau.',
            ],
            'Soupes' => [
                'Soupe à l\'oignon' => 'Soupe riche à base d\'oignons caramélisés, souvent garnie de fromage et de croûtons.',
                'Bouillabaisse' => 'Soupe de poisson provençale, remplie de différents types de poissons et de fruits de mer.',
                'Gazpacho' => 'Soupe froide à base de tomates, concombres et poivrons, parfaite pour les chaudes journées d\'été.',
                'Soupe de poisson' => 'Bouillon savoureux et réchauffant à base de divers poissons et aromates.',
                'Minestrone' => 'Soupe italienne consistante à base de légumes, souvent accompagnée de pâtes ou de riz.',
                'Soupe miso' => 'Soupe japonaise classique à base de pâte de soja fermentée, souvent garnie de tofu et d\'algues.',
                'Soupe de tomates' => 'Soupe réconfortante à base de tomates mûres, parfois crémeuse et accompagnée de basilic frais.',
                'Soupe de lentilles' => 'Soupe consistante et nourrissante à base de lentilles, carottes et céleri.',
                'Soupe de poissons' => 'Bouillon délicat et savoureux préparé à partir de divers poissons et aromates.',
                'Soupe de poulet' => 'Bouillon réconfortant à base de poulet, de nouilles et de légumes.',
            ],
            'Salades' => [
                'Salade niçoise' => 'Salade composée d\'ingrédients frais tels que tomates, œufs durs, thon, olives noires et anchois.',
                'Salade de chèvre chaud' => 'Salade garnie de fromage de chèvre chaud grillé, souvent servi sur des tranches de baguette.',
                'Salade de pâtes' => 'Salade rafraîchissante à base de pâtes, souvent garnie de légumes, de fromage et de vinaigrette.',
                'Salade de quinoa' => 'Salade saine à base de quinoa, souvent garnie de légumes, de noix et de fromage.',
                'Salade de riz' => 'Salade consistante à base de riz, souvent garnie de légumes, de viande ou de fruits de mer.',
                'Salade Waldorf' => 'Salade croquante à base de pommes, de céleri et de noix, garnie d\'une mayonnaise légère.',
                'Salade César' => 'Salade classique à base de laitue romaine, de croûtons, de parmesan et d\'une vinaigrette crémeuse.',
                'Salade de lentilles' => 'Salade consistante et nutritive à base de lentilles, souvent garnie de légumes et de vinaigrette.',
                'Salade de pommes de terre' => 'Salade savoureuse à base de pommes de terre, souvent garnie de mayonnaise, de moutarde et d\'herbes.',
                'Salade de thon' => 'Salade à base de thon en conserve, souvent garnie de mayonnaise, de céleri et d\'oignons.',
            ],
            'Sandwichs' => [
                'Sandwich club' => 'Sandwich à trois étages généralement composé de poulet ou de dinde, de bacon, de laitue, de tomates et de mayonnaise.',
                'Croque-monsieur' => 'Sandwich grillé français traditionnellement fait avec du jambon et du fromage.',
                'Hot-dog' => 'Saucisse servie dans un pain fendu, généralement garnie de moutarde, de ketchup et/ou de choucroute.',
                'Burger' => 'Sandwich classique composé d\'un ou plusieurs steaks hachés de viande de bœuf placés à l\'intérieur d\'un pain rond ou d\'un petit pain, souvent garni de fromage, laitue, tomate, oignon, cornichons et condiments tels que moutarde, mayonnaise, ketchup, relish et piments.',
                'Sandwich au thon' => 'Sandwich préparé avec du thon en conserve et de la mayonnaise, souvent garni de laitue et de tomate.',
                'Sandwich au jambon' => 'Sandwich préparé avec du jambon tranché, souvent garni de fromage, de laitue et de tomate.',
                'Panini' => 'Sandwich italien grillé, généralement garni de charcuterie, de fromage et parfois de légumes.',
                'Tacos' => 'Pain plat mexicain garni généralement de viande, de poisson ou de légumes, garni de divers condiments.',
                'Gyro' => 'Pain pita grec garni de viande rôtie, souvent du porc ou du poulet, et garni de tzatziki, de tomates et d\'oignons.',
                'Falafel' => 'Boulettes de pois chiches ou de fèves frites servies dans un pain pita et garnies de salade, de légumes marinés et de sauce tahini.'
            ],
            'Pâtes' => [
                'Spaghetti bolognaise' => 'Plat de pâtes italien classique avec une sauce à base de viande hachée, de tomates et d\'herbes.',
                'Carbonara' => 'Plat de pâtes traditionnel italien à base de lardons, d\'œufs, de fromage et de poivre noir.',
                'Lasagnes' => 'Plat italien composé de couches de pâtes alternées avec de la sauce, de la viande et du fromage.',
                'Pâtes alfredo' => 'Plat de pâtes crémeux à base de beurre et de parmesan, souvent garni de poulet ou de crevettes.',
                'Pâtes au pesto' => 'Pâtes enrobées d\'une sauce verte à base de basilic, d\'ail, de pignons de pin, de fromage et d\'huile d\'olive.',
                'Ravioli' => 'Pâtes farcies italiennes, souvent remplies de fromage, de viande ou de légumes.',
                'Gnocchi' => 'Petites boulettes de pâte italiennes à base de pommes de terre, souvent servies avec de la sauce tomate ou du pesto.',
                'Tortellini' => 'Pâtes farcies italiennes en forme de bague, souvent remplies de fromage ou de viande.',
                'Pâtes à la carbonara' => 'Plat de pâtes crémeux à base de lardons, d\'œufs, de fromage et de poivre noir.',
                'Pâtes à la vongole' => 'Plat de pâtes italien traditionnel à base de palourdes, d\'ail, de persil et de vin blanc.'
            ],
            'Pizza' => [
                'Margherita' => 'Pizza italienne classique garnie de tomates, de mozzarella, de basilic frais, de sel et d\'huile d\'olive.',
                'Napolitana' => 'Pizza garnie de tomates, d\'ail, d\'origan et d\'huile d\'olive, parfois garnie d\'anchois.',
                'Quatre fromages' => 'Pizza garnie de quatre types de fromages, généralement de la mozzarella, du gorgonzola, du parmesan et du fromage de chèvre.',
                'Capricciosa' => 'Pizza garnie de mozzarella, de jambon italien (prosciutto cotto), de champignons, d\'artichauts et de tomates.',
                'Pepperoni' => 'Pizza garnie de fromage mozzarella et de tranches de pepperoni épicé.',
                'Hawaïenne' => 'Pizza garnie de fromage, de jambon et d\'ananas, une combinaison qui est source de débats passionnés.',
                'Calzone' => 'Pizza pliée et farcie, généralement avec les mêmes ingrédients que ceux utilisés pour une pizza classique.',
                'Marinara' => 'Pizza simple et traditionnelle garnie de tomates, d\'ail, d\'origan et d\'huile d\'olive.',
                'Diavola' => 'Pizza épicée garnie de salami piquant (souvent appelé pepperoni en Amérique du Nord) et parfois de piments rouges écrasés.',
                'Rustica' => 'Pizza garnie d\'une variété de légumes grillés, de mozzarella et souvent de roquette.'
            ],
            'Vegétarien' => [
                'Salade grecque' => 'Salade composée de tomates, de concombres, d\'oignons, de feta et d\'olives, garnie d\'origan et d\'huile d\'olive.',
                'Houmous' => 'Dip crémeux à base de pois chiches, de tahini, d\'ail et de jus de citron, souvent servi avec du pain pita.',
                'Guacamole' => 'Dip mexicain à base d\'avocats mûrs, de jus de citron vert, de tomates, d\'oignons et de coriandre.',
                'Ratatouille' => 'Plat provençal à base de légumes cuits, généralement comprenant des tomates, des aubergines, des courgettes, des oignons, des poivrons et de l\'ail.',
                'Tartiflette' => 'Plat savoyard généralement à base de pommes de terre, de reblochon, de lardons et d\'oignons. Dans sa version végétarienne, les lardons sont souvent remplacés par des champignons ou d\'autres légumes.',
                'Choucroute' => 'Plat alsacien à base de chou fermenté. Dans sa version végétarienne, les viandes sont remplacées par des légumes et parfois des pommes de terre.',
                'Paëlla' => 'Plat espagnol à base de riz coloré au safran, généralement garni de légumes, dans sa version végétarienne.',
                'Lasagnes' => 'Plat italien composé de couches de pâtes alternées avec de la sauce et du fromage. Dans sa version végétarienne, la viande est remplacée par des légumes tels que des épinards ou des courgettes.',
                'Couscous' => 'Plat nord-africain à base de semoule de blé dur, servi avec un ragoût de légumes.',
                'Mousse au chocolat' => 'Dessert à base de chocolat et d\'œufs, léger mais riche en saveurs.'
            ]
        ];

        // Boucle à travers le tableau pour créer chaque catégorie
        foreach ($categoriesLibelles as $libelle => $plats) {
            $categorie = new Categorie();
            $categorie->setLibelle($libelle)
                ->setImage(strtolower(str_replace(' ', '_', $libelle)) . '.png')
                ->setActive(true);
            $manager->persist($categorie);

            // Créer un plat pour chaque entrée dans la sous-catégorie
            foreach ($plats as $platLibelle => $platDescription) {
                $plat = new Plat();
                $plat->setLibelle($platLibelle)
                    ->setDescription($platDescription)
                    ->setPrix(rand(5, 20)) // Prix aléatoire entre 5 et 20
                    ->setImage(strtolower(str_replace(' ', '_', $platLibelle)) . '.png')
                    ->setActive(true)
                    ->setCategorie($categorie);
                $manager->persist($plat);
            }
        }

        // Création des utilisateurs
        $utilisateur1 = new Utilisateur();
        $utilisateur1
            ->setEmail('utilisateur1@example.com')
            ->setRoles(['ROLE_USER'])
            ->setPassword('user12345')
            ->setNom('Utilisateur1')
            ->setPrenom('Test')
            ->setTelephone('1234567890')
            ->setAdresse('123 Rue Test')
            ->setCp('12345')
            ->setVille('Testville');
        $manager->persist($utilisateur1);

        $utilisateur2 = new Utilisateur();
        $utilisateur2
            ->setEmail('utilisateur2@example.com')
            ->setRoles(['ROLE_USER'])
            ->setPassword('users23456')
            ->setNom('Utilisateur2')
            ->setPrenom('Test')
            ->setTelephone('9876543210')
            ->setAdresse('456 Avenue Test')
            ->setCp('54321')
            ->setVille('Testcity');
        $manager->persist($utilisateur2);

        $manager->flush();


        // Commandes Utilisateur1
        for ($i = 0; $i < 6; $i++) { 
            $commande = new Commande();
            $commande->setUtilisateur($utilisateur1)
                ->setDateCommande(new \DateTime())
                ->setEtat(rand(Commande::ETAT_ENREGISTREE_PAYEE, Commande::ETAT_LIVREE)); 
        
    $plats = $manager->getRepository(Plat::class)->findAll();
    shuffle($plats); // Mélanger les plats

    $total = 0;
    for ($j = 0; $j < rand(1, 4); $j++) {
        $detail = new Detail();
        $detail->setPlat($plats[$j]);
        $detail->setQuantite(rand(1, 3));
        $detail->setCommande($commande);

        $total += ($plats[$j]->getPrix() * $detail->getQuantite());

        $manager->persist($detail);
    }

    $commande->setTotal($total);
    $manager->persist($commande);
}

// Commandes Utilisateur2
for ($i = 0; $i < 6; $i++) { 
    $commande = new Commande();
    $commande->setUtilisateur($utilisateur2)
        ->setDateCommande(new \DateTime())
        ->setEtat(rand(Commande::ETAT_ENREGISTREE_PAYEE, Commande::ETAT_LIVREE));

    $plats = $manager->getRepository(Plat::class)->findAll();
    shuffle($plats);

    $total = 0;
    for ($j = 0; $j < rand(1, 4); $j++) {
        $detail = new Detail();
        $detail->setPlat($plats[$j]);
        $detail->setQuantite(rand(1, 3));
        $detail->setCommande($commande);

        $total += ($plats[$j]->getPrix() * $detail->getQuantite());

        $manager->persist($detail);
    }

    $commande->setTotal($total);
    $manager->persist($commande);
}



$manager->flush();
    }
}