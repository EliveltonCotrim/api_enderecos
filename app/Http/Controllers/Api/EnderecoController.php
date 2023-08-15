<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CepRequest;
use App\Http\Resources\CepResource;
use App\Models\Endereco;
use App\Services\ViaCep\ViaCepService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EnderecoController extends Controller
{
    private Endereco $endereco;

    public function __construct()
    {
        $this->endereco = new Endereco();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {
        try {

            $enderecos = Endereco::where(function ($query) use ($request) {
                if ($request->search) {
                    $query->where('cep', 'like', '%' . $request->search . '%')
                        ->orWhere('logradouro', 'like', '%' . $request->search . '%');
                }
            })->orderBy('cep')->get();

            return response()->json($enderecos, 200);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => 'false', 'message' => $th->getMessage()], 500);
        }
    }

    public function buscarEndereco($cep)
    {
        try {
            $cepFormat = str_replace('-', '', $cep);

            if (strlen($cepFormat) == 8) {

                $cepBd = Endereco::where('cep', $cepFormat)->first();

                if ($cepBd) {

                    return response()->json(['data' => $cepBd], 200);
                } else {

                    $reponse = ViaCepService::cep()->get($cepFormat);

                    if (isset($reponse['erro'])) {
                        return response()->json(['success' => 'false', 'message' => 'Cep não encontrado'], 404);
                    }

                    return CepResource::collection($reponse);
                }
            }
        } catch (\Throwable $th) {

            return response()->json(['success' => 'false', 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CepRequest $request)
    {
        try {

            $data = [
                'cep' => $request->cep,
                'logradouro' => $request->logradouro,
                'bairro' => $request->bairro,
                'cidade' => $request->cidade,
                'uf' => $request->uf,
            ];

            $endereco = Endereco::create($data);

            return response()->json($endereco, 201);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => 'false', 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $endereco = Endereco::find($id);

            if ($endereco) {
                $endereco->delete();
            }

            return response()->json(['success' => 'true', 'message' => 'Endereço deletado com sucesso'], 200);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(['success' => 'false', 'message' => $th->getMessage()], 500);
        }
    }

    public function edit($id)
    {

        try {

            $endereco = Endereco::find($id);

            if ($endereco) {
                return response()->json($endereco, 200);
            }

            return response()->json(['success' => 'false', 'message' => 'Endereço não encontrado'], 404);
        } catch (\Throwable $th) {
            //throw $th;

            return response()->json(['success' => 'false', 'message' => $th->getMessage()], 500);
        }
    }
}
