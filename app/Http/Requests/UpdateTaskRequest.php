<?php

namespace App\Http\Requests;

use App\Models\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $project = $this->route("project");

        $task = $this->route("task");

        return [
            "name" => [
                "required",
                "min:3",
                Rule::unique("tasks")
                    ->where("project_id", $project->id)
                    ->ignoreModel($task)
            ],
        ];
    }
}
