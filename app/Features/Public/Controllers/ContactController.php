<?php

namespace App\Features\Public\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Mostrar página pública de contacto
     */
    public function index(): View
    {
        return view('public::contact.index');
    }

    /**
     * Enviar formulario de contacto
     */
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ];

        try {
            Mail::raw(
                "Nuevo mensaje de contacto desde Linkiu\n\n" .
                "Nombre: {$data['name']}\n" .
                "Email: {$data['email']}\n" .
                "Teléfono: " . ($data['phone'] ?? 'No proporcionado') . "\n" .
                "Asunto: {$data['subject']}\n\n" .
                "Mensaje:\n{$data['message']}",
                function ($message) use ($data) {
                    $message->to('linkiucloud@gmail.com')
                        ->subject('Nuevo contacto: ' . $data['subject'])
                        ->replyTo($data['email'], $data['name']);
                }
            );

            return back()->with('success', '¡Mensaje enviado exitosamente! Te responderemos pronto.');
        } catch (\Exception $e) {
            return back()->with('error', 'Hubo un error al enviar el mensaje. Por favor, intenta nuevamente.');
        }
    }
}
