<?php

namespace App\Rules;

use App\Models\Guild;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Database\Eloquent\Builder;

class UniqueDiscordId implements ValidationRule, DataAwareRule
{
    protected array $data = [];

    public function __construct(protected readonly Builder $eloquentBuilder)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $conditional = $this->eloquentBuilder->whereDiscordId($value);
        if (isset($this->data['guild'])) {
            $guild = Guild::whereExternalId($this->data['guild'])->first();
            if (!$guild) {
                $fail('The provided guild_id is invalid.');
                return;
            }
            $conditional->where('guild_id', $guild->id);
        }
        if ($conditional->exists()) {
            $fail('The :attribute has already been assigned.');
        }
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
