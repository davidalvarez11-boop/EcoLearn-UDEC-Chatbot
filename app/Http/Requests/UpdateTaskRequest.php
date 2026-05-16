<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'title'       => ['sometimes','required','string','max:120'],
            'description' => ['sometimes','nullable','string','max:2000'],
            'is_done'     => ['sometimes','boolean'],
        ];
    }
}