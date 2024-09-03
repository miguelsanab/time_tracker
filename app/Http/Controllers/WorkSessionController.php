<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkSession;

class WorkSessionController extends Controller
{
    // Método para iniciar una sesión de trabajo
    public function startSession()
    {
        $session = new WorkSession();
        $session->start_time = now();
        $session->save();

        return response()->json($session);
    }

    // Método para finalizar una sesión de trabajo
    public function endSession(Request $request, $id)
    {
        // Busca la sesión de trabajo por su ID, lanza una excepción si no se encuentra
        $session = WorkSession::findOrFail($id);

        // Asegúrate de que la sesión no esté ya finalizada
        if ($session->end_time) {
            return response()->json(['error' => 'La sesión ya ha sido finalizada.'], 400);
        }

        // Establece la hora de finalización y la descripción
        $session->end_time = now();
        $session->description = $request->input('description');
        $session->save();

        return response()->json($session);
    }

    // Método para obtener todas las sesiones de trabajo
    public function getSessions()
    {
        $sessions = WorkSession::all();
        return response()->json($sessions);
    }
}
