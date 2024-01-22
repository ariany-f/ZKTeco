<?php
namespace App\Controllers\Panel;

use Src\Classes\{
	Request,
	Controller
};
use App\Models\{
	Client
};

class PendingController extends Controller{
	private $client;

	public function __construct(){
		$this->client = new Client();

		$this->client->verifyPermission('view.pending');
	}

	public function index(){
		$request = new Request();
        print_r('teste');die;
		$builder = $request->except('page');
		$page = $request->input('page') ?? 1;
		$search = $request->input('search');
		$pending = 1;
		$pages = ceil($this->client->search(1, $search, $this->client->count(), $pending)->count() / config('paginate.limit'));

		$clients = $this->client->search($page, $search, null, $pending)->get();

		return view('panel.pending.index', compact('clients', 'pages', 'builder'));
	}

	public function show($id){
		$client = $this->client->findOrFail($id);

		return view('panel.clients.show', compact('client'));
	}

	public function destroy($id){
		$this->client->verifyPermission('delete.clients');
		$client = $this->client->findOrFail($id);

		if($client->delete()){
			redirect(route('panel.clients'), ['success' => 'Cliente deletado com sucesso']);
		}

		redirect(route('panel.clients'), ['error' => 'Cliente NÃO deletado, Ocorreu um erro no processo de exclusão!']);
	}
}