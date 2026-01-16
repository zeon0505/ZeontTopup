<?php

namespace App\Livewire\Admin;

use App\Models\SiteSetting;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingManager extends Component
{
    use WithFileUploads, \App\Traits\LogActivity;

    public $settings = [
        'site_name' => '',
        'site_description' => '',
        'site_logo' => '',
        'footer_text' => '',
        'contact_email' => '',
        'whatsapp_number' => '',
        'meta_keywords' => '',
        'instagram_url' => '',
        'tiktok_url' => '',
        'youtube_url' => '',
        'maintenance_mode' => '0',
        'enable_popup' => '0',
        'popup_image' => '',
        'feature_1_logo' => '',
        'feature_2_logo' => '',
        'feature_3_logo' => '',
        'feature_4_logo' => '',
    ];

    public $new_logo;
    public $new_popup_image;
    public $new_feature_1_logo;
    public $new_feature_2_logo;
    public $new_feature_3_logo;
    public $new_feature_4_logo;

    public function mount()
    {
        foreach ($this->settings as $key => $value) {
            $this->settings[$key] = SiteSetting::get($key, '');
        }
    }

    public function saveSettings()
    {
        if ($this->new_logo) {
            $path = $this->new_logo->store('site', 'public');
            $this->settings['site_logo'] = $path;
            SiteSetting::set('site_logo', $path);
        }

        if ($this->new_popup_image) {
            $path = $this->new_popup_image->store('site', 'public');
            $this->settings['popup_image'] = $path;
            SiteSetting::set('popup_image', $path);
        }

        for ($i = 1; $i <= 4; $i++) {
            $fieldName = "new_feature_{$i}_logo";
            $settingKey = "feature_{$i}_logo";
            if ($this->$fieldName) {
                $path = $this->$fieldName->store('site', 'public');
                $this->settings[$settingKey] = $path;
                SiteSetting::set($settingKey, $path);
                $this->$fieldName = null;
            }
        }

        foreach ($this->settings as $key => $value) {
            if (!str_starts_with($key, 'feature_') && $key !== 'site_logo' && $key !== 'popup_image') { // Handled above if new
                SiteSetting::set($key, $value);
            }
        }

        $this->logAction('update_settings', 'Admin updated site settings', $this->settings);

        $this->dispatch('show-notification', 
            message: 'Site settings updated successfully!',
            type: 'success'
        );
        
        $this->new_logo = null;
        $this->new_popup_image = null;
    }

    public function render()
    {
        return view('livewire.admin.setting-manager')
            ->layout('components.admin-layout');
    }
}
