<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Inventory;
use App\Models\Location;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(1)->create();

        // data inventarisasi
        Inventory::create([
            'id' => 1,
            'name' => 'INV SUMSEL 1'
        ]);

        Inventory::create([
            'id' => 2,
            'name' => 'INV SUMSEL 2'
        ]);

        Inventory::create([
            'id' => 3,
            'name' => 'INV SUMSEL 3'
        ]);

        // data lokasi inv 1
        Location::create([
            'inventory_id' => 1,
            'name' => 'SUTET 275 kV Lahat(Lumut Balai) - Gumawang'
        ]);

        Location::create([
            'inventory_id' => 1,
            'name' => 'SUTET 275 kV Phi Incomer Muara Enim 1'
        ]);

        Location::create([
            'inventory_id' => 1,
            'name' => 'SUTET 275 kV Phi Incomer Muara Enim 2'
        ]);

        Location::create([
            'inventory_id' => 1,
            'name' => 'SUTT 150 kv Lubuk Linggau - Tebing TInggi'
        ]);

        Location::create([
            'inventory_id' => 1,
            'name' => 'SUTT 150 kv Incomer Pendopo'
        ]);

        Location::create([
            'inventory_id' => 1,
            'name' => 'SUTT 150 kv Sarolangun - Muara Rupit'
        ]);

        Location::create([
            'inventory_id' => 1,
            'name' => 'SUTET 275 kV Betung Kenten'
        ]);

        Location::create([
            'inventory_id' => 1,
            'name' => 'SUTT 150 kv Gumawang - Tugumulyo'
        ]);

        // data lokasi inv 2
        Location::create([
            'inventory_id' => 2,
            'name' => 'SUTT 70 kV Dukong - Manggar'
        ]);

        Location::create([
            'inventory_id' => 2,
            'name' => 'SUTT 150 kV Tanjung Api Api - landing Point Tanjung Carat'
        ]);

        Location::create([
            'inventory_id' => 2,
            'name' => 'SUTT 150 kV Muntok - Landing Point Muntok'
        ]);

        Location::create([
            'inventory_id' => 2,
            'name' => 'SUTT 150 kv Pangkal Pinang 2 - Air Anyir'
        ]);

        Location::create([
            'inventory_id' => 2,
            'name' => 'SUTT 70 Dukong - Belitung Utara'
        ]);

        Location::create([
            'inventory_id' => 2,
            'name' => 'GI 70kV Belitung Utara'
        ]);

        Location::create([
            'inventory_id' => 2,
            'name' => 'SUTT 150 kV Pagaralam - Manna'
        ]);

        Location::create([
            'inventory_id' => 2,
            'name' => 'SUTT 150 kv Pulau Baai - Argamakmur'
        ]);

        Location::create([
            'inventory_id' => 2,
            'name' => 'SUTT 150 kV Manna - Bintuhan'
        ]);

        Location::create([
            'inventory_id' => 2,
            'name' => 'SUTT 150 kV PLTP Hululais - Pekalongan'
        ]);
        
        Location::create([
            'inventory_id' => 2,
            'name' => 'SUTT 150 kV Argamakmur - Muko muko'
        ]);

        // data lokasi inv 3
        Location::create([
            'inventory_id' => 3,
            'name' => 'SUTT 150 kV Mesuji - Dipasena'
        ]);

        Location::create([
            'inventory_id' => 3,
            'name' => 'SUTT 150 kV Dente Teladas - Dipasena'
        ]);

        Location::create([
            'inventory_id' => 3,
            'name' => 'SUTT 150 kV Seputih Banyak - Dente Teladas'
        ]);

        Location::create([
            'inventory_id' => 3,
            'name' => 'SUTT 150 kV Pagelaram - Gedang Tataan'
        ]);

        Location::create([
            'inventory_id' => 3,
            'name' => 'SUTT 150 kV Phi Incomer Sidomulyo'
        ]);

        Location::create([
            'inventory_id' => 3,
            'name' => 'GITET 275kV Lampung 1'
        ]);

        Location::create([
            'inventory_id' => 3,
            'name' => 'SUTET 275 kV Gumawang - Lampung 1'
        ]);

        Location::create([
            'inventory_id' => 3,
            'name' => 'SUTT 150 kV Gedang Tataan - Teluk Ratai'
        ]);

        Location::create([
            'inventory_id' => 3,
            'name' => 'SUSUTET 275 kV Gumawang - Lampung 1TT 150 kV Liwa - Krui/Bengkunat'
        ]);

        // data tim surveyor
        Team::create([
            'id' => 1,
            'inventory_id' => 1,
            'name' => 'Tim 1'
        ]);
        
        Team::create([
            'id' => 2,
            'inventory_id' => 1,
            'name' => 'Tim 2'
        ]);
        
        Team::create([
            'id' => 3,
            'inventory_id' => 2,
            'name' => 'Tim 1'
        ]);
        
        Team::create([
            'id' => 4,
            'inventory_id' => 2,
            'name' => 'Tim 2'
        ]);
        
        Team::create([
            'id' => 5,
            'inventory_id' => 3,
            'name' => 'Tim 1'
        ]);
        
        Team::create([
            'id' => 6,
            'inventory_id' => 3,
            'name' => 'Tim 2'
        ]);

        // data anggota tim 
        // tim 1 inv 1
        TeamMember::create([
            'team_id' => 1,
            'name' => 'M Zulmi Arizona',
            'position' => 'Koordinator/Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 1,
            'name' => 'M Aditya Apriliansyah',
            'position' => 'Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 1,
            'name' => 'Martin Sugiharto',
            'position' => 'Ast Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 1,
            'name' => 'Efri Yudha Yulian',
            'position' => 'Ast Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 1,
            'name' => 'M Hafiz Alqarino',
            'position' => 'Ast Surveyor'
        ]);

        // tim 2 inv 1
        TeamMember::create([
            'team_id' => 2,
            'name' => 'Reza Lesmana',
            'position' => 'Koordinator/Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 2,
            'name' => 'M Taufik Ferri',
            'position' => 'Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 2,
            'name' => 'Remon Suhendra',
            'position' => 'Ast Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 2,
            'name' => 'M Made Rivai',
            'position' => 'Ast Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 2,
            'name' => 'Meiky Ilham N',
            'position' => 'Ast Surveyor'
        ]);

        // tim 1 inv 2
        TeamMember::create([
            'team_id' => 3,
            'name' => 'Arif Syarifudin',
            'position' => 'Koordinator/Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 3,
            'name' => 'Robbi Nugraha',
            'position' => 'Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 3,
            'name' => 'Riski Darmawansyah',
            'position' => 'Ast Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 3,
            'name' => 'Hasiholan Nigot S',
            'position' => 'Ast Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 3,
            'name' => 'Liant Fhareis',
            'position' => 'Ast Surveyor'
        ]);

        // tim 2 inv 2
        TeamMember::create([
            'team_id' => 4,
            'name' => 'Ary Anugerah',
            'position' => 'Koordinator/Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 4,
            'name' => 'Indoki',
            'position' => 'Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 4,
            'name' => 'M Lutfi Kayla',
            'position' => 'Ast Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 4,
            'name' => 'Sapto Hadi S',
            'position' => 'Ast Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 4,
            'name' => 'Tri Oktariandi',
            'position' => 'Ast Surveyor'
        ]);

        // tim 1 inv 3
        TeamMember::create([
            'team_id' => 5,
            'name' => 'Didit Trisulistiyo',
            'position' => 'Koordinator/Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 5,
            'name' => 'Dicki Ari Sandy',
            'position' => 'Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 5,
            'name' => 'Rizki Anugrah P',
            'position' => 'Ast Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 5,
            'name' => 'Aviv',
            'position' => 'Ast Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 5,
            'name' => 'M Fikri Haikal P',
            'position' => 'Ast Surveyor'
        ]);

        // tim 2 inv 3
        TeamMember::create([
            'team_id' => 6,
            'name' => 'Risto Munandar',
            'position' => 'Koordinator/Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 6,
            'name' => 'Heru Manurfa',
            'position' => 'Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 6,
            'name' => 'Diki Setiawan',
            'position' => 'Ast Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 6,
            'name' => 'M Fahlevi',
            'position' => 'Ast Surveyor'
        ]);

        TeamMember::create([
            'team_id' => 6,
            'name' => 'M Rifqi Cahaydi',
            'position' => 'Ast Surveyor'
        ]);

        // user admin
        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'test@example.com',
            'role' => 'Administrator',
            'password' => Hash::make('123456'),
        ]);

        // user surveyor tim 1 INV 1
        User::factory()->create([
            'name' => 'Tim 1',
            'username' => 'tim1',
            'team_id' => 1,
            'email' => 'tim1@example.com',
            'role' => 'Surveyor',
            'password' => Hash::make('123456'),
        ]);
    }
}
