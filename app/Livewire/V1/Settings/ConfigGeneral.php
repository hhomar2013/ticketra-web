<?php

namespace App\Livewire\V1\Settings;

use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;

class ConfigGeneral extends Component
{


        use WithFileUploads;

    // System
    public string $app_name        = '';
    public string $app_timezone     = '';
    public string $app_language     = '';

    // Contact
    public string $support_email   = '';
    public string $support_phone   = '';

    // Ticket
    public bool   $allow_user_delete = true;
    public bool   $auto_close        = false;
    public int    $auto_close_days   = 7;

    // Maintenance
    public bool   $maintenance_mode  = false;

    public function mount()
    {
        $this->app_name        = config('app.name');
        $this->app_timezone    = config('app.timezone');
        $this->app_language    = config('app.locale');
        $this->support_email   = Cache::get('setting_support_email', '');
        $this->support_phone   = Cache::get('setting_support_phone', '');
        $this->allow_user_delete = Cache::get('setting_allow_user_delete', true);
        $this->auto_close        = Cache::get('setting_auto_close', false);
        $this->auto_close_days   = Cache::get('setting_auto_close_days', 7);
        $this->maintenance_mode  = Cache::get('setting_maintenance_mode', false);
    }

    public function save()
    {
        $this->validate([
            'app_name'        => 'required|string|max:100',
            'support_email'   => 'nullable|email',
            'support_phone'   => 'nullable|string|max:20',
            'auto_close_days' => 'integer|min:1|max:365',
        ]);

        // حفظ في Cache
        Cache::forever('setting_support_email',    $this->support_email);
        Cache::forever('setting_support_phone',    $this->support_phone);
        Cache::forever('setting_allow_user_delete',$this->allow_user_delete);
        Cache::forever('setting_auto_close',       $this->auto_close);
        Cache::forever('setting_auto_close_days',  $this->auto_close_days);
        Cache::forever('setting_maintenance_mode', $this->maintenance_mode);

        // تحديث الـ .env
        $this->updateEnv('APP_NAME',     '"' . $this->app_name . '"');
        $this->updateEnv('APP_TIMEZONE', $this->app_timezone);
        $this->updateEnv('APP_LOCALE',   $this->app_language);

        $this->dispatch('show-toast', ['message' => __('Settings saved successfully'), 'type' => 'success']);
    }

    private function updateEnv(string $key, string $value): void
    {
        $path    = base_path('.env');
        $content = file_get_contents($path);
        $pattern = "/^{$key}=.*/m";
        $replace = "{$key}={$value}";
        file_put_contents($path, preg_match($pattern, $content)
            ? preg_replace($pattern, $replace, $content)
            : $content . "\n{$replace}"
        );
    }

    public function render()
    {
        return view('livewire.v1.settings.config-general');
    }
}
