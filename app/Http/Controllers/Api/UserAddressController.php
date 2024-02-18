<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserAddressRequest;
use App\Models\Country;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class UserAddressController extends Controller
{

    public function index(Request $request)
    {
        try
        {
            $userAddresses = UserAddress::AddressRes($request->user->id)->get();
            return response()->json([
                'userAddresses' => $userAddresses,
                'message' => 'Success',
                'status_code' => Response::HTTP_OK,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json(['message' => __('custom.failed_to_retrieve_data'), 'status_code' => Response::HTTP_INTERNAL_SERVER_ERROR], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // The rest of your code...



    public function store(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'country' => 'required|string|exists:countries,name',
                'state' => 'nullable|string',
                'city' => 'nullable|string',
                'zip' => 'nullable|string',
                'address_1' => 'nullable|string',
                'address_2' => 'nullable|string',
                'name' => 'required|string',
                'email' => 'required|email',
                'phone' => 'required|string',
                'longitude' => 'required|string',
                'latitudes' => 'required|string',
                'location_id' => 'required|string',
                'delivery_instruction' => 'nullable|string',
                // 'default' => 'required|in:0,1',
            ]);
           
            if ($validator->fails())
            {
                return response()->json(['message' => $validator->errors()->first() , 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }
            $country = Country::where('name',$request->country)->first();
            $countryMap = extractCountryName($request->address_1);

            if ($countryMap != $country->name_en)
            {
                return response()->json(['message' => __('custom.ensure_location_selected'), 'status_code' => Response::HTTP_INTERNAL_SERVER_ERROR], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            // __('custom.validation_error')
            $userAddress = UserAddress::create(array_merge($validator->validated(), ['user_id' => $request->user->id]));
            return response()->json([
                // 'userAddress' => $userAddress,
                'message' => 'Success',
                'status_code' => Response::HTTP_OK,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json(['message' => __('custom.failed_to_store_user_address'), 'status_code' => Response::HTTP_INTERNAL_SERVER_ERROR], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // The rest of your code...


    public function show(Request $request)
    {
        try
        {
            $userAddress = UserAddress::SingleAddressRes()->find($request->addressId);
            if ($userAddress != null)
            {
                return response()->json([
                    'message' => 'Success',
                    'status_code' => Response::HTTP_OK,
                    'userAddress' => $userAddress
                ], 200);
            }
            else
            {
                return response()->json([
                    'message' => __('custom.address_does_not_exist'),
                    'status_code' => 404,

                ], 404);
            }
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'message' => __('custom.address_does_not_exist'),
                'status_code' => 500,

            ], 500);
        }
    }

    public function update(Request $request)
    {
        try
        {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:user_addresses,id',
                'country' => 'string',
                'state' => 'nullable|string',
                'city' => 'nullable|string',
                'zip' => 'nullable|string',
                'address_1' => 'nullable|string',
                'address_2' => 'nullable|string',
                'name' => 'nullable|string',
                'email' => 'nullable|email',
                'phone' => 'nullable|string',
                'delivery_instruction' => 'nullable|string',
                'longitude' => 'required|string',
                'latitudes' => 'required|string',
                'location_id' => 'required|string',
            ]);

            if ($validator->fails())
            {
                return response()->json(['message' => __('custom.validation_error'), 'errors' => $validator->errors(), 'status_code' => 400], 400);
            }
            $userAddress = UserAddress::find($request->id);
            $userAddress->update($validator->validated());
            return response()->json([

                'message' => 'Success',
                'status_code' => Response::HTTP_OK,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json(['message' => __('custom.failed_to_store_user_address'), 'status_code' => Response::HTTP_INTERNAL_SERVER_ERROR], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {
        try
        {
            $userAddress = UserAddress::find($id);
            $userAddress->delete();
            return response()->json([

                'message' => 'Success',
                'status_code' => Response::HTTP_OK,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json(['message' => __('custom.failed_to_delete_user_address'), 'status_code' => Response::HTTP_INTERNAL_SERVER_ERROR], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}