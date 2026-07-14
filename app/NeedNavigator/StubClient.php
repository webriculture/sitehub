<?php

declare(strict_types=1);

namespace App\NeedNavigator;

use App\Models\Site;

/**
 * Placeholder driver used until the real Need Navigator API details land.
 * Returns representative sample data so sites can be designed and QA'd
 * against realistic event content.
 */
final class StubClient implements NeedNavigatorClient
{
    public function events(Site $site): array
    {
        return [
            [
                'id' => 'stub-orientation',
                'kind' => 'event',
                'title' => [
                    'en' => 'FRAN Center Open House',
                    'es' => 'Casa Abierta del Centro FRAN',
                ],
                'description' => [
                    'en' => 'Meet the partner organizations and learn about services available to your family.',
                    'es' => 'Conozca a las organizaciones asociadas y los servicios disponibles para su familia.',
                ],
                'location' => [
                    'en' => 'FRAN Center, Northeast Salem',
                    'es' => 'Centro FRAN, Noreste de Salem',
                ],
                'starts_at' => now()->addDays(7)->setTime(10, 0)->toIso8601String(),
                'ends_at' => now()->addDays(7)->setTime(14, 0)->toIso8601String(),
                'all_day' => false,
                'registration_url' => null,
            ],
            [
                'id' => 'stub-parenting-class',
                'kind' => 'class',
                'title' => [
                    'en' => 'Positive Parenting Workshop',
                    'es' => 'Taller de Crianza Positiva',
                ],
                'description' => [
                    'en' => 'A free weekly workshop series for parents and caregivers.',
                    'es' => 'Una serie de talleres semanales gratuitos para padres y cuidadores.',
                ],
                'location' => [
                    'en' => 'Community Room A',
                    'es' => 'Sala Comunitaria A',
                ],
                'starts_at' => now()->addDays(10)->setTime(18, 0)->toIso8601String(),
                'ends_at' => now()->addDays(10)->setTime(19, 30)->toIso8601String(),
                'all_day' => false,
                'registration_url' => null,
            ],
        ];
    }
}
