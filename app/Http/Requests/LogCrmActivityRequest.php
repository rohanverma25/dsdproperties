<?php

namespace App\Http\Requests;

use App\Models\CrmLead;
use App\Models\CrmLeadActivity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LogCrmActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'    => ['required', Rule::in(CrmLeadActivity::TYPES)],
            'outcome' => ['nullable', Rule::in(CrmLeadActivity::OUTCOMES)],
            'note'    => ['nullable', 'string'],

            // THE RULE: every logged activity must leave a next step behind,
            // unless the lead is being closed out.
            'next_followup_at' => [
                Rule::requiredIf(fn () => ! $this->closesLead()),
                'nullable',
                'date',
            ],
        ];
    }

    /** True when this activity ends the relationship, so no follow-up is owed. */
    public function closesLead(): bool
    {
        if ($this->input('outcome') === 'not_interested') {
            return true;
        }

        $lead = $this->route('lead');
        $stage = config('crm.outcomes.' . $this->input('outcome') . '.stage') ?? $lead?->stage;

        return in_array($stage, CrmLead::CLOSED_STAGES, true);
    }

    public function messages(): array
    {
        return [
            'next_followup_at.required' => 'Set the next follow-up date — the activity cannot be saved without it.',
        ];
    }
}
