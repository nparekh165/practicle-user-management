<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserApiController extends Controller
{
    public function show($id)
    {
        $user = User::with('addresses')->find($id);

        if (!$user) {
            return response()->json([
                'status_code' => 404,
                'message' => 'User not found',
                'data' => []
            ], 404);
        }
        
        $formattedAddresses = [];
        foreach ($user->addresses as $index => $address) {
            $formattedAddresses[] = [
                'address_type' => $address->address_type,
                'address' . ($index + 1) => [
                    'door/street' => $address->door_street,
                    'landmark' => $address->landmark,
                    'city' => $address->city,
                    'state' => $address->state,
                    'country' => $address->country,
                ],
                'primary' => $address->primary,
            ];
        }

        return response()->json([
            'status_code' => 200,
            'message' => 'User details',
            'data' => [
                'user_name' => $user->first_name,
                'mobile' => $user->mobile,
                'dob' => \Carbon\Carbon::parse($user->dob)->format('d/m/Y'),
                'gender' => $user->gender,
                'Address' => $formattedAddresses,
            ]
        ]);
    }
}