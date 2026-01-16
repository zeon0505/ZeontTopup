<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $status = ucfirst($this->order->status);
        $message = (new MailMessage)
            ->subject("Update Pesanan ZeonGame: #{$this->order->order_number} [$status]")
            ->greeting("Halo, {$notifiable->name}!")
            ->line("Pesanan Anda dengan nomor #{$this->order->order_number} telah diperbarui statusnya menjadi: **{$status}**.")
            ->line("Detail Game: " . ($this->order->game->name ?? 'N/A'))
            ->line("Total Pembayaran: Rp " . number_format($this->order->total, 0, ',', '.'));

        if ($this->order->status === 'completed') {
            $message->line("Terima kasih! Top-up Anda telah berhasil diproses. Silakan cek akun game Anda.");
        } elseif ($this->order->status === 'processing') {
            $message->line("Tim kami sedang memproses pesanan Anda. Mohon tunggu sebentar.");
        }

        return $message->action('Lihat Riwayat Pesanan', url('/dashboard'))
            ->line('Terima kasih telah berbelanja di ZeonGame!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,
        ];
    }
}
