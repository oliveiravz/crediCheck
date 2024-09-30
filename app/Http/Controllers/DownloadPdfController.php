<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;



class DownloadPdfController extends Controller
{

    public function generateClientPdf($id)
    {
        // Obtenha o cliente pelo ID
        $client = Client::findOrFail($id);

        $data = [
            'client' => $client
        ];

        $pdf = PDF::loadView('client.pdf.download', $data);

        // Retornar o PDF para download
        return $pdf->download('client_' . $client->id . '.pdf');

    }
}
