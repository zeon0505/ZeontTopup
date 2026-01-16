<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ApiCredential;

class ApiManager extends Component
{
    public $showModal = false;
    public $editingId = null;
    
    // Form fields
    public $provider_name = '';
    public $api_key = '';
    public $api_secret = '';
    public $endpoint = '';
    public $is_active = true;

    protected $rules = [
        'provider_name' => 'required|string|unique:api_credentials,provider_name',
        'api_key' => 'nullable|string',
        'api_secret' => 'nullable|string',
        'endpoint' => 'nullable|url',
        'is_active' => 'boolean',
    ];

    public function openCreateModal()
    {
        $this->reset(['provider_name', 'api_key', 'api_secret', 'endpoint', 'editingId']);
        $this->is_active = true;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $api = ApiCredential::findOrFail($id);
        $this->editingId = $api->id;
        $this->provider_name = $api->provider_name;
        $this->api_key = $api->api_key;
        $this->api_secret = $api->api_secret;
        $this->endpoint = $api->endpoint;
        $this->is_active = $api->is_active;
        $this->showModal = true;
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->editingId) {
            $rules['provider_name'] = 'required|string|unique:api_credentials,provider_name,' . $this->editingId;
        }
        
        $this->validate($rules);

        $data = [
            'provider_name' => $this->provider_name,
            'api_key' => $this->api_key,
            'api_secret' => $this->api_secret,
            'endpoint' => $this->endpoint,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            ApiCredential::find($this->editingId)->update($data);
        } else {
            ApiCredential::create($data);
        }

        $this->showModal = false;
        $this->dispatch('show-notification', message: 'API Configuration saved successfully!', type: 'success');
    }

    public function delete($id)
    {
        ApiCredential::findOrFail($id)->delete();
        $this->dispatch('show-notification', message: 'API Configuration deleted successfully!', type: 'success');
    }

    public function render()
    {
        $apis = ApiCredential::all();

        return view('livewire.admin.api-manager', [
            'apis' => $apis,
        ]);
    }
}
