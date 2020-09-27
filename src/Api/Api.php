<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class Api
{
    public static function send(array $input, string $vertical): void
    {
        if (!in_array($vertical, ['real_estate', 'job'])) {
            die("Wrong vertical: {$vertical}");
        }

        $validator = Validation::createValidator();
        $fields    = [
            'id' => new Assert\Required([
                new Assert\Type('integer'),
            ]),

            'title' => new Assert\Required([
                new Assert\Type('string'),
                new Assert\Length(['max' => 100]),
                new Assert\NotBlank(),
            ]),

            'body' => new Assert\Required([
                new Assert\Type('string'),
                new Assert\Length(['max' => 500]),
                new Assert\NotBlank(),
            ]),

            'vertical' => new Assert\Required([
                new Assert\Type('string'),
                new Assert\Choice(['real_estate', 'job']),
                new Assert\NotBlank(),
            ]),

            'price' => new Assert\Optional([
                new Assert\Type('integer')
            ]),

            'city' => new Assert\Required([
                new Assert\Type('string'),
                new Assert\NotBlank(),
            ]),

            'zip_code' => new Assert\Optional([
                new Assert\Type('string'),
                new Assert\Length(['max' => 5]),
            ]),

            'pro_ad' => new Assert\IsTrue(),

            'images' => new Assert\Optional([
                new Assert\Type('array'),
                new Assert\Count(['min' => 1])
            ]),
        ];

        if ($vertical === 'real_estate') {
            $fields['category'] = new Assert\Required([new Assert\Type('integer')]);
            if (isset($input['category']) && $input['category'] === 4) {
                $fields['type'] = new Assert\Required([new Assert\Type('string')]);
            }
        } else {
            $field['contract'] = new Assert\Required([new Assert\Type('integer')]);
            $field['salary'] = new Assert\Optional([new Assert\Type('integer')]);
        }

        $constraint = new Assert\Collection(['fields' => $fields]);
        $violations = $validator->validate($input, $constraint);
        foreach ($violations as $violation) {
            $errors[] = "{$violation->getPropertyPath()}: {$violation->getMessage()} \n";
        }

        if (!empty($errors)) {
            print_r($errors);
            die;
        }
    }
}
