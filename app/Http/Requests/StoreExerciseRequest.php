<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExerciseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $exerciseId = $this->route('exercise') ? $this->route('exercise')->id : null;

        return [
            'name' => ['required', 'string', 'max:255', 'unique:exercises,name,' . $exerciseId],
            'description' => ['nullable', 'string'],
            'muscle_group' => ['required', 'string', 'max:100'],
            'primary_muscle' => ['required', 'string', 'max:100'],
            'secondary_muscles' => ['nullable', 'array'],
            'secondary_muscles.*' => ['string', 'max:100'],
            'exercise_type' => ['required', 'string', 'max:50'],
            'equipment' => ['required', 'string', 'max:100'],
            'difficulty' => ['required', 'string', 'max:50'],
            'instructions' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del ejercicio es obligatorio.',
            'name.unique' => 'Ya existe un ejercicio con este nombre.',
            'muscle_group.required' => 'El grupo muscular es obligatorio.',
            'primary_muscle.required' => 'El músculo principal es obligatorio.',
            'exercise_type.required' => 'El tipo de ejercicio es obligatorio.',
            'equipment.required' => 'El equipo requerido es obligatorio.',
            'difficulty.required' => 'El nivel de dificultad es obligatorio.',
        ];
    }
}
