<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BroadcastModel;

class BroadcastController extends BaseController
{
    public function index()
    {
        $model = new BroadcastModel();
        $data['pesan'] = $model->orderBy('created_at', 'DESC')->findAll();
        return view('broadcast_index', $data);
    }

    public function kirim()
    {
        return view('broadcast_kirim');
    }

    public function simpan()
    {
        $model = new BroadcastModel();

        $data = [
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'untuk' => $this->request->getPost('untuk')
        ];

        $model->insert($data);
        return redirect()->to('/admin/broadcast')->with('success', 'Pesan berhasil dikirim.');
    }
}
