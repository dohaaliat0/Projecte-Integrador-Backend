<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContactPerson;
use App\Enums\Relationship;

class ContactPersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contactPersons = [
            [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'phone' => '123456789',
            'relationship' => Relationship::Parent,
            'patientId' => 1,
            ],
            [
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'phone' => '987654321',
            'relationship' => Relationship::Parent,
            'patientId' => 1,
            ],
            [
            'firstName' => 'Alice',
            'lastName' => 'Doe',
            'phone' => '123456789',
            'relationship' => Relationship::Sibling,
            'patientId' => 2,
            ],
            [
            'firstName' => 'Bob',
            'lastName' => 'Doe',
            'phone' => '987654321',
            'relationship' => Relationship::Guardian,
            'patientId' => 3,
            ],
        ];

        foreach ($contactPersons as $contactPerson) {
            ContactPerson::create($contactPerson);
        }
    }
}
