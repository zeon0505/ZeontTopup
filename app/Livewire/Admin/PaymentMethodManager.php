<?php

namespace App\Livewire\Admin;

use App\Models\PaymentMethod;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PaymentMethodManager extends Component
{
    use WithFileUploads;

    public $methods;
    public $isOpen = false;
    public $isEdit = false;
    
    // Form fields
    public $methodId;
    public $code;
    public $name;
    public $category;
    public $icon;
    public $newIcon;
    public $fee = 0;
    public $description;
    public $is_active = true;

    protected $rules = [
        'code' => 'required|string|unique:payment_methods,code', // Updated dynamically for edit
        'name' => 'required|string',
        'category' => 'required|string',
        'newIcon' => 'nullable|image|max:1024', // 1MB Max
        'fee' => 'required|numeric|min:0',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $this->methods = PaymentMethod::all();
        return view('livewire.admin.payment-method-manager');
    }

    public function create()
    {
        $this->reset(['code', 'name', 'category', 'icon', 'newIcon', 'fee', 'description', 'is_active', 'methodId']);
        $this->isEdit = false;
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $this->methodId = $id;
        $this->code = $method->code;
        $this->name = $method->name;
        $this->category = $method->category;
        $this->icon = $method->icon;
        $this->fee = $method->fee;
        $this->description = $method->description;
        $this->is_active = $method->is_active;

        $this->isEdit = true;
        $this->isOpen = true;
    }

    public function store()
    {
        $rules = $this->rules;
        if ($this->isEdit) {
            $rules['code'] = 'required|string|unique:payment_methods,code,' . $this->methodId;
        }

        $this->validate($rules);

        $iconPath = $this->icon;
        if ($this->newIcon) {
            $iconPath = $this->newIcon->store('images/payments', 'public');
        }

        if ($this->isEdit) {
            $method = PaymentMethod::findOrFail($this->methodId);
            $method->update([
                'code' => $this->code,
                'name' => $this->name,
                'category' => $this->category,
                'icon' => $iconPath,
                'fee' => $this->fee,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Payment Method updated successfully']);
        } else {
            PaymentMethod::create([
                'code' => $this->code,
                'name' => $this->name,
                'category' => $this->category,
                'icon' => $iconPath,
                'fee' => $this->fee,
                'description' => $this->description,
                'is_active' => $this->is_active,
            ]);
            $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Payment Method created successfully']);
        }

        $this->isOpen = false;
        $this->reset(['newIcon']); // Clear uploaded file
    }

    public function delete($id)
    {
        PaymentMethod::find($id)->delete();
        $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Payment Method deleted successfully']);
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['newIcon']);
    }
    
    public function toggleStatus($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $method->is_active = !$method->is_active;
        $method->save();
        $this->dispatch('show-toast', ['type' => 'success', 'message' => 'Status updated successfully']);
    }
}
