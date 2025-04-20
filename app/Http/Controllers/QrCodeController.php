<?php

namespace App\Http\Controllers;

use App\Service\QrCodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class QrCodeController extends Controller
{
    protected $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    public function generateArticleQr(Request $request, $id)
    {
        // Generate the full URL for the article
        $articleUrl = URL::to('/articles/' . $id);
        
        // Generate QR code
        $qrCode = $this->qrCodeService->generateQrCode($articleUrl);
        
        // Return the base64 encoded image
        return response()->json(['qrCode' => $qrCode]);
    }
    public function readQrCode(Request $request)
    {
        // Validar la petición
        $request->validate([
            'qrFile' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('qrFile')) {
            $imageData = file_get_contents($request->file('qrFile')->path());
            $result = $this->qrCodeService->readQrCode($imageData);

            if ($result) {
                // Si el resultado contiene una URL hacia un artículo
                if (str_contains($result, '/articles/')) {
                    return redirect($result);
                }
                
                return response()->json(['success' => true, 'result' => $result]);
            }
            
            return response()->json(['success' => false, 'message' => 'No se pudo leer el código QR'], 422);
        }

        return response()->json(['success' => false, 'message' => 'No se subió ninguna imagen'], 400);
    }
}