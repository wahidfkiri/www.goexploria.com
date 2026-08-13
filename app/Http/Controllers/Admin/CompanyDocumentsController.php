<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Document;
use App\Models\Company;

class CompanyDocumentsController extends Controller
{
    public function index($company_id) {
      #dd($company_id);

      $docs = Document::where('foreign_table', 'company' )
      ->where('foreign_id', $company_id)->get();
      $company = Company::find($company_id);
      return view ('back.company.documents.list', ['company' => $company, 'company_id' => $company_id, 'docs' => $docs]);
    }

    public function add(Request $request, $company_id) {
      $files = $request->file('files');
      foreach($files as $file) {
        $request->file = $file;
        $doc = new Document();
        $doc->setForeign('company', $company_id);
        $doc->set($request);
        $doc->save();

      }
      return back();
    }

    public function getPrivateDocument($company_id, $doc_id) {
      $doc = Document::find($doc_id);
      $file = $doc->getFilePath();

      if (file_exists($file)) {
        var_dump("err");
      }
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime = finfo_file($finfo, $file);
      finfo_close($finfo);

      header('Content-Description: File Transfer');
      header('Content-Type: ' . $mime);
      header('Content-Disposition: inline; filename="'.basename($file).'"');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($file));
      ob_clean();
      flush();
      readfile($file);
      exit;
    }

    public function edit(Request $request, $company_id, $doc_id) {
      $doc = Document::find($doc_id);
      $doc->set($request);
      $doc->save();
      return back();
    }

    public function delete(Request $request, $company_id, $doc_id) {
      $doc = Document::find($doc_id);
      if($doc) {
        $doc->delete();
      }
      return back();
    }
}
