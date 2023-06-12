<?php

namespace App\View\Components\Service;

use App\Models\FormUiForm;
use Illuminate\View\Component;

class ServiceFormSection extends Component
{
    public $service;
    public $order;
    public $bg;
    public $addr;
    public $application;
    public $form;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($service, $order = 1, $bg = '', $application = null)
    {
        $this->service = $service;
        $this->order = $order;
        $this->bg = $bg;
        $this->application = $application;
        $this->addr = route('services.get_form_json', ['service' => $service->id, 'order' => $order]);

        // Если существует новая форма
        $this->form = FormUiForm::where('service_id', '=', $this->service->id)->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.service.service-form-section');
    }
}
