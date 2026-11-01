<?php

namespace App\Http\Requests;

use App\Models\CrmLead;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CrmLeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** Phone is stored as digits only so duplicate detection is reliable. */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'phone'     => CrmLead::normalisePhone($this->input('phone')),
            'alt_phone' => $this->filled('alt_phone')
                ? CrmLead::normalisePhone($this->input('alt_phone'))
                : null,
        ]);
    }

    public function rules(): array
    {
        $lead = $this->route('lead');

        return [
            'name'            => ['required', 'string', 'max:120'],
            'phone'           => [
                'required', 'string', 'digits_between:10,15',
                // On create a duplicate opens the existing lead instead of failing,
                // so uniqueness is only enforced when editing.
                $lead ? Rule::unique('crm_leads', 'phone')->ignore($lead->id)->whereNull('deleted_at') : 'nullable',
            ],
            'alt_phone'       => ['nullable', 'string', 'digits_between:10,15'],
            'source_page'     => ['nullable', 'string', 'max:255'],
            'source_channel'  => ['nullable', Rule::in(CrmLead::CHANNELS)],
            'intent'          => ['nullable', Rule::in(CrmLead::INTENTS)],
            'scheme_interest' => ['nullable', 'string', 'max:160'],
            'area'            => ['nullable', 'string', 'max:160'],
            'budget_min'      => ['nullable', 'integer', 'min:0'],
            'budget_max'      => ['nullable', 'integer', 'min:0', 'gte:budget_min'],
            'flexible'        => ['nullable', 'boolean'],
            'stage'           => ['required', Rule::in(CrmLead::STAGES)],
            'notes'           => ['nullable', 'string'],
            'waiting_for'     => ['nullable', Rule::in(array_keys(config('crm.waiting_reasons')))],
            'requirement'     => ['nullable', 'string', 'max:255'],

            // THE RULE: a follow-up date is mandatory unless the lead is closed,
            // or on hold for something with no date yet (a registry opening).
            'next_followup_at' => [
                Rule::requiredIf(fn () => ! in_array($this->input('stage'), CrmLead::CLOSED_STAGES, true)
                    && ! $this->filled('waiting_for')),
                'nullable',
                'date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'next_followup_at.required' => 'A next follow-up date is required — the lead cannot be saved without one.',
            'phone.unique'              => 'This number already belongs to another lead.',
        ];
    }
}
