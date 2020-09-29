<?php

namespace App\Hook;

use Vicopo\Vicopo;

class JobHook
{
    public function formatAd(array $ad): array
    {
        $formatted_ad = [];

        $formatted_ad['id'] = intval($ad['client_reference']); // Est-ce l'id ?? Je vais le définir en tant qu'id n'ayant pas de consigne précise pour ce cas.
        $formatted_ad['title'] = $ad['title'];

        $formatted_ad['body'] = $ad['description_poste']. $ad['description_entreprise'];

        $formatted_ad['vertical'] = 'job';
        $formatted_ad['city'] = $ad['location_city'];
        $formatted_ad['pro_ad'] = true; //true si l’annonce est postée par un professionnel, je considère que c'est ici le cas !

        $formatted_ad['images'] = array($ad['pictures']);

//***************************************BONUS***********************************************//
        $i = 0;
        $location_state = $ad['location_state'];

        $vicopoUrl = 'http://vicopo.selfbuild.fr/city/' . urlencode($formatted_ad['city']);
        $json = @json_decode(file_get_contents($vicopoUrl), true);

        $city = strtoupper($ad['location_city']);
        $size = count($json['cities']);

        for($i=0; $i < $size; $i++) {
            $jsonCity = $json['cities'][$i]['city'];
            $code_postal = substr($json['cities'][$i]['code'], 0, 2); 
            if ($city == $jsonCity && $location_state == $code_postal) {
                $formatted_ad['zip_code'] = strval($json['cities'][$i]['code']);
                break;
            }
        }

        return $formatted_ad;
    }
}
