<?php

namespace App\Hook;

use Vicopo\Vicopo;

class JobHook
{
    public function formatAd(array $ad): array
    {
        $formatted_ad = [];

        //$formatted_ad['client_reference'] = $ad['client_reference']; // Est-ce l'id ??
        $formatted_ad['title'] = $ad['title'];

        $description_poste = strip_tags($ad['description_poste']);
        $description_entreprise = strip_tags($ad['description_entreprise']);
        $formatted_ad['body'] = $description_poste . $description_entreprise;

        $formatted_ad['vertical'] = 'Emploi'; // Ici nous avons une offre d'emploi, donc le enum vertical vaudra Emploi.
        $formatted_ad['city'] = $ad['location_city'];
        $formatted_ad['pro_ad'] = true; //true si l’annonce est postée par un professionnel, je considère que c'est ici le cas !

        $time_type = $ad['time_type'];
        if ($time_type == 'Temps plein' || $time_type == 'CDI') {
            $formatted_ad['contract'] = 1;
        } else if ($time_type == 'CDD') {
            $formatted_ad['contract'] = 2;
        } else if ($time_type == 'Interim') {
            $formatted_ad['contract'] = 3;
        } else {
            $formatted_ad['contract'] = 4;
        }

        $formatted_ad['images'] = $ad['pictures'];

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
                $formatted_ad['zip_code'] = $json['cities'][$i]['code'];
                break;
            }
        }

        return $formatted_ad;
    }
}
