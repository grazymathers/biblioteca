<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Livro;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class LivrosController extends Controller
{
    public function index()
    {
        // Obtém os livros paginados
        $livros = Livro::paginate(10);

        // Obtém os dados do formulário de filtragem
        $filtros = request()->only('titulo', 'autor');

        // Filtra os livros de acordo com os dados do formulário
        if ($filtros) {
            $livros = $livros->filter($filtros);
        }

        return view('books.index', compact('livros'));
    }
    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => ['required', 'min:5', 'max:255'],
            'autor' => ['required', 'min:5', 'max:255'],
            'genero' => ['required', 'min:5', 'max:50'],
            'ano' => ['required', 'integer', 'min:1'],
        ]);

        // Cria o livro
        $livro = new Livro();
        $livro->titulo = $request->input('titulo');
        $livro->autor = $request->input('autor');
        $livro->genero = $request->input('genero');
        $livro->ano = $request->input('ano');
        $livro->save();

        // Redireciona para a página de listagem de livros
        return redirect()->route('listarLivros');
    }

    public function update(Request $request, Livro $livro)
    {
        $request->validate([
            'titulo' => ['required', 'min:5', 'max:255'],
            'autor' => ['required', 'min:5', 'max:255'],
            'genero' => ['required', 'min:5', 'max:50'],
            'ano' => ['required', 'integer', 'min:1'],
        ]);

        // Atualiza o livro
        $livro->titulo = $request->input('titulo');
        $livro->autor = $request->input('autor');
        $livro->genero = $request->input('genero');
        $livro->ano = $request->input('ano');
        $livro->save();

        // Redireciona para a página de detalhes do livro
        return redirect()->route('book.show', $livro);
}
    public function destroy(Livro $livro)
    {
        // Exclui o livro
        $livro->delete();

        // Redireciona para a página de listagem de livros
        return redirect()->route('listarLivros');
    }

    public function clima(){
        $chave = "3c568311";
        $ip = $_SERVER["REMOTE_ADDR"];

        // URL da API HG Weather com base no IP
        $url = "https://api.hgbrasil.com/weather?key=$chave&user_ip=$ip";

        // Faz a solicitação à API
        $resposta = file_get_contents($url);

        if ($resposta === false) {
            return "Não foi possível obter os dados da cidade e temperatura.";
        }

        // Decodifica a resposta JSON
        $dados = json_decode($resposta, true);

        if (!isset($dados['results'])) {
            return "Dados não encontrados para o IP atual.";
        }

        $temperatura = [
            "cidade" => $dados['results']['city'],
            "temperatura" => $dados['results']['temp']."°"
        ];

        return $temperatura;

    }
}
