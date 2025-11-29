<?php
namespace App\Repositories;

use App\Interfaces\ResidentRepositoryInterface;
use App\Models\Resident;
use App\Models\User;

class ResidentRepository implements ResidentRepositoryInterface
{
    // ResidentRepository implementation
    public function getAllResidents()
    {
        // Implementation to retrieve all residents
        return Resident::all();
    }
    public function getResidentById(int $id)
    {
        // Implementation to retrieve a resident by ID
        return Resident::where('id', $id)->first();
    }

    public function createResident(array $data)
    {
        // Implementation to create a new resident
        // berelasi ke model User juga
        $user = User::create(
            [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
            ]
        );
        // assign role
        $user->assignRole('resident');

        return $user->resident()->create($data);
    }

    public function updateResident(int $id, array $data)
    {
        // Implementation to update a resident by ID
        $resident = $this->getResidentById($id);

        $resident->user->update([
            'name' => $data['name'],
            // password jika diisi dan tidak diisi
            'password' => isset($data['password']) ? bcrypt($data['password']) : $resident->user->password,
        ]);

        // update role
        $resident->user->syncRoles('resident');

        return $resident->update($data);
    }

    public function deleteResident(int $id)
    {
        // Implementation to delete a resident by ID
        $resident = $this->getResidentById($id);
        $resident->user->delete();
        return $resident->delete();
    }
}


?>
