<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DetalleFicha;
use App\Models\Ficha;
use App\Models\Video;
use Illuminate\Http\Request;

class FichaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener la fecha de filtro desde la solicitud
        $fechaFiltro = $request->input('fecha');

        // Filtrar fichas por fecha si se proporciona
        if ($fechaFiltro) {
            $fichas = Ficha::whereDate('fecha_venta', $fechaFiltro)->orderBy('fecha_venta', 'desc')->get();
        } else {
            $fichas = Ficha::orderBy('fecha_venta', 'desc')->get();
        }

        // Retornar la vista con las fichas y la fecha de filtro
        return view('ficha.index', compact('fichas', 'fechaFiltro'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Obtener todos los videos para el formulario de creación
        $videos = Video::all();

        return view('ficha.create', compact('videos'));
    }


    public function searchClient(Request $request)
    {
        $dni = $request->input('dni');
        $cliente = Cliente::where('DNI', $dni)->first();
        
        return response()->json($cliente);
    }

    public function getVideoPrice(Request $request)
    {
        $videoId = $request->input('video_id');
        $video = Video::find($videoId);

        return response()->json(['precio' => $video ? $video->precio : null]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Crear una nueva ficha
        $ficha = new Ficha();
        $ficha->id_cliente = $request->cliente_id;
        $ficha->fecha_Venta = now();
        $ficha->total = $request->total;
        $ficha->save();

        foreach($request->detalles as $detalle) {
            // Crear un nuevo detalle de ficha
            $detalleFicha = new DetalleFicha();
            $detalleFicha->id_ficha = $ficha->id_ficha;
            $detalleFicha->id_video = $detalle['id_video'];
            $detalleFicha->precio = $detalle['precio'];
            $detalleFicha->cantidad = $detalle['cantidad'];
            $detalleFicha->save();
        }

        return response()->json([
            'success' => true,
            'redirect' => route('ficha.index'),
            'data' => $request->all(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
