<?php declare(strict_types = 1);

namespace SandwaveIo\Vat;

use DateTimeImmutable;
use SandwaveIo\Vat\Countries\Iso2;
use SandwaveIo\Vat\VatRates\ResolvesVatRates;
use SandwaveIo\Vat\VatRates\TaxesEuropeDatabaseClient;

class Vat
{
    protected Iso2 $countries;
    protected ResolvesVatRates $vatRateResolver;

    public function __construct()
    {
        $this->countries = new Iso2();
        $this->vatRateResolver = new TaxesEuropeDatabaseClient();
    }

    public function validateVatNumber(string $vatNumber): bool
    {
        // TODO: Implement
        return true;
    }

    public function countryInEurope(string $countryCode): bool
    {
        return $this->countries->isCountryValid($countryCode) && $this->countries->isCountryInEu($countryCode);
    }

    public function europeanVatRate(string $countryCode, ?DateTimeImmutable $date = null, float $fallbackRate = 0.0): float
    {
        if (! $this->countryInEurope($countryCode)) {
            return $fallbackRate;
        }
        return $this->vatRateResolver->getDefaultVatRateForCountry($countryCode, $date) ?? $fallbackRate;
    }
}
