<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CredentialType;
use App\Models\Stage;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $creadTypes = [
            [
                'id' => 1,
                'name' => 'database'
            ],
            [
                'id' => 2,
                'name' => 'FTP'
            ],
            [
                'id' => 3,
                'name' => 'web'
            ],
            [
                'id' => 4,
                'name' => 'mail'
            ],
            [
                'id' => 5,
                'name' => 'SSH'
            ],
        ];

        foreach ($creadTypes as $t) {
            CredentialType::updateOrCreate(
                ['id' => $t['id']],
                $t
            );
        }

        $creadTypes = [
            [
                'id' => 1,
                'name' => 'Produzione'
            ],
            [
                'id' => 2,
                'name' => 'Sviluppo'
            ],
            [
                'id' => 3,
                'name' => 'Progettazione'
            ],
        ];

        foreach ($creadTypes as $t) {
            Stage::updateOrCreate(
                ['id' => $t['id']],
                $t
            );
        }
    }
}
