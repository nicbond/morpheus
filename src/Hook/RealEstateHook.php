<?php
// src/Hook/RealEstateHook.php
namespace App\Hook;

class RealEstateHook
{
    public function formatAd(array $ad): array
    {
        $formatted_ad = [];

        $formatted_ad['id'] = $ad['id'];
        $formatted_ad['title'] = $ad['titre'];
        $formatted_ad['body'] = $ad['description'];

        $formatted_ad['vertical'] = 'Immobilier'; // Le PDF nous indique que le fichier JSON est un fichier d’annonces immobilière: je force donc le enum vertical à Immobilier.

        $formatted_ad['price'] = $ad['prix'];
        $formatted_ad['category'] = $ad['categorie'];

        if ($formatted_ad['category'] == 'vente') {
            $formatted_ad['category'] = 1;
        } else if ($formatted_ad['category'] == 'location') {
            $formatted_ad['category'] = 2;
        } else if ($formatted_ad['category'] == 'colocation') {
            $formatted_ad['category'] = 3;
        } else {
            $formatted_ad['category'] = 4;
        }

        $formatted_ad['city'] = $ad['ville'];

        $formatted_ad['zip_code'] = $ad['code_postal'];
        $formatted_ad['pro_ad'] = true; //true si l’annonce est postée par un professionnel, c'est ici le cas !

        $photos = $ad['photos'];
        $size = count($photos);

        if ($size > 0) {
            foreach($photos as $key => $photo) {
                $formatted_ad['images'][$key] = $photo;
            }
        } else {
            $formatted_ad['images'] = $ad['photos'];
        }

        var_dump($formatted_ad);die;
        return $formatted_ad;
    }
}
