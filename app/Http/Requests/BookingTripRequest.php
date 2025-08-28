<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingTripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'trip_id'                => 'nullable|integer',
            'number_of_members'      => 'nullable',
            'trip_date'              => 'required|date',
            'name'                   => 'required|string|max:255',
            'surname'                => 'required|string|max:255',
            'gender'                 => 'required',
            'date_of_birth'          => 'required|date',
            'mobile'                 => 'required|string|max:20',
            'email'                  => 'required|email|max:255',
            'street_house_number'    => 'required|string|max:255',
            'country'                => 'nullable|string|max:100',
            'post_code'              => 'required|string|max:20',
            'city_place_name'        => 'required|string|max:100',
            'stay_at_home_contact'   => 'required|string|max:255',
            'contact_no_home_caller' => 'required|string|max:20',
            'room_preference'        => 'nullable|in:1 person,2/3 person',
            'room_category_id'       => 'nullable|integer',
            'travel_insurance'       => 'nullable',
            'insured_at'             => 'required|string|max:255',
            'policy_number'          => 'required|string|max:255',
            'additional_note'        => 'nullable|string',
        ];
    }
}
