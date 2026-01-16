<?php

namespace App\Livewire\Admin;

use Livewire\Component;

use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Voucher;

#[Layout('components.admin-layout')]
class VoucherManager extends Component
{
    use WithPagination;

    public $code, $discount_type = 'fixed', $amount, $min_purchase, $max_discount, $valid_from, $valid_until, $usage_limit;
    public $vouchers_id;
    public $isEdit = false;

    public function render()
    {
        $vouchers = Voucher::latest()->paginate(10);
        return view('livewire.admin.voucher-manager', compact('vouchers'));
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isEdit = false;
    }

    public function store()
    {
        $this->validate([
            'code' => 'required|unique:vouchers,code,' . $this->vouchers_id,
            'discount_type' => 'required|in:fixed,percent',
            'amount' => 'required|numeric|min:0',
        ]);

        Voucher::updateOrCreate(['id' => $this->vouchers_id], [
            'code' => strtoupper($this->code),
            'discount_type' => $this->discount_type,
            'amount' => $this->amount,
            'min_purchase' => $this->min_purchase ?: null,
            'max_discount' => $this->max_discount ?: null,
            'valid_from' => $this->valid_from ?: null,
            'valid_until' => $this->valid_until ?: null,
            'usage_limit' => $this->usage_limit ?: null,
        ]);

        session()->flash('message', $this->vouchers_id ? 'Voucher Updated Successfully.' : 'Voucher Created Successfully.');
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        $this->vouchers_id = $id;
        $this->code = $voucher->code;
        $this->discount_type = $voucher->discount_type;
        $this->amount = $voucher->amount;
        $this->min_purchase = $voucher->min_purchase;
        $this->max_discount = $voucher->max_discount;
        $this->valid_from = $voucher->valid_from?->format('Y-m-d\TH:i');
        $this->valid_until = $voucher->valid_until?->format('Y-m-d\TH:i');
        $this->usage_limit = $voucher->usage_limit;
        $this->isEdit = true;
    }

    public function delete($id)
    {
        Voucher::find($id)->delete();
        session()->flash('message', 'Voucher Deleted Successfully.');
    }

    public function toggleActive($id)
    {
        $voucher = Voucher::find($id);
        $voucher->is_active = !$voucher->is_active;
        $voucher->save();
    }

    private function resetInputFields()
    {
        $this->code = '';
        $this->discount_type = 'fixed';
        $this->amount = '';
        $this->min_purchase = '';
        $this->max_discount = '';
        $this->valid_from = '';
        $this->valid_until = '';
        $this->usage_limit = '';
        $this->vouchers_id = null;
        $this->isEdit = false;
    }
}
