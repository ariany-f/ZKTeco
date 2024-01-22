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

		$builder = $request->except('page');
		$page = $request->input('page') ?? 1;
		$search = $request->input('search');
		$pending = 1;
		$pages = ceil($this->client->search(1, $search, $this->client->count(), $pending)->count() / config('paginate.limit'));

		$clients = $this->client->search($page, $search, null, $pending)->get();

		return view('panel.pending.index', compact('clients', 'pages', 'builder'));
	}

	public function approve($id){
        
		$this->client->verifyPermission('edit.pending');
		$client = $this->client->findOrFail($id);

        $data['pending'] = '0';
		if($client->update($data)){
            echo '<pre>';
            print_r($client);die;
			redirect(route('panel.pending'), ['success' => 'Cliente aprovado com sucesso']);
		}

		redirect(route('panel.pending'), ['error' => 'Cliente NÃO aprovado, Ocorreu um erro no processo de atualização!']);
	}
}