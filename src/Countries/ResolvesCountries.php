<?php
namespace SandwaveIo\Vat\Countries;

interface ResolvesCountries
{
    public function isCountryValid(string $countryCode): bool;
    public function isCountryInEu(string $countryCode): bool;
}