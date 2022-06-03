<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class directorioRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'  => 'Periodo fiscal es obligatorio.',
            'prog_id.required'     => 'Programa es obligatorio.',

            'dir_nombre_1.required'=> 'Apellido paterno, materno y nombre del que elaboró es obligatorio.',
            'dir_nombre_1.min'     => 'Apellido paterno, materno y nombre del que elaboró es de mínimo 1 carácteres.',
            'dir_nombre_1.max'     => 'Apellido paterno, materno y nombre del que elaboró es de máximo 80 carácteres.',
            'dir_cargo_1.required' => 'Cargo de quien elaboró es obligatorio.',
            'dir_cargo_1.min'      => 'Cargo de quien elaboró es de mínimo 1 carácteres.',
            'dir_cargo_1.max'      => 'Cargo de quien elaboró es de máximo 80 carácteres.',
            'dir_email_1.required' => 'Correo electrónico de quien elaboró es obligatorio.',
            'dir_email_1.min'      => 'Correo electrónico de quien elaboró es de mínimo 1 carácteres.',
            'dir_email_1.max'      => 'Correo electrónico de quien elaboró es de máximo 80 carácteres.',     
            'dir_tel_1.required'   => 'Teléfono de quien elaboró es obligatorio y digitar soló numeros preferentemente.',
            'dir_tel_1.min'        => 'Teléfono de quien elaboró es de mínimo 1 caracteres númericos preferentemente.',
            'dir_tel_1.max'        => 'Teléfono de quien elaboró es de máximo 30 caracteres numéricos prefentemente.',

            'dir_nombre_2.required'=> 'Apellido paterno, materno y nombre de quien valido es obligatorio.',
            'dir_nombre_2.min'     => 'Apellido paterno, materno y nombre de quien valido es de mínimo 1 carácteres.',
            'dir_nombre_2.max'     => 'Apellido paterno, materno y nombre de quien valido es de máximo 80 carácteres.',
            'dir_cargo_2.required' => 'Cargo de quien valido es obligatorio.',
            'dir_cargo_2.min'      => 'Cargo de quien valido es de mínimo 1 carácteres.',
            'dir_cargo_2.max'      => 'Cargo de quien valido es de máximo 80 carácteres.',
            'dir_email_2.required' => 'Correo electrónico de quien valido es obligatorio.',
            'dir_email_2.min'      => 'Correo electrónico de quien valido es de mínimo 1 carácteres.',
            'dir_email_2.max'      => 'Correo electrónico de quien valido es de máximo 80 carácteres.',     
            'dir_tel_2.required'   => 'Teléfono de quien valido es obligatorio y digitar soló numeros preferentemente.',
            'dir_tel_2.min'        => 'Teléfono de quien valido es de mínimo 1 caracteres númericos preferentemente.',
            'dir_tel_2.max'        => 'Teléfono de quien valido es de máximo 30 caracteres numéricos prefentemente.',

            'dir_nombre_3.required'=> 'Apellido paterno, materno y nombre del enlace de padrones es obligatorio.',
            'dir_nombre_3.min'     => 'Apellido paterno, materno y nombre del enlace de padrones es de mínimo 1 carácteres.',
            'dir_nombre_3.max'     => 'Apellido paterno, materno y nombre del enlace de padrones es de máximo 80 carácteres.',
            'dir_cargo_3.required' => 'Cargo del enlace es obligatorio.',
            'dir_cargo_3.min'      => 'Cargo del enlace es de mínimo 1 carácteres.',
            'dir_cargo_3.max'      => 'Cargo del enlace es de máximo 80 carácteres.',
            'dir_email_3.required' => 'Correo electrónico del enlace valido es obligatorio.',
            'dir_email_3.min'      => 'Correo electrónico del enlace valido es de mínimo 1 carácteres.',
            'dir_email_3.max'      => 'Correo electrónico del enlace es de máximo 80 carácteres.',     
            'dir_tel_3.required'   => 'Teléfono del enlace valido es obligatorio y digitar soló numeros preferentemente.',
            'dir_tel_3.min'        => 'Teléfono del enlace valido es de mínimo 1 caracteres númericos preferentemente.',
            'dir_tel_3.max'        => 'Teléfono del enlace valido es de máximo 30 caracteres numéricos prefentemente.'
        ];
    }
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
        return [
            'periodo_id'   => 'required',
            'prog_id'      => 'required',
            'dir_nombre_1' => 'required|min:1|max:80',
            'dir_cargo_1'  => 'required|min:1|max:80',
            'dir_tel_1'    => 'required|min:1|max:80',
            'dir_email_1'  => 'email|min:5|max:80|required',

            'dir_nombre_2' => 'required|min:1|max:80',
            'dir_cargo_2'  => 'required|min:1|max:80',
            'dir_tel_2'    => 'required|min:1|max:80',
            'dir_email_2'  => 'email|min:5|max:80|required',

            'dir_nombre_3' => 'required|min:1|max:80',
            'dir_cargo_3'  => 'required|min:1|max:80',
            'dir_tel_3'    => 'required|min:1|max:80',
            'dir_email_3'  => 'email|min:5|max:80|required'
        ];
    }
}
