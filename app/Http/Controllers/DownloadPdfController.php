<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class DownloadPdfController extends Controller
{

    public function generateClientPdf($id)
    {
        $client = Client::findOrFail($id);
        
        $data = [
            'client' => $client // Passa o cliente para a view
        ];

        $pdf = PDF::loadView('client.download', $data);


        // Retornar o PDF para download
        return $pdf->stream('client_' . $client->id . '.pdf');

    }
}
