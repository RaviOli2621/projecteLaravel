<?php

namespace App\Service;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Illuminate\Support\Facades\Log;
use Throwable;

class QrCodeService
{
    public function generateQrCode(string $url): string
    {
        // Configure QR code options
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel' => QRCode::ECC_L,
            'scale' => 5,
            'imageBase64' => true,
        ]);

        // Generate the QR code
        $qrcode = new QRCode($options);
        
        // Return as base64 data URI
        return $qrcode->render($url);
    }
    public function readQrCode(string $imageData): ?string{
        try {
            $result = (new QRCode)->readFromBlob($imageData);
            return $result;
        } catch (Throwable $e) {
            // Log the error
            Log::error('Error al leer código QR: ' . $e->getMessage());
            return null;
        }
    }
}