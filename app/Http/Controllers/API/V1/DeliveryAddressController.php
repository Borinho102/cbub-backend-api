<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\DeliveryAddressResource;
use App\Models\DeliveryAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryAddressController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = DeliveryAddress::query()
            ->with('country', 'city')
            ->where('user_id', auth('api')->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(request('page_size', 10))
            ->through(function ($address) {
                return DeliveryAddressResource::make($address);
            });

        return $this->successfulResponse(
            $addresses,
            'ADDRESSES_RETRIEVED',
            'Delivery addresses successfully retrieved'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'default' => 'required|boolean',
            'country' => 'required|exists:world_countries,id',
            'city' => 'required|exists:world_cities,id',
        ]);

        if ($validator->fails()) {
            return response([
                'error' => $validator->errors()->first(),
                'message' => $validator->errors()->first(),
                'code' => 'VALIDATION_ERROR',
            ], 406);
        }

        $address = DeliveryAddress::create([
            ...$request->only('full_name', 'phone', 'address'),
            'country_id' => $request->country,
            'city_id' => $request->city,
            'user_id' => auth('api')->user()->id,
            'use_as_default' => $request->default
        ]);

        return $this->successfulResponse(
            DeliveryAddressResource::make($address),
            'ADDRESS_CREATED',
            'Delivery address successfully created!'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $address = DeliveryAddress::where('user_id', auth('api')->user()->id)
            ->findOrFail($id);

        $address->delete();

        return $this->successfulResponse(
            true,
            'ADDRESS_DELETED',
            'Delivery address successfully deleted!'
        );
    }
}
