<?php

namespace App\Controllers;

use App\Models\PedomanMagangModel;

class PedomanController extends BaseController
{
    public function download($id)
{
    $pedomanModel = new PedomanMagangModel();
    $pedoman = $pedomanModel->find($id);
    
    if (!$pedoman) {
        return redirect()->back()->with('error', 'File pedoman tidak ditemukan.');
    }

    $filePath = FCPATH . 'uploads/pedoman/' . $pedoman['file_path'];

    if (!file_exists($filePath)) {
        return redirect()->back()->with('error', 'File tidak ditemukan di server.');
    }

    return $this->response->download($filePath, null);
}

}