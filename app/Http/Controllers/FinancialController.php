<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;


class FinancialController extends Controller
{
    public function index(){
        return view('financial_panel.home');
    }

    public function reg_clin_page(){
        return view('financial_panel.registrarUsuario');
    }

    public function registerClinic(Request $request){
        $userC = new UserController();
        $userC->register($request, $request->role);
        return redirect()->route('financial');
    }

    public function gerenciarClinicaPage(){
        $clinicas = User::where("role", "!=", "patient")->orderBy("created_at", "desc")->get();
        return view('financial_panel.gerenciarClinica', ['clinics' => $clinicas]);
    }


    public function searchClinic(Request $request)
    {
        // Obtém o parâmetro 'query' enviado na URL
        $query = $request->get('query');

        // Valida se o parâmetro foi fornecido
        if (!$query) {
            return response()->json(['error' => 'Query parameter is required'], 400);
        }

        // Busca no banco de dados por nome ou CPF
        $users = User::where('role', 'clinic') // Filtra pelo role = 'patient'
        ->where(function($queryBuilder) use ($query) {
            // Busca por nome ou CPF
            $queryBuilder->where('cpf_cnpj', 'like', "%$query%")
                         ->orWhere('name', 'like', "%$query%");
        })
        ->limit(10) // Limita os resultados a 10
        ->get(['id', 'name', 'cpf_cnpj']); // Retorna apenas os campos necessários

    return response()->json($users); 
    }

    public function searchPatient(Request $request)
    {
        // Obtém o parâmetro 'query' enviado na URL
        $query = $request->get('query');

        // Valida se o parâmetro foi fornecido
        if (!$query) {
            return response()->json(['error' => 'Query parameter is required'], 400);
        }

        // Busca no banco de dados por nome ou CPF
        $users = User::where('role', 'patient') // Filtra pelo role = 'patient'
        ->where(function($queryBuilder) use ($query) {
            // Busca por nome ou CPF
            $queryBuilder->where('cpf_cnpj', 'like', "%$query%")
                         ->orWhere('name', 'like', "%$query%");
        })
        ->limit(10) // Limita os resultados a 10
        ->get(['id', 'name', 'cpf_cnpj']); // Retorna apenas os campos necessários

       return response()->json($users);  
    }

    
}
