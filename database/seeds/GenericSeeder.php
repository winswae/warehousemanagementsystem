<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Model\Warehouse;

class GenericSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Creating super admin
        $super_admin = User::create([
            'name'     => 'Super Admin',
            'email'    => 'super_admin@wms.com',
            'type'     => 'super_admin',
            'password' => Hash::make('12345678'),
        ]);
        //Assigning role
        $super_admin->assignRole('super_admin');

        //Creating tenant
        $tenant = User::create([
            'name'     => 'Tenant 1',
            'email'    => 'tenant1@wms.com',
            'type'     =>  'tenant',
            'password' => Hash::make('12345678'),
        ]);
        //Assigning role
        $tenant->assignRole('tenant');

        //Creating renter
        $renter = User::create([
            'name'     => 'Renter 1',
            'email'    => 'renter1@wms.com',
            'type'     => 'renter',
            'password' => Hash::make('12345678'),
        ]);
        //Assigning role
        $renter->assignRole('renter');

        //Creating warehouse
        $warehouse = Warehouse::create([
            'name'        => 'Warehouse 1',
            'description' => 'Test Warehouse',
            'marla'       => '20',
            'room'        => '5',
            'location'    => 'Raiwand Road, Lahore',
            'renter_id'   =>  $renter->id,
        ]);

        //Creating warehouse admin
        $warehouse_admin = User::create([
            'name'         => 'Warehouse Admin',
            'email'        => 'warehouse_admin@wms.com',
            'type'         => 'warehouse_admin',
            'warehouse_id' => $warehouse->id, 
            'password'     => Hash::make('12345678'),
        ]);
        //Assigning role
        $warehouse_admin->assignRole('warehouse_admin');

    }
}