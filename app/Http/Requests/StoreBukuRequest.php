<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\KodeBukuFormat;
use Illuminate\Validation\Rule;

class StoreBukuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_buku' => ['required', 'string', 'max:20', 'unique:buku,kode_buku', new KodeBukuFormat()],
            'judul' => 'required|string|max:200',
            'kategori' => 'required|in:Programming,Database,Web Design,Networking,Data Science',
            'pengarang' => 'required|string|max:100',
            'penerbit' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|string|max:20',
            'harga' => 'required|numeric|min:0',

            'stok' => [
                'required',
                'integer',
                'min:0',
                Rule::when($this->input('tahun_terbit') < 2000, 'max:5')
            ],

            'deskripsi' => 'nullable|string',

            'bahasa' => [
                'required',
                'string',
                'max:20',
                Rule::when($this->input('kategori') == 'Programming', 'in:Inggris')
            ],
        ];
    }

     /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'kode_buku.required' => 'Kode buku wajib diisi.',
            'kode_buku.string' => 'Kode buku harus berupa teks.',
            'kode_buku.max' => 'Kode buku tidak boleh lebih dari 20 karakter.',
            'kode_buku.unique' => 'Kode buku sudah digunakan, silakan gunakan kode lain.',
            'judul.required' => 'Judul buku wajib diisi.',
            'judul.string' => 'Judul buku harus berupa teks.',
            'judul.max' => 'Judul buku tidak boleh lebih dari 200 karakter.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.in' => 'Kategori yang dipilih tidak valid.',
            'pengarang.required' => 'Pengarang wajib diisi.',
            'pengarang.string' => 'Pengarang harus berupa teks.',
            'pengarang.max' => 'Pengarang tidak boleh lebih dari 100 karakter.',
            'penerbit.required' => 'Penerbit wajib diisi.',
            'penerbit.string' => 'Penerbit harus berupa teks.',
            'penerbit.max' => 'Penerbit tidak boleh lebih dari 100 karakter.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer' => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min' => 'Tahun terbit tidak boleh kurang dari 1900.',
            'tahun_terbit.max' => 'Tahun terbit tidak boleh lebih dari tahun saat ini.',
            'isbn.string' => 'ISBN harus berupa teks.',
            'isbn.max' => 'ISBN tidak boleh lebih dari 20 karakter.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh kurang dari 0.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka bulat.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'bahasa.required' => 'Bahasa wajib diisi.',
            'bahasa.string' => 'Bahasa harus berupa teks.',
            'bahasa.max' => 'Bahasa tidak boleh lebih dari 20 karakter.',

            'stok.min' => 'Stok tidak boleh kurang dari 0.',
            'stok.max' => 'Buku terbitan sebelum tahun 2000 maksimal stoknya adalah 5.',

            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'bahasa.required' => 'Bahasa wajib diisi.',
            'bahasa.string' => 'Bahasa harus berupa teks.',
            'bahasa.max' => 'Bahasa tidak boleh lebih dari 20 karakter.',
            'bahasa.in' => 'Khusus kategori Programming, bahasa buku harus "Inggris".',
        ];
    }

     /**
     * Get custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'kode_buku' => 'Kode Buku',
            'judul' => 'Judul',
            'kategori' => 'Kategori',
            'pengarang' => 'Pengarang',
            'penerbit' => 'Penerbit',
            'tahun_terbit' => 'Tahun Terbit',
            'isbn' => 'ISBN',
            'harga' => 'Harga',
            'stok' => 'Stok',
            'deskripsi' => 'Deskripsi',
            'bahasa' => 'Bahasa'
        ];
    }
}
