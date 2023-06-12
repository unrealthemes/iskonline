<?php

namespace App\View\Components\Applications;

use App\Models\ApplicationAnswers;
use App\Models\Documents;
use App\Models\Service;
use Illuminate\View\Component;

class ApplicationsComponent extends Component
{
    public $application;
    public $service;
    public $status;
    public $buttons;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($application, $statuses, $services)
    {
        $this->application = $application;
        $this->document = Documents::where('application_id', '=', $application->id)->first();

        $this->answer = ApplicationAnswers::where('application_id', '=', $application->id)->first();

        if (isset($services[$application->service_id])) {
            $this->service = $services[$application->service_id];
        } else {
            $this->service = null;
        }

        $this->status = $statuses[$application->application_status_id];
        $this->buttons = [];

        $texts = explode('|', $this->status->button_text);
        $links = explode('|', $this->status->button_link);

        foreach ($links as $i => $link) {
            $name = explode(';', $link)[0];
            if ($name == 'applications.edit' and $application->edited) {
                continue;
            }
            $params = [];

            $codes = [];

            if ($this->document) {
                $codes['document_id'] = $this->document->id;
            }

            if ($this->answer) {
                $codes['answer_code'] = $this->answer->code;
            }

            if ($this->application) {
                $codes['application_id'] = $this->application->id;
            }

            if ($this->application) {
                $codes['service_id'] = $this->application->service_id;
            }

            foreach (explode(',', explode(';', $link)[1]) as $param) {
                $key = explode('=', $param)[0];
                $val = explode('=', $param)[1];

                foreach ($codes as $code => $repl) {
                    $val = str_replace(':' . $code, $repl, $val);
                }

                $params[$key] = $val;
            }

            $this->buttons[] = [
                'text' => explode(':', $texts[$i])[0],
                'color' => explode(':', $texts[$i])[1],
                'link' => route($name, $params)
            ];
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.applications.applications-component');
    }
}
