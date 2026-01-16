<?php

namespace App\Livewire\Member;

use Livewire\Component;
use App\Models\Deposit;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;

class BalanceStatus extends Component
{
    public $pendingDepositsCount = 0;

    public function mount()
    {
        $this->updatePendingCount();
    }

    public function updatePendingCount()
    {
        $this->pendingDepositsCount = Deposit::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->count();
    }

    public function syncStatus(PaymentService $paymentService)
    {
        $pendingDeposits = Deposit::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->get();

        $syncedCount = 0;
        $failedCount = 0;

        foreach ($pendingDeposits as $deposit) {
            try {
                $status = $paymentService->checkStatus($deposit->deposit_number);
                $transactionStatus = $status->transaction_status;
                $fraudStatus = $status->fraud_status ?? 'accept';

                if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                    if ($fraudStatus == 'accept') {
                         \Illuminate\Support\Facades\DB::transaction(function () use ($deposit) {
                            $deposit->update(['status' => 'paid']);
                            $deposit->user->increment('balance', $deposit->amount);
                        });
                        $syncedCount++;
                    }
                } else if (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                    $deposit->update(['status' => 'failed']);
                    $failedCount++;
                }
            } catch (\Exception $e) {
                // If transaction not found (404), mark as failed/expired only if it's old enough
                // This prevents marking new deposits as failed before the user has a chance to pay
                if (str_contains($e->getMessage(), '404')) {
                    if ($deposit->created_at->diffInMinutes(now()) > 60) {
                        $deposit->update(['status' => 'failed']);
                        $failedCount++;
                    }
                }
            }
        }

        $this->updatePendingCount();

        if ($syncedCount > 0) {
            $this->dispatch('balance-updated');
            session()->flash('success', "Berhasil! $syncedCount deposit telah dikonfirmasi masuk ke saldo.");
            return redirect()->route('dashboard');
        } elseif ($failedCount > 0) {
            session()->flash('warning', "$failedCount deposit dibatalkan karena kadaluarsa atau tidak ditemukan.");
            return redirect()->route('dashboard');
        } else {
            $stillPending = Deposit::where('user_id', Auth::id())->where('status', 'pending')->exists();
            if ($stillPending) {
                session()->flash('info', "Pembayaran belum terdeteksi. Pastikan Bapak sudah menyelesaikan transfer di aplikasi pembayaran.");
            } else {
                session()->flash('info', "Tidak ada pembayaran aktif yang perlu dikonfirmasi.");
            }
        }
    }

    public function render()
    {
        return view('livewire.member.balance-status');
    }
}
