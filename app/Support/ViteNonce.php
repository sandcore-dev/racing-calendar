<?php

namespace App\Support;

use Illuminate\Support\Facades\Vite;
use Spatie\Csp\Nonce\NonceGenerator;

class ViteNonce implements NonceGenerator
{
    public function generate(): string
    {
        return Vite::useCspNonce();
    }
}
