<?php

namespace App\Livewire\Backend\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Layout;
#[Layout('components.layouts.admin-dashboard')] 
class Index extends Component
{
    public function render()
    {

        $metaTitle = 'Dashboard - '.website_setting('site_name');
        $metaDescription = 'Radioquery Dashboard';
        $metaKeywords = 'Radioquery Dashboard';
        // return view('livewire.backend.auth.login')->layout('components.layouts.backend'); or
        return view('livewire.backend.dashboard.index')->layoutData([
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'meta_keywords' => $metaKeywords,
        ]);

       
    }
}
