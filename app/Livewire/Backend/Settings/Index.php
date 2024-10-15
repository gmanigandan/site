<?php

namespace App\Livewire\Backend\Settings;

use Livewire\Component;

use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Backend\Settings;

use Livewire\Attributes\Layout;
#[Layout('components.layouts.admin-dashboard')] 
class Index extends Component
{
    use WithFileUploads;
    public $tab = null;
    public $default_tab = 'GeneralSettings';
    protected $queryString = ['tab'];
    public $site_phone_original, $site_name, $site_email, $site_phone, $site_meta_keywords, $site_meta_description, $site_logo, $site_favicon, $site_meta_title, $site_address;
    public $facebook_url, $twitter_url, $youtube_url, $linkedin_url;
    public $loading = true;
    public function selectTab($tab)
    {
        $this->tab = $tab;
    }
    public function mount()
    {
 
        $this->tab = request()->tab ? request()->tab : $this->default_tab;

        $this->site_name = website_setting('site_name');
        $this->site_email = website_setting('site_email');
        $this->site_phone = website_setting('site_phone');
        $this->site_address = website_setting('site_address');
        $this->site_meta_title = website_setting('site_meta_title');
        $this->site_meta_keywords = website_setting('site_meta_keywords');
        $this->site_meta_description = website_setting('site_meta_description');
        $this->site_logo = website_setting('site_logo');
        $this->site_favicon = website_setting('site_favicon');

        $this->facebook_url = website_setting('facebook_url');
        $this->twitter_url = website_setting('twitter_url');
        $this->youtube_url = website_setting('youtube_url');
        $this->linkedin_url = website_setting('linkedin_url');

    }
    public function updateGeneralSettings()
    {
        $this->validate([
            'site_name' => 'required',
            'site_email' => 'required|email',
        ]);

        $settingsToUpdate = [
            ['name' => 'site_name', 'value' => $this->site_name],
            ['name' => 'site_email', 'value' => $this->site_email],
            ['name' => 'site_phone', 'value' => $this->site_phone],
            ['name' => 'site_address', 'value' => $this->site_address],
            ['name' => 'site_meta_title', 'value' => $this->site_meta_title],
            ['name' => 'site_meta_keywords', 'value' => $this->site_meta_keywords],
            ['name' => 'site_meta_description', 'value' => $this->site_meta_description]

        ];
        foreach ($settingsToUpdate as $setting) {
            Settings::updateOrCreate(
                ['name' => $setting['name']],
                ['value' => $setting['value']]
            );
            clear_website_setting_cache($setting['name']);
        }

       
        session()->flash('success', 'general settings has been updated successfully!');

    }
    public function updateSocialNetworks()
    {

        $settingsToUpdate = [
            ['name' => 'facebook_url', 'value' => $this->facebook_url],
            ['name' => 'twitter_url', 'value' => $this->twitter_url],
            ['name' => 'youtube_url', 'value' => $this->youtube_url],
            ['name' => 'linkedin_url', 'value' => $this->linkedin_url]

        ];
        foreach ($settingsToUpdate as $setting) {
            Settings::updateOrCreate(
                ['name' => $setting['name']],
                ['value' => $setting['value']]
            );
            clear_website_setting_cache($setting['name']);
        }

        session()->flash('success', 'general settings has been updated successfully!');


    }

    public function updateLogo(){
        $this->validate([
            'site_logo' => 'image|mimes:jpeg,png,jpg,gif|max:1024', // Adjust validation rules as needed
        ]);
        $path = join_path(['public','uploads','images']);
        $old_logo  = website_setting('site_logo');
        $file_name = 'LOGO_'.uniqid() .'.'.$this->site_logo->getClientOriginalExtension();

        $this->site_logo->storeAs( $path, $file_name);
        if($old_logo != null && Storage::exists( $path .'/'. $old_logo)){
           Storage::delete( $path .'/'. $old_logo);
        }

        Settings::updateOrCreate(
            ['name' => 'site_logo'],
            ['value' => $file_name]
        );
        clear_website_setting_cache('site_logo');

        $this->reset('site_logo');
        $this->resetValidation(); // Reset validation errors if any
        session()->flash('success', 'Site logo has been updated successfully!');
 
        $this->dispatch('resetLogoInput');

    }
    public function updateFavicon(){
        $this->validate([
            'site_favicon' => 'image|mimes:jpeg,png,jpg,gif|max:1024', // Adjust validation rules as needed
        ]);
        $path = join_path(['public','uploads','images']);
        $old_logo  = website_setting('site_favicon');
        $file_name = 'FAV_'.uniqid() .'.'.$this->site_favicon->getClientOriginalExtension();

        $this->site_favicon->storeAs( $path, $file_name);
        if($old_logo != null && Storage::exists( $path .'/'. $old_logo)){
            Storage::delete( $path .'/'. $old_logo);
        }
        Settings::updateOrCreate(
            ['name' => 'site_favicon'],
            ['value' => $file_name]
        );
        clear_website_setting_cache('site_favicon');

        flash()->success('Site favicon has been updated successfully');
        $this->dispatch('resetFaviconInput');
    }
    
    public function render()
    {

        $metaTitle = 'Settings - '.website_setting('site_name');
        $metaDescription = 'Radioquery Settings';
        $metaKeywords = 'Radioquery Settings';
       
        return view('livewire.backend.settings.index')->layoutData([
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'meta_keywords' => $metaKeywords,
        ]);

       
    }
}
