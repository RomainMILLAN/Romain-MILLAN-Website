<?php

namespace App\SignatureContext\Domain\DTO;

class SignatureDTO
{
    public string $firstName;

    public string $lastName;

    public string $status;

    public ?string $logo = null;

    public string $accentColor;

    /**
     * @var array<SignatureEmailDTO>
     */
    public array $emails = [];

    /**
     * @var array<SignaturePhoneDTO>
     */
    public array $phones = [];

    public SignatureSocialNetworkDTO $socialNetwork;

    public function fullName(): string
    {
        return sprintf('%s %s', $this->firstName, $this->lastName);
    }
}
