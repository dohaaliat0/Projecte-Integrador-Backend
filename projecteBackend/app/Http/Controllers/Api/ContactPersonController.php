<?php
namespace App\Http\Controllers\Api;

use App\Models\ContactPerson;
use Illuminate\Http\Request;
use App\Http\Requests\StoreContactPersonRequest;
use App\Http\Resources\ContactPersonResource;
use App\Http\Controllers\Api\BaseController;


class ContactPersonController extends BaseController
{

    public function index()
    {
        try {
            $contactPeople = ContactPerson::all();
            return $this->sendResponse(ContactPersonResource::collection($contactPeople), 'Contact people retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error retrieving contact people.', $e->getMessage());
        }
    }

    public function store(StoreContactPersonRequest $request)
    {
        try {
            $validated = $request->validated();
            $contactPerson = ContactPerson::create($validated);
            return $this->sendResponse(new ContactPersonResource($contactPerson), 'Contact person created successfully.', 201);
        } catch (\Exception $e) {
            return $this->sendError('Error creating contact person.', $e->getMessage());
        }
    }


    public function show(ContactPerson $contactPerson)
    {
        try {
            return $this->sendResponse(new ContactPersonResource($contactPerson), 'Contact person retrieved successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error retrieving contact person.', $e->getMessage());
        }
    }

    public function update(StoreContactPersonRequest $request, ContactPerson $contactPerson)
    {


        try {
            $validated = $request->validated();
            $contactPerson->update($validated);
            return $this->sendResponse(new ContactPersonResource($contactPerson), 'Contact person updated successfully.');
        } catch (\Exception $e) {
            return $this->sendError('Error updating contact person.', $e->getMessage());
        }
    }

    public function destroy(ContactPerson $contactPerson)
    {
        try {
            $contactPerson->delete();
            return $this->sendResponse([], 'Contact person deleted successfully.', 204);
        } catch (\Exception $e) {
            return $this->sendError('Error deleting contact person.', $e->getMessage());
        }
    }
}