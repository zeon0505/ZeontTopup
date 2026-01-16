<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationToast extends Component
{
    public $message = '';
    public $type = 'success'; 
    public $isVisible = false;

    protected $listeners = ['show-notification' => 'show'];

    public function show($message, $type = 'success')
    {
        $this->message = $message;
        $this->type = $type;
        $this->isVisible = true;

        // Auto hide after 3 seconds
        $this->dispatch('hide-notification-after-delay');
    }

    public function hide()
    {
        $this->isVisible = false;
    }

    public function render()
    {
        return view('livewire.notification-toast');
    }
}
